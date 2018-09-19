<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Page;
use Iam\Request;
use Iam\Response;
use Model\Forum as MForum;
use Model\ForumReply;
use Model\File;
use Model\Category;

class Forum extends Common
{
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
            $timeStamp = strtotime($item['create_time']);
            $diff = strtotime(now()) - $timeStamp;
            $diffArr = array('31536000'=>'年','2592000'=>'个月','604800'=>'星期','86400'=>'天','3600' => '小时', '60' => '分钟','1' => '秒');
            foreach($diffArr as $key => $value){
                echo $key;
                $modValue = (int) ($diff/$key);
                if($modValue > 0){
                    $item['create_time'] = $modValue.$value."前";
                    break;
                }
            }
            // $item['create_time'] = date('m-d H:i', strtotime($item['create_time']));
        }
    }

    public function list($options)
    {
        $list = MForum::getList($options);
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
            return ['err' => 6, 'msg' => '发表失败'];
        }

        return ['id' => $id];
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
            'user_id' => $this->user['id'],
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
        if (!empty($class_info['is_html'])) {
            $info['title'] = htmlspecialchars($info['title']);
            $info['context'] = htmlspecialchars($info['context']);
            $info['context'] = str_replace(chr(10), '<br>', $info['context']);
            $info['context'] = str_replace(chr(13), '<br>', $info['context']);
            $info['context'] = str_replace(chr(32), '&nbsp;', $info['context']);
        }

        // 启用UBB语法
        if (!empty($class_info['is_ubb'])) {
            $info['context'] = $this->setReadRule($info['context']);
            $info['context'] = $this->setViewImages($info['context'], $info['img_data']);
        }
        Db::query('UPDATE `forum` SET `read_count` = `read_count` + 1 WHERE `id` = ?', [$options['id']]);

        return ['err' => 0, 'info' => $info, 'user' => $forum_user, 'class_info' => $class_info];
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

    private $tagFix = [
        'begin' => '\[',
        'end'   => '\]'
    ];

    private $tags = [
        'read' => [
            'name' => ['查看', 'read'],
            'value' => [
                'login' => ['登录', 'login'],
                'reply' => ['回复', 'reply'],
                'vip' => ['vip']
            ]
        ]
    ];

    /**
     * 字符串替换 避免正则混淆
     * @access private
     * @param string $str
     * @return string
     */
    private function stripPreg($str)
    {
        return str_replace(
            ['{', '}', '(', ')', '|', '[', ']', '-', '+', '*', '.', '^', '?', '/'],
            ['\{', '\}', '\(', '\)', '\|', '\[', '\]', '\-', '\+', '\*', '\.', '\^', '\?', '\/'],
            $str);
    }

    private function parseTags()
    {
        $tags = [];
        $params = [];
        foreach ($this->tags as $action => $value) {
            foreach ($value['name'] as $name) {
                foreach ($value['value'] as $param => $word) {
                    foreach ($word as $item) {
                        $begin = "{$this->tagFix['begin']}({$name})=({$item}){$this->tagFix['end']}";
                        $end = "{$this->tagFix['begin']}\/({$name}){$this->tagFix['end']}";
                        $tags[] = [
                            'tag' => [$begin, $end],
                            'action' => $action,
                            'param' => $param
                        ];
                    }
                }
            }
        }
        return $tags;
    }

    public function setReadRule($context)
    {
        // $pattern = [];

        // $tags = $this->parseTags();
        // foreach ($tags as $item) {
        //     // $item['tag'][0] = $this->stripPreg($item['tag'][0]);
        //     // $item['tag'][1] = $this->stripPreg($item['tag'][1]);
        //     $pattern[] = $item['tag'][0];
        //     if (!in_array($item['tag'][1], $pattern)) {
        //         $pattern[] = $item['tag'][1];
        //     }
        // }
        // $pattern = '/' . implode('|', $pattern) . '/';
        $pattern = '/\[(查看|read)=(登录|login|回复|reply|vip,\d+)\]|\[\/(查看|read)\]/';

        $context_arr = [];

        // $matContext = preg_split($pattern, $context);
        
        preg_match_all($pattern, $context, $matTags, PREG_SET_ORDER);

        $length = count($matTags);
        for ($i = 0; $i < $length; $i ++) {
            if (count($matTags[$i]) == 4) {
                continue;
            }
            $time = 0;
            $n = 0;
            for ($_i = $i; $_i < $length; $_i ++) {
                if (count($matTags[$_i]) == 4) {
                    $time --;
                } else {
                    $time ++;
                    $n ++;
                }
                $rule_data = $matTags[$i];
                $first = mb_strpos($context, $rule_data[0]);

                if ($time == 0) {
                    $end = strNPos($context, $matTags[$_i][0], $n);
                    // print_r($end);die();
                    $over_len = $end + mb_strlen($matTags[$_i][0]);

                    $i1 = $first + mb_strlen($rule_data[0]);
                    $i2 = $end - $i1;
                    $cut = mb_substr($context, $i1, $i2);
                    $c1 = $this->checkRule($cut, $rule_data[1], $rule_data[2]);
                    $context = mb_substr($context, 0, $first) . $c1 . mb_substr($context, $over_len);
                    return $this->setReadRule($context);
                    // $context;
                    break;
                }
            }
        }
        return $context;
    }

    private function checkRule($context, $action, $param)
    {
        $params = explode(',', $param);

        foreach ($this->tags as $action => $value) {
            // 判断类型
            if (in_array($action, $value['name'])) {
                foreach ($value['value'] as $param => $word) {
                    // 判断参数
                    if (in_array($params[0], $word)) {
                        return $this->runReadRule($param, $params, $context);
                    }
                }
            }
        }
    }

    private function runReadRule($param, $params, $context)
    {
        if ($this->viewInfo['user_id'] !== $this->user['id']) {
            if ($param == 'login') {
                if (!$this->isLogin()) {
                    $context = '【此内容需要登陆以后浏览】';
                }
            } elseif ($param == 'reply') {
                $list = $this->replyList([
                    'user_id' => $this->user['id'],
                    'forum_id' => $this->viewInfo['id']
                ]);
                if ($list['page']['count'] == 0) {
                    $context = '【此内容需要回复以后浏览】';
                }
            } elseif ($param == 'vip') {
                if (empty($this->user['vip_level']) || $this->user['vip_level'] < $params[1]) {
                    $context = '【此内容仅限 VIP' . $params[1] . ' 可浏览】';
                }
            }
        }
        return $context;
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
        if (!Db::table('forum')->find($forum_id)) {
            return ['err' => 3, 'msg' => '回复的主题可能已经删除或不存在！'];
        }
        $reply_id = Db::table('forum_reply')->add([
            'forum_id' => $forum_id,
            'user_id' => $this->user['id'],
            'context' => htmlspecialchars($options['context'])
        ]);
        Db::query('UPDATE `forum` SET `reply_count` = `reply_count` + 1 WHERE `id` = ?', [$forum_id]);
        return ['forum_id' => $forum_id, 'reply_id' => $reply_id];
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

    private function face($context){
        foreach ($this->faceCode as $key => $value) {
            $context = str_replace("[表情:{$key}]", "<img class=\"face-chat\" src=\"/static/images/face/{$value}\" alt=\"{$key}\">", $context);
        }
        return $context;
    }
}