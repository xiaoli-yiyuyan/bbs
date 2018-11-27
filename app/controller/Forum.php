<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Page;
use Iam\Request;
use Iam\Response;
use app\common\Ubb;
use Model\Forum as MForum;
use Model\User as MUser;
use Model\ForumReply;
use Model\File;
use Model\Category;
use Model\Message;
use Model\ForumBuy;
use app\Setting;

class Forum extends Common
{
    private $addForumCoin = 0;
    private $addReplyCoin = 0;

    public function __construct()
    {
        parent::__construct();
        $this->addForumCoin = Setting::get('forum_reward');
        $this->addReplyCoin = Setting::get('reply_reward');
    }

    public function index()
    {
        $class_list = Db::table('Category')->where([
            'type' => 1
        ])->select();

        $list = MForum::getList();
        $this->parseList($list);

        View::load('forum/index', [
            'class_list' => $class_list,
            'list' => $list
        ]);
    }

    private function parseList(&$list)
    {
        foreach ($list as &$item) {
            $info = $this->getUserInfo(['photo', 'exp', 'explain'], $item['user_id']);
            $level_info = getUserLevel($info['exp'], $this->upExp);
            $item['nickname'] = $this->getNickname($item['user_id']);
            $item['photo'] = $info['photo'];
            $item['level'] = $level_info['level'];
            $item['context'] = $this->face($item['context']);
            // $timeStamp = strtotime($item['create_time']);
            // $diff = strtotime(now()) - $timeStamp;
            // $diffArr = array('31536000'=>'年','2592000'=>'个月','604800'=>'星期','86400'=>'天','3600' => '小时', '60' => '分钟','1' => '秒');
            // foreach($diffArr as $key => $value){
            //     echo $key;
            //     $modValue = (int) ($diff/$key);
            //     if($modValue > 0){
            //         $item['create_time'] = $modValue.$value."前";
            //         break;
            //     }
            // }
            $item['create_time'] = date('m-d H:i', strtotime($item['create_time']));
        }
    }

    public function list($options)
    {
        $list = MForum::getList($options);
        foreach ($list['data'] as &$item) {
            $item['img_list'] = $this->setViewFiles($item['img_data']);
            $item['file_list'] = $this->setViewFiles($item['file_data']);
        }
        $this->parseList($list['data']);
        return $list;
    }

    public function add2()
    {
        $this->isLogin();
        $classid = Request::get('classid');
        $category = new Category;
        if (!$classInfo = $category->info($classid)) {
            return Page::error('页面未找到！');
        }
        if (Request::isPost()) {
            $post = Request::post(['title', 'context']);

            $data = [
                'title' => $post['title'],
                'context' => $post['context'],
                'user_id' => $this->user['id'],
                'class_id' => $classInfo['id']
            ];

            if (!$id = Db::table('forum')->add($data)) {
                return Response::json(['err' => 1, 'msg' => '添加失败']);
            }

            Url::redirect('/forum/view?id=' . $id);
        } else {
            View::load('forum/add', ['class_info' => $classInfo]);
        }
    }

