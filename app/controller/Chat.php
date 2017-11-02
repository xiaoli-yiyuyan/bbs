<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Page;
use Iam\AppApi;
use Iam\Request;
use Iam\Response;

class Chat extends Common
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
        $classid = Request::get('classid');
        $category = new \Model\Category;
        if (!$classInfo = $category->info($classid)) {
            return Page::error('页面未找到！');
        }
        // if ($classInfo['type'] != 'chat') {
        //     return Page::error('页面未找到！');
        // }
        View::load('Chat/room', ['classInfo' => $classInfo]);
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
            return Response::json(['err' => 0]);
        }
    }

    private function parseView(&$list)
    {
        foreach ($list as &$item) {
            $item['nickname'] = $this->getNickname($item['userid']);
            $item['photo'] = $this->getUserInfo('photo', $item['userid']);
            $item['content'] = $this->face($item['content']);
            $item['addtime'] = date('m-d H:i:s', strtotime($item['addtime']));
        }
    }

    function face($context){
        if(strpos($context,"[表情:")!==false){
            $context = preg_replace("/\[表情:(.+)]/U","<img class='face-chat' src='/static/images/face/$1.gif' alt='$1'>",$context);
        }
        return $context;
    }
}
