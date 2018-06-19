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
            $item['create_time'] = date('m-d H:i', strtotime($item['create_time']));
        }
    }

    public function list()
    {
        $id = Request::get('id');
        if (!$class_info = Db::table('Category')->where([
            'type' => 1,
            'id' => $id
        ])->find()) {
            return Page::error('页面未找到！');
        }

        $count = Db::table('forum')->field('count(1) as count')->where(['class_id' => $id])->find()['count'];

        $nowPage = Request::get('p') ? Request::get('p') : 1;

        $page = new Page([
            'count' => $count,
            'p' => $nowPage,
            'path' => '/forum/list',
            'query' => ['id' => $id],
            'pagesize' => 10
        ]);
        $page = $page->parse();
        $list = MForum::getList($id, $page['page'], $page['pagesize']);
        $this->parseList($list);
        View::load('forum/list', [
            'class_info' => $class_info,
            'list' => $list,
            'page' => $page
        ]);
    }

    public function add()
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
            'path' => '/forum/view',
            'query' => ['id' => $forumid],
            'pagesize' => 10
        ]);
        $page = $page->parse();

        $list = ForumReply::getList($forumid, $page['page'], $page['pagesize']);
        $this->parseList($list);

        Db::query('UPDATE `forum` SET `read_count` = `read_count` + 1 WHERE `id` = ?', [$forumid]);

        View::load('forum/view', [
            'class_info' => $class_info,
            'forum_info' => $info,
            'forum_user' => $forum_user,
            'list' => $list,
            'page' => $page
        ]);
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

    public function replyAdd()
    {
        $this->isLogin();
        $id = Request::get('id');
        $way = Request::get('way');
        $context = Request::post('context');
        if (empty($context)) {
            return Page::error('回复内容不能为空哦！');
        }
        if (!Db::table('forum')->find($id)) {
            return Page::error('回复的主题可能已经删除！');
        }
        Db::table('forum_reply')->add([
            'forum_id' => $id,
            'user_id' => $this->user['id'],
            'context' => htmlspecialchars($context)
        ]);
        Db::query('UPDATE `forum` SET `reply_count` = `reply_count` + 1 WHERE `id` = ?', [$id]);

        if ($way) {
            Url::redirect('/forum/reply?id=' . $id);
        } else {
            Url::redirect('/forum/view?id=' . $id);
        }
    }
    function face($context){
        if(strpos($context,"[表情:")!==false){
            $context = preg_replace("/\[表情:(.+)]/U","<img class='face-chat' src='/static/images/face/$1.gif' alt='$1'>",$context);
        }
        return $context;
    }
}