    public function add($options/*title, context, img_data, file_data, class_id, user_id*/)
    {
        if (!$this->isLogin()) {
            return ['err' => 6, 'msg' => '会员未登录'];
        }

        if (!$class_info = Db::table('category')->where([
            'id' => $options['class_id']
        ])->find()) {
            return ['err' => 1, 'msg' => '帖子发表栏目不存在！'];
        }

        if (!$class_info['user_add'] && !$this->isAdmin($this->user['id'], $class_info['id'])) {
            return ['err' => 2, 'msg' => '该栏目禁止发帖'];

        }

        if (empty($options['title'])) {
            return ['err' => 2, 'msg' => '帖子标题不能为空！'];

        }

        if (empty($options['context'])) {
            return ['err' => 3, 'msg' => '帖子内容不能为空！'];

        }
        // $options['title'] = htmlspecialchars($options['title']);
        // $options['context'] = htmlspecialchars($options['context']);
        
        if (!empty($options['img_data'])) {
            $img_arr = explode(',', $options['img_data']);
            foreach ($img_arr as $item) {
                if (!File::setUserFile($this->user['id'], $item)) {
                    return ['err' => 4, 'msg' => '上传的图片不存在，或者已经被发布。'];
                }
            }
        }

        if (!empty($options['file_data'])) {
            $file_arr = explode(',', $options['file_data']);
            foreach ($file_arr as $item) {
                if (!File::setUserFile($this->user['id'], $item)) {
                    return ['err' => 5, 'msg' => '上传的文件不存在，或者已经被发布。'];
                }
            }
        }

        $data = [
            'title' => $options['title'],
            'context' => $options['context'],
            'user_id' => $this->user['id'],
            'class_id' => $options['class_id'],
            'img_data' => $options['img_data'],
            'file_data' => $options['file_data'],
            'update_time' => now()
        ];

        if (!$id = Db::table('forum')->add($data)) {
            MUser::changeCoin($this->user['id'], $this->addForumCoin);
            return ['err' => 6, 'msg' => '发表失败'];
        }

        return ['id' => $id, 'reward_coin' => $this->addForumCoin];
    }


    public function edit($options/*id, title, context, img_data, file_data, class_id, user_id*/)
    {
        if (!$info = Db::table('forum')->find($options['id'])) {
            return ['err' => 1, 'msg' => '抱歉，你要操作的帖子不存在！'];
        }
        

        if ($info['user_id'] != $this->user['id'] && !$this->isAdmin($this->user['id'], $info['class_id'])) {
            return ['err' => 2, 'msg' => '你无权进行此操作！'];
        }

        $class_id = $info['class_id'];
        if (!empty($options['class_id'])) {

            if (!$class_info = Db::table('category')->where([
                'id' => $options['class_id']
            ])->find()) {
                return ['err' => 3, 'msg' => '帖子发表栏目不存在！'];
            }
            $class_id = $options['class_id'];
    
        }
        if (empty($options['title'])) {
            return ['err' => 4, 'msg' => '帖子标题不能为空！'];

        }

        if (empty($options['context'])) {
            return ['err' => 5, 'msg' => '帖子内容不能为空！'];

        }
        // $options['title'] = htmlspecialchars($options['title']);
        // $options['context'] = htmlspecialchars($options['context']);

        // 检索图片
        $info_img = [];
        $img_arr = [];
        if (!empty($info['img_data'])) {
            $info_img = explode(',', $info['img_data']);
        }
        if (!empty($options['img_data'])) {
            $img_arr = explode(',', $options['img_data']);
        }
        $remove_img = array_diff($info_img, $img_arr);
        $add_img = array_diff($img_arr, $info_img);

        // 检索文件
        $info_file = [];
        $file_arr = [];
        if (!empty($info['file_data'])) {
            $info_file = explode(',', $info['file_data']);
        }
        if (!empty($options['file_data'])) {
            $file_arr = explode(',', $options['file_data']);
        }
        $remove_file = array_diff($info_file, $file_arr);
        $add_file = array_diff($file_arr, $info_file);
        Db::$db->pdo->beginTransaction();
        if (!empty($remove_img)) {
            foreach ($remove_img as $item) {
                File::removeFile($item);
            }
        }
        if (!empty($add_img)) {
            foreach ($add_img as $item) {
                if (!File::setUserFile($this->user['id'], $item)) {
                    Db::$db->pdo->rollback();
                    return ['err' => 4, 'msg' => '上传的图片不存在，或者已经被发布。'];
                }
            }
        }

        if (!empty($remove_file)) {
            foreach ($remove_file as $item) {
                File::removeFile($item);
            }
        }
        if (!empty($add_file)) {
            foreach ($add_file as $item) {
                if (!File::setUserFile($this->user['id'], $item)) {
                    Db::$db->pdo->rollback();
                    return ['err' => 4, 'msg' => '上传的文件不存在，或者已经被发布。'];
                }
            }
        }

        $data = [
            'title' => $options['title'],
            'context' => $options['context'],
            // 'user_id' => $this->user['id'],
            'class_id' => $class_id,
            'img_data' => $options['img_data'],
            'file_data' => $options['file_data'],
            'log' => $info['log'] . '<br>' .$this->user['id'] . ' 修改与: ' . now(),
            'update_time' => now()
        ];

        if (!$id = Db::table('forum')->where(['id' => $info['id']])->update($data)) {
            Db::$db->pdo->rollback();
            return ['err' => 6, 'msg' => '修改失败'];
        }
        Db::$db->pdo->commit();
        return ['id' => $options['id']];
    }

