<?php
namespace app;

use think\Db;
use Iam\Url;
use Iam\View;
use Iam\Page;
use Iam\Request;
use Iam\Response;
use Iam\Image;
use comm\core\Ubb;
use Model\Forum as MForum;
use Model\User as MUser;
use Model\ForumReply;
use Model\File;
use Model\Category;
use Model\Message;
use Model\ForumBuy;
use Model\ForumMark;
use Model\Friend;
use Model\ForumMarkBody;
use \comm\Setting;

class Forum extends \comm\core\Home
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
            $info = $this->getUserInfo($item['user_id']);
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
            // $item['create_time'] = date('m-d H:i', strtotime($item['create_time']));
        }
    }

    public function listData($id = '')
    {
        $list = MForum::getList(['id' =>$id]);
        foreach ($list['data'] as &$item) {
            $item['img_list'] = $this->setViewFiles($item['img_data']);
            $item['file_list'] = $this->setViewFiles($item['file_data']);
        }
        $this->parseList($list['data']);
        return $list;
    }

    
    /**
     * 论坛列表
     */
    public function list($id = '', $order = 1, $type = 0)
    {   
        $page = Request::get('page');
        $list = source('/api/Forum/list', [
            'class_id' => $id,
            'page' => $page,
            'order' => $order,
            'type' => $type
        ]);
        $class_info = Category::get($id);
        $list->appends('id', $id);

        $replyCount = ForumReply::where('forum_id', 'IN', function($query) use($id) {
            return $query->table('forum')->field('id')->where('class_id', $id);
        })->count();

        View::load('forum/list', [
            'list' => $list,
            'class_info' => $class_info,
            'reply_count' => $replyCount,
            'order' => $order,
            'type' => $type
        ]);
    }

    public function addPage($class_id = '')
    {
        $this->isLogin();
        // 如果传入指定栏目
        if (!empty($class_id)) {
            if (!$class_info = Category::get($class_id)) {
                return Page::error('页面未找到！');
            }
            
            if (!$class_info['user_add'] && !$this->isAdmin($this->user['id'], $class_info['id'])) {
                return Page::error('该栏目禁止发帖');
            }
            View::data('column_info', $class_info);
        }

        $column = Category::where('user_add', 1)->column('id,title');

        View::load('forum/add_page', [
            'column' => $column
        ]);
    }

    /**
     * 发布帖子
     */
    public function ajaxAdd($class_id = '', $title = '', $context = '', $img_data = '', $file_data = '', $mark_body = '')
    {
        // source('/api/Forum/add');
        if (!$this->isLogin()) {
            return Response::json(['err' => 6, 'msg' => '会员未登录']);
        }

        if (!$class_info = Category::get($class_id)) {
            return Response::json(['err' => 1, 'msg' => '帖子发表栏目不存在！']);
        }

        if (!$class_info['user_add'] && !$this->isAdmin($this->user['id'], $class_info['id'])) {
            return Response::json(['err' => 2, 'msg' => '该栏目禁止发帖']);
        }

        if (empty($title)) {
            return Response::json(['err' => 2, 'msg' => '帖子标题不能为空！']);
        }

        if (empty($context)) {
            return Response::json(['err' => 3, 'msg' => '帖子内容不能为空！']);

        }

        if (!empty($img_data)) {
            $img_arr = explode(',', $img_data);
            foreach ($img_arr as $item) {
                if (!File::setUserFile($this->user['id'], $item)) {
                    return Response::json(['err' => 4, 'msg' => '上传的图片不存在，或者已经被发布。']);
                }
                
                if (Setting::get('forum_water_mark_status') == '1' && $file = File::get($item)) {
                    $image = new Image;
                    $image->imageMark($file['path'], Setting::get('forum_water_mark_path'));
                }

            }
        }

        if (!empty($file_data)) {
            $file_arr = explode(',', $file_data);
            foreach ($file_arr as $item) {
                if (!File::setUserFile($this->user['id'], $item)) {
                    return Response::json(['err' => 5, 'msg' => '上传的文件不存在，或者已经被发布。']);
                }
            }
        }

        
        $data = [
            'title' => $title,
            'context' => $context,
            'user_id' => $this->user['id'],
            'class_id' => $class_id,
            'img_data' => $img_data,
            'file_data' => $file_data,
            'update_time' => now(),
            'active_time' => now(),
        ];

        if ($class_info['is_auto'] == 1) {
            $data['status'] = 1;
        }

        if (!$id = MForum::create($data)) {
            return Response::json(['err' => 1, 'msg' => '添加失败']);
        }
        

        if (!empty($mark_body)) {
            $mark_arr = explode(',', $mark_body);
            foreach ($mark_arr as $item) {
                if (ForumMark::get($item)) {
                    ForumMarkBody::create([
                        'forum_id' => $id->id,
                        'mark_id' => $item
                    ]);
                }
            }
        }

        MUser::changeCoin($this->user['id'], $this->addForumCoin);
        return Response::json(['id' => $id->id, 'reward_coin' => $this->addForumCoin]);
    }

    /**
     * 帖子编辑逻辑
     */
    public function ajaxEdit($id = '', $title = '', $context = '', $img_data = '', $file_data = '', $class_id = '', $mark_body = '')
    {
        
        if (!$forum = MForum::get($id)) {
            return Response::json(['err' => 1, 'msg' => '抱歉，你要操作的帖子不存在！']);
        }
        
        if (!empty($class_id) && !$class_info = Category::get($class_id)) {
            return Response::json(['err' => 1, 'msg' => '帖子发表栏目不存在！']);
        }

        $isAdmin = !$this->isAdmin($this->user['id'], $forum['class_id']);

        if(!$class_info['user_add'] && $isAdmin){
            return Response::json(['err' => 2, 'msg' => '移动到的栏目仅VIP方能操作']);
        }

        if ($forum['user_id'] != $this->user['id'] && !$forum->class_info->isBm($user_id)) {
            return Response::json(['err' => 2, 'msg' => '你无权进行此操作！']);
        }

        if (empty($title)) {
            return Response::json(['err' => 2, 'msg' => '帖子标题不能为空！']);
        }

        if (empty($context)) {
            return Response::json(['err' => 3, 'msg' => '帖子内容不能为空！']);
        }

        // 检索图片
        $info_img = [];
        $img_arr = [];
        if (!empty($forum['img_data'])) {
            $info_img = explode(',', $forum['img_data']);
        }
        if (!empty($img_data)) {
            $img_arr = explode(',', $img_data);
        }
        $remove_img = array_diff($info_img, $img_arr);
        $add_img = array_diff($img_arr, $info_img);

        // 检索文件
        $info_file = [];
        $file_arr = [];
        if (!empty($forum['file_data'])) {
            $info_file = explode(',', $forum['file_data']);
        }
        if (!empty($file_data)) {
            $file_arr = explode(',', $file_data);
        }
        $remove_file = array_diff($info_file, $file_arr);
        $add_file = array_diff($file_arr, $info_file);

        Db::startTrans();
        if (!empty($remove_img)) {
            foreach ($remove_img as $item) {
                File::removeFile($item);
            }
        }
        if (!empty($add_img)) {
            foreach ($add_img as $item) {
                if (!File::setUserFile($this->user['id'], $item)) {
                    Db::rollback();
                    return Response::json(['err' => 4, 'msg' => '上传的图片不存在，或者已经被发布。']);
                }
                
                if (Setting::get('forum_water_mark_status') == '1' && $file = File::get($item)) {
                    $image = new Image;
                    $image->imageMark($file['path'], Setting::get('forum_water_mark_path'));
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
                    Db::rollback();
                    return Response::json(['err' => 4, 'msg' => '上传的文件不存在，或者已经被发布。']);
                }
            }
        }

        $data = [
            'title' => $title,
            'context' => $context,
            'class_id' => $class_id,
            'img_data' => $img_data,
            'file_data' => $file_data,
            'log' => $forum['log'] . '<br>' .$this->user['id'] . ' 修改与: ' . now(),
            'update_time' => now()
        ];
        // print_r($data);
        // die();

        if ($class_info['is_auto'] == 1) {
            $data['status'] = 1;
        }
        
        if (!$result = MForum::where(['id' => $forum['id']])->update($data)) {
            Db::rollback();
            return Response::json(['err' => 6, 'msg' => '修改失败']);
        }
        
        Db::commit();
        return Response::json(['id' => $id]);
    }

    // 回收状态码
    private $rec_code = 9999;

    public function ajaxRemove($id = '')
    {
        if (!$info = MForum::get($id)) {
            return Response::json(['err' => 1, 'msg' => '抱歉，你要操作的帖子不存在！']);
        }
        if ($info->user_id != $this->user['id'] && !$info->class_info->isBm($this->user['id'])) {
            return Response::json(['err' => 1, 'msg' => '操作失败']);
        }
        $info->status = $this->rec_code;
        $info->save();
        ForumReply::where('forum_id', $id)->update(['status' => $this->rec_code]);
        return Response::json(['class_id' => $info->class_id]);
    }

    /**
     * 帖子编辑
     */
    public function editPage($id = '')
    {
        if (!$forum = MForum::get($id)) {
            return Page::error('要查看的内容不存在！');
        }
        
        if ($forum->user_id != $this->user['id'] && !$forum->class_info->isBm($this->user['id'])) {
            return Response::json(['err' => 1, 'msg' => '操作失败']);
        }
        $forum->append(['class_info']);
        $navList = Category::where('user_add', 1)->where('id', '<>', $forum->class_id)->column('id,title');
        $forum['context'] = $forum->setViewImages($forum['context']);
        View::load('forum/edit_page', [
            'forum' => $forum,
            'navList' => $navList
        ]);
    }

    /**
     * 查看帖子详细
     */
    public function view($id = '', $page = 1)
    {
        $forum = source('/api/Forum/view', ['id' => $id], $api);
        if ($error = $api->error()) {
            return Page::error($error['message']);
        }
        // 获取回复数据
        $forum_reply = source('/api/ForumReply/list', ['forum_id' => $id,'page' => $page, 'pagesize' => 20]);
        $forum_reply->appends('id', $forum['id']);
        // 获取粉丝数
        $fans_count = source('/api/Friend/fansCount', ['user_id' => $forum->user_id]);
        View::load('forum/view', [
            'forum' => $forum,
            'forum_reply' => $forum_reply,
            'fans_count' => $fans_count
        ]);
    }

    public function replyList($options)
    {
        $list = ForumReply::getList($options);
        $this->parseList($list['data']);
        return $list;
    }   
    public function replyArtList()
    {
        if (!$this->isLogin()) {
            return Page::error('会员未登录');
        }
        View::load('forum/reply_list');
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

    private $reply_time_diff = 2;

    /**
     * 回复帖子
     */
    public function replyAdd($id = '', $context = '', $alt = '')
    {
        if (!$this->isLogin()) {
            return Page::error('会员未登录');
        }

        if (empty($context)) {
            return Page::error('回复内容不能为空哦！');
        }

        if (!$forum = MForum::get($id)) {
            return Page::error('回复的主题可能已经删除或不存在！');
        }

        if ($new_reply = ForumReply::order('id desc')->get([
            'forum_id' => $forum['id'],
            'user_id' => $this->user['id'],
        ])) {
            if (time() - strtotime($new_reply->create_time) < $this->reply_time_diff) {
                return Page::error('访问过于频繁！');
            }
        }
        $context = htmlspecialchars($context);
        $pattern = '/\[@:(\d+)]/';

        preg_match_all($pattern, $context, $matTags);

        $alt_user = array_unique($matTags[1]);
        foreach ($alt_user as $item) {
            if ($item == $this->user['id']) {
                continue;
            }
            $sys_message = '<a href="' . href('/user/show?id=' . $this->user['id']) . '">' .$this->user['nickname'] . '</a> 在《<a href="' . href('/forum/view?id=' . $id) . '">' . $forum->title . '</a>》中召唤你，快去<a href="' . href('/forum/view?id=' . $id) . '">查看</a>吧！';
            Message::send(0, $item, $sys_message);
        }
        $forum_reply = ForumReply::create([
            'forum_id' => $id,
            'user_id' => $this->user['id'],
            'context' => $context
        ]);
        $forum->active_time = now();
        $forum->reply_count = $forum->reply_count + 1;
        $forum->save();
        
        if ($this->user['id'] != $forum['user_id']) {
            MUser::changeCoin($this->user['id'], $this->addReplyCoin);
            $content = '<a href="' . href('/user/show?id=' . $this->user['id']) . '">' .$this->user['nickname'] . '</a> 评论了你的主题，快去<a href="' . href('/forum/view?id=' . $id) . '">查看</a>吧！';
            Message::send(0, $forum['user_id'], $content);
        }
        return Page::success('评论成功 金币+' . $this->addReplyCoin, '/forum/view?id=' . $id);
        // return Url::redirect('/forum/view?id=' . $id);
    }

    public function myList()
    {
        if (!$this->isLogin()) {
            return Page::error('会员未登录');
        }

        View::load('forum/my_list');
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

    public function imagecropper($path = '', $count = 3)
    {
        $maxCount = 3;
        $width = 160;
        $height = 160;
        $width = $width * $maxCount / $count;
        imagecropper($path, $width, $height);
    }

    public function search($keyword = '', $mark_id = '')
    {
        if ($keyword === '' && $mark_id === '') {
            return Page::error('请输入您要搜索的关键词！');
        }
        if ($keyword) {
            $list = MForum::search($keyword);
        } else {
            $list = MForum::searchByMark($mark_id);
        }
        View::load('forum/search', [
            'list' => $list
        ]);
    }

    public function list3($type = '', $id = '')
    {
        $common = CommonPublic::instance();

        $forum = Forum::field('id,user_id,title,context,img_data,file_data, reply_count')->where('status', '<>', 9999);//->order('id', 'desc')->paginate(10);
        if ($type == 1) {
            // 关注
            $forum->where('user_id', 'IN', function($query) use($common) {
                $query->table('friend')->where('user_id', $common->user['id'])->field('id');
            })->order('id', 'desc');
        } elseif ($type == 2) {
            // 热度
            $forum->order('read_count', 'desc');
        } elseif ($type == 3) {
            // 精华
            $forum->order('id', 'asc');
        } elseif ($type === 0) {
            // 推荐
            $forum->order('id', 'desc');
        }
        if ($id !== '') {
            $forum->where('class_id', $id);
        }
        $forum = $forum->paginate(10);
        $forum->append(['author', 'mini_context', 'img_list', 'file_list']);
        $forum->hidden(['context']);
        // print_r(Db::getLastSql());
        return $forum;
    }

    public function getListByUserId($user_id = '')
    {
        $forum = MForum::field('id,user_id,class_id,title,context,img_data,file_data,reply_count,create_time')->where('status', '<>', 9999);
        $forum->where('user_id', $user_id);
        $forum->order('id', 'desc');
        $list = $forum->paginate(Setting::get('pagesize'));
        $list->append(['author', 'mini_context', 'img_list', 'file_list', 'class_info']);
        $list->hidden(['context']);
        return Response::json($list);
    }

    /**
     * ajax上传文件接口
     */
    public function ajaxUpload()
    {
        if (!$this->isLogin()) {
            return Response::json(['err' => 1, 'msg' => '会员未登录']);
        }
        $res = source('app/File/upload',[
            'user_id' => $this->user['id'],
            'path' => '/upload/forum',
            'input_name' => 'file'
        ]);
        return Response::json($res);
    }

    /**
     * 置顶与取消
     * 加精与取消
     */
    public function topCreamWay($id = '', $way = 'top')
    {
        if(!$forum = MForum::get($id)){
           return Page::error("该帖子不存在");
        }
        if(!$this->isAdmin($this->user['id'], $forum->class_id)){
            return Page::error("您没有权限修改");
        }

        if($way == 'top'){
            $result = $forum->setTop();
        } else {
            $result = $forum->setCream();
        }

        if(!$result){
           return Page::error("设置失败");
        }
        return Page::success('设置成功', '');
    }

    /**
     * 标签检索
     * @param string $title 标签名
     */
    public function markCheck($title = '')
    {
        if (!$this->isLogin()) {
            return Page::error('会员未登录');
        }

        if (empty($title)) {
            return Page::error('回复内容不能为空哦！');
        }

        if (!$mark = ForumMark::get(['title' => $title])) {
            $mark = ForumMark::create([
                'title' => $title,
                'user_id' => $this->user['id']
            ]);
            $mark = ForumMark::get($mark->id);
        }
        // print_r($mark);
        $mark->visible(['id', 'title', 'status']);
        return Response::json($mark->toArray());
    }
}