<?php
namespace App;

use Iam\Db;
use Iam\View;
use Iam\Page;
use Iam\Request;
use Iam\Response;
use Model\Category;
class Forum extends Common
{
    public function index()
    {
        $list = Db::table('Category')->where([
            'type' => 1
        ])->select();
        View::load('forum/index', [
            'list' => $list
        ]);
    }

    public function list()
    {
        View::load('forum/list', [
            'classInfo' => [
                'title' => '论坛'
            ]
        ]);
    }

    public function add()
    {
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

    public function view()
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

        View::load('forum/view', ['forum_info' => $info, 'forum_user' => $forum_user]);
    }
}