    // 回收状态码
    private $rec_code = 9999;

    public function remove($options/*id*/)
    {
        if (!$info = Db::table('forum')->find($options['id'])) {
            return ['err' => 1, 'msg' => '抱歉，你要操作的帖子不存在！'];
        }
        Db::table('forum')->where(['id' => $options['id']])->update(['status' => $this->rec_code]);
        Db::table('forum_reply')->where(['forum_id' => $options['id']])->update(['status' => $this->rec_code]);
        return ['class_id' => $info['class_id']];
    }

    public function view($options/*['id', is_html, is_ubb]*/)
    {
        if (!$info = Db::table('forum')->find($options['id'])) {
            return ['err' => 1, 'msg' => '抱歉，你要查看的帖子不存在！'];
        }
        
        if (!$forum_user = Db::table('user')->find($info['user_id'])) {
            return ['err' => 2, 'msg' => '楼主信息异常，暂时无法查看该帖子！'];
        }

        if (!$class_info = Db::table('category')->where([
            // 'type' => 1,
            'id' => $info['class_id']
        ])->find()) {
            return ['err' => 3, 'msg' => '帖子发表栏目不存在，暂时无法查看该帖子！'];
        }
        $this->viewInfo = $info;
        
        $info['img_list'] = $this->setViewFiles($info['img_data']);
        $info['file_list'] = $this->setViewFiles($info['file_data']);

        $class_info['is_admin'] = $this->isAdmin($this->user['id'], $class_info['id']);

        // 启用HTML过滤
        $is_html = $class_info['is_html'];
        if ($options['is_html'] != '') {
            $is_html = $options['is_html'];
        }
        if (!empty($is_html)) {
            $info['title'] = htmlspecialchars($info['title']);
            $info['context'] = htmlspecialchars($info['context']);
            $info['context'] = str_replace(chr(13).chr(10), '<br>', $info['context']);
            $info['context'] = str_replace(chr(32), '&nbsp;', $info['context']);
        }

        // 启用UBB语法
        $is_ubb = $class_info['is_ubb'];
        if ($options['is_ubb'] != '') {
            $is_ubb = $options['is_ubb'];
        }
        if (!empty($is_ubb)) {
            $info['context'] = $this->rule($info['context'], $info['id'], $info['user_id']);
            $info['context'] = $this->setViewImages($info['context'], $info['img_data']);
        }
        
        $info['strip_tags_context'] = str_replace('&nbsp;', chr(32), $info['context']);
        $info['strip_tags_context'] = strip_tags($info['strip_tags_context']);
        $info['strip_tags_context'] = preg_replace('/\s+/', ' ', $info['strip_tags_context']);
        $info['keywords'] = getKeywords($info['title'], $info['strip_tags_context']);

        Db::query('UPDATE `forum` SET `read_count` = `read_count` + 1 WHERE `id` = ?', [$options['id']]);
        return ['err' => 0, 'info' => $info, 'user' => $forum_user, 'class_info' => $class_info];
    }

    /**
     * 论坛UBB
     */
    private function rule($content, $id, $user_id)
    {
        $content = preg_replace_callback('/\[read_login\](.*?)\[\/read_login\]/', function($matches) {
            if ($this->isLogin()) {
                return $matches[1];
            }
            return Ubb::getTips('此内容<a href="/user/login">登录</a>可见', 'read_login');
        }, $content);
        
        $content = preg_replace_callback('/\[read_reply\](.*?)\[\/read_reply\]/', function($matches) use($user_id) {
            $reply = ForumReply::get([
                'user_id' => $this->user['id'],
                'forum_id' => $this->viewInfo['id']
            ]);
            if ($user_id == $this->user['id'] || $reply) {
                return $matches[1];
            }
            return Ubb::getTips('此内容 <span>评论</span> 可见', 'read_reply');
        }, $content);

        $content = preg_replace_callback('/\[read_buy_(\d+)\](.*?)\[\/read_buy_\1\]/', function($matches) use($id, $user_id) {
            if ($user_id == $this->user['id'] || $this->isBuy($id)) {
                return $matches[2];
            }
            return Ubb::getTips('此内容需要花费 <span>' . $matches[1] . '</span> 金币 <a href="/forum/forum_buy?id=' . $id . '">购买</a>', 'read_buy');
        }, $content);
        return $content;
    }

