<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Page;
use Iam\AppApi;
use Iam\Request;
use Iam\Response;

class Chat extends \comm\core\Home
{
    public function __construct()
    {
        parent::__construct();
        if (Request::get('appid')) {
            $get = Request::get();
            $data = Request::post();
            AppApi::app('chat')->check($get, $data);
        }
    }

    public function add()
    {
        if (Request::isPost()) {
            $post = Request::post(['touserid', 'content', 'classid']);
            $chat = new \Model\Chat;
            if (!$chat->add($post)) {
                return Response::json(['err' => 1, 'msg' => '添加失败']);
            }
            return Response::json(['err' => 0]);
        }

        // View::load('Chat/add');
    }

    public function room()
    {
        $classid = Request::get('id');
        $category = new \Model\Category;
        if (!$classInfo = $category->info($classid)) {
            return Page::error('页面未找到！');
        }
        // if ($classInfo['type'] != 'chat') {
        //     return Page::error('页面未找到！');
        // }
        View::load('chat/room', ['classInfo' => $classInfo]);
    }

    public function fistList()
    {
        $classid = Request::get('classid');
        $chat = new \Model\Chat;
        $list = $chat->listIdDesc($classid);
        $this->parseView($list);

        return Response::json($list);
    }

    public function newList()
    {
        $classid = Request::get('classid');
        $lastid = Request::get('lastid');

        $chat = new \Model\Chat;
        longPolling(function() use($chat, $classid, $lastid)
        {
            $list = $chat->listIdNew($classid, $lastid);
            $this->parseView($list);
            if (!empty($list)) {
                Response::json($list);
                return 1;
            }
        });
    }

    public function sendMsg()
    {
        if (Request::isPost()) {
            if ($this->user['id'] == 0) {
                return Response::json(['err' => 1, 'msg' => '请先登录后在发言！']);
            }

            $classid = Request::get('classid');
            $post = Request::post(['touserid', 'content']);
            $chat = new \Model\Chat;
            if (!$chat->add($this->user['id'], $post['touserid'], $classid, $post['content'])) {
                return Response::json(['err' => 1, 'msg' => '添加失败']);
            }
            Db::table('user')->where(['id' => $this->user['id']])->update(['exp' => $this->user['exp'] + 1]);
            return Response::json(['err' => 0]);
        }
    }

    private function parseView(&$list)
    {
        foreach ($list as &$item) {
            $info = $this->getUserInfo(['photo', 'exp', 'explain'], $item['userid']);
            $level_info = getUserLevel($info['exp'], $this->upExp);
            $item['nickname'] = $this->getNickname($item['userid']);
            $item['photo'] = $info['photo'];
            $item['explain'] = empty($info['explain']) ? '隐形的小尾巴O(∩_∩)O哈哈~' : $info['explain'];
            $item['level'] = $level_info['level'];
            $item['content'] = $this->face($item['content']);
            $item['addtime'] = date('m-d H:i:s', strtotime($item['addtime']));
        }
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