    /**
     * 判断是否已经购买
     */
    private function isBuy($id)
    {
        return ForumBuy::get(['forum_id' => $id, 'user_id' => $this->user['id']]);
    }

    /**
     * 购买内容
     */
    public function forumBuy()
    {
        $id = Request::get('id');
        if (!$forum = MForum::get($id)) {
            return Page::error('购买失败！');
        }
        $content = $forum['context'];
        $content = preg_match('/\[read_buy_(\d+)\](.*?)\[\/read_buy_\1\]/', $content, $matches);
        if (empty($matches)) {
            return Page::error('购买失败！');
        }
        if ($matches <= 0) {
            return Page::error('购买失败！');
        }
        if ($buy = ForumBuy::get(['forum_id' => $id, 'user_id' => $this->user['id']])) {
            return Page::error('购买失败！');
        }

        if (!MUser::changeCoin($this->user['id'], -$matches[1])) {
            return Page::error('购买失败！余额不足');
        }

        ForumBuy::create([
            'forum_id' => $id,
            'user_id' => $this->user['id'],
            'coin' => $matches[1]
        ]);
        return Page::success('购买成功！', '/forum/view?id=' . $id);
    }

    public function setViewImages($context, $img_data)
    {
        if (!empty($img_data)) {
            $img_arr = explode(',', $img_data);
            foreach ($img_arr as $key => $value) {
                $file = Db::table('file')->find($value);
                $context = str_replace("[img_{$key}]", "<img src=\"{$file['path']}\" alt=\"{$file['name']}\">",$context);
            }
        }
        return $context;
    }

    public function setViewFiles($file_data)
    {
        $file_list = [];
        if (!empty($file_data)) {
            $file_arr = explode(',', $file_data);
            foreach ($file_arr as $key => $value) {
                $file = Db::table('file')->find($value);
                $file['format_size'] = byteFormat($file['size']);
                $file_list[] = $file;
            }
        }
        return $file_list;
    }

    public function replyList($options)
    {
        $list = ForumReply::getList($options);
        $this->parseList($list['data']);
        return $list;
    }
    public function reply()
    {
        $forumid = Request::get('id');
        if (!$forumid) {
            $forumid = 0;
        }
        if (!$info = Db::table('forum')->find($forumid)) {
            return Page::error('帖子未找到！');
        }

        if (!$forum_user = Db::table('user')->find($info['user_id'])) {
            return Page::error('楼主失踪！');
        }

        if (!$class_info = Db::table('Category')->where([
            'type' => 1,
            'id' => $info['class_id']
        ])->find()) {
            return Page::error('帖子暂时无法查看！');
        }
        $info['context'] = htmlspecialchars($info['context']);
        $info['context'] = str_replace(chr(10), '<br>', $info['context']);
        $info['context'] = str_replace(chr(13), '<br>', $info['context']);
        $info['context'] = str_replace(chr(32), '&nbsp;', $info['context']);



        $count = Db::table('forum_reply')->field('count(1) as count')->where(['forum_id' => $forumid])->find()['count'];

        $nowPage = Request::get('p') ? Request::get('p') : 1;

        $page = new Page([
            'count' => $count,
            'p' => $nowPage,
            'path' => '/forum/reply',
            'query' => ['id' => $forumid],
            'pagesize' => 10
        ]);
        $page = $page->parse();

        $list = ForumReply::getList($forumid, $page['page'], $page['pagesize']);
        $this->parseList($list);
        View::load('forum/reply', [
            'class_info' => $class_info,
            'forum_info' => $info,
            'forum_user' => $forum_user,
            'list' => $list,
            'page' => $page
        ]);
    }

    public function replyAdd($options/*forum_id, $user_id, $context*/)
    {
        
        if (!$this->isLogin()) {
            return ['err' => 1, 'msg' => '会员未登录'];
        }

        if (empty($options['context'])) {
            return ['err' => 2, 'msg' => '回复内容不能为空哦！'];
        }
        $forum_id = $options['forum_id'];
        if (!$forum = Db::table('forum')->find($forum_id)) {
            return ['err' => 3, 'msg' => '回复的主题可能已经删除或不存在！'];
        }
        $reply_id = Db::table('forum_reply')->add([
            'forum_id' => $forum_id,
            'user_id' => $this->user['id'],
            'context' => htmlspecialchars($options['context'])
        ]);
        Db::query('UPDATE `forum` SET `reply_count` = `reply_count` + 1 WHERE `id` = ?', [$forum_id]);
        if ($this->user['id'] != $forum['user_id']) {
            MUser::changeCoin($this->user['id'], $this->addReplyCoin);
            $content = '<a href="/user/show?id=' . $this->user['id'] . '">' .$this->user['nickname'] . '</a> 评论了你的主题，快去<a href="/forum/view?id=' . $forum_id . '">查看</a>吧！';
            Message::create(0, $forum['user_id'], $content);
        }

        return ['forum_id' => $forum_id, 'reply_id' => $reply_id, 'reward_coin' => $this->addReplyCoin];
    }

    public function myList()
    {
        $this->isLogin();

        $count = Db::table('forum')->field('count(1) as count')->where(['user_id' => $this->user['id']])->find()['count'];

        $nowPage = Request::get('p') ? Request::get('p') : 1;

        $page = new Page([
            'count' => $count,
            'p' => $nowPage,
            'path' => '/forum/my_list',
            // 'query' => ['id' => $id],
            'pagesize' => 10
        ]);
        $page = $page->parse();
        $list = MForum::getList(['user_id' => $this->user['id'], 'page' => $page['page'], 'pagesize' => $page['pagesize']]);
        $this->parseList($list);
        View::load('forum/myList', [
            'list' => $list,
            'page' => $page
        ]);
    }
    
    private $faceCode = [
        '爱你' => 'aini.gif',
        '抱抱' => 'baobao.gif',
        '不活了' => 'buhuole.gif',
        '不要' => 'buyao.gif',
        '超人' => 'chaoren.gif',
        '大哭' => 'daku.gif',
        '嗯嗯' => 'enen.gif',
        '发呆' => 'fadai.gif',
        '飞呀' => 'feiya.gif',
        '奋斗' => 'fendou.gif',
        '尴尬' => 'ganga.gif',
        '感动' => 'gandong.gif',
        '害羞' => 'haixiu.gif',
        '嘿咻' => 'heixiu.gif',
        '画圈圈' => 'huaquanquan.gif',
        '惊吓' => 'jinxia.gif',
        '敬礼' => 'jingli.gif',
        '快跑' => 'kuaipao.gif',
        '路过' => 'luguo.gif',
        '抢劫' => 'qiangjie.gif',
        '杀气' => 'shaqi.gif',
        '上吊' => 'shangdiao.gif',
        '调戏' => 'tiaoxi.gif',
        '跳舞' => 'tiaowu.gif',
        '万岁' => 'wanshui.gif',
        '我走了' => 'wozoule.gif',
        '喜欢' => 'xihuan.gif',
        '吓死人' => 'xiasiren.gif',
        '嚣张' => 'xiaozhang.gif',
        '疑问' => 'yiwen.gif',
        '做操' => 'zuocao.gif',
    ];

    private function face($context)
    {
        foreach ($this->faceCode as $key => $value) {
            $context = str_replace("[表情:{$key}]", "<img class=\"face-chat\" src=\"/static/images/face/{$value}\" alt=\"{$key}\">", $context);
        }
        return $context;
    }

    public function imagecropper($path = '')
    {
        imagecropper($path, 200, 200);
    }
}