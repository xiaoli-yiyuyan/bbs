<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Page;
use Iam\Request;
use Iam\Response;
use Model\Novel as MNovel;
use Model\NovelMark;
use Model\NovelHistory;

class Novel extends \comm\core\Home
{
    public function index()
    {
        $mark = Db::table('novel_mark')->select();
        $new_list = Db::table('novel')->order('`id` DESC')->select(0,10);
        foreach ($new_list as &$item) {
            $item['mark'] = $this->getMarkTitle($item['id']);
         }
        // print_r($new_list);
    	View::load('novel/index',['mark' => $mark, 'new_list' => $new_list]);
    }

    public function sort()
    {
        $mark = Db::table('novel_mark')->select();
        foreach ($mark as &$item) {
            $count_all = Db::query('SELECT COUNT(1) as count FROM `novel_mark_body` WHERE `markid`=?', [$item['id']]);
            $item['count'] = $count_all[0]['count'];
            
            if ($novel = Db::query('SELECT * FROM `novel` WHERE id IN(SELECT novelid FROM (SELECT novelid FROM `novel_mark_body` WHERE `markid`=? limit 1) as id)', [$item['id']])) {
                $item['fitst_novel_photo'] = $novel[0]['photo'];
            } else {
                $item['fitst_novel_photo'] = '/static/images/book-cover.svg';
            }
        }
    	View::load('novel/sort',['mark' => $mark]);
    }

    public function list()
    {
        $id = Request::get('id');
        
        if (!$mark_info = Db::table('novel_mark')->find($id)) {
            return Page::error('页面未找到！');
        }
        $count = Db::table('novel_mark_body')->field('COUNT(1) as count')->where(['markid' => $id])->find()['count'];
        $nowPage = Request::get('p') ? Request::get('p') : 1;

        $page = new Page([
            'count' => $count,
            'p' => $nowPage,
            'path' => '/forum/list',
            'query' => ['id' => $id],
            'pagesize' => 10
        ]);
        $page = $page->parse();
        $list = MNovel::getList(['mark_id' => $id, 'page' => $page['page'], 'pagesize' => $page['pagesize']]);
        
        foreach ($list as &$item) {
            $item['mark'] = NovelMark::getTitle($item['id']);
        }
        View::load('novel/list', [
            'mark_info' => $mark_info,
            'list' => $list,
            'page' => $page
        ]);
    }

    public function rank()
    {
        $tp = Request::get('tp');
        $count = Db::table('novel')->field('COUNT(1) as count')->find()['count'];
        $nowPage = Request::get('p') ? Request::get('p') : 1;

        $page = new Page([
            'count' => $count,
            'p' => $nowPage,
            'path' => '/forum/list',
            'query' => ['tp' => $tp],
            'pagesize' => 10
        ]);
        $page = $page->parse();
        
        $options = ['page' => $page['page'], 'pagesize' => $page['pagesize']];
        if ($tp == 1) {
            $title = '排行';
            $options['order'] = ['read' => 'DESC'];
        } elseif ($tp == 2) {
            $title = '新书';
            $options['order'] = ['create_time' => 'DESC'];
        } else {
            $title = '完本';
            $options['is_over'] = 1;
        }
        $list = MNovel::getList($options);
        foreach ($list as &$item) {
            $item['mark'] = NovelMark::getTitle($item['id']);
        }
        View::load('novel/rank', [
            'list' => $list,
            'page' => $page,
            'title' => $title
        ]);
    }

    public function getMarkTitle($novelid)
    {
        $mark = Db::query('SELECT * FROM `novel_mark` WHERE `id` IN(SELECT `markid` FROM `novel_mark_body` WHERE `novelid`=?)', [$novelid]);
        return $mark;
    }
    public function view()
    {
        $id = Request::get('id');
        if (!$novel = Db::table('novel')->find($id)) {
            Page::error('错误的位置！');
        }
        $mark = Db::table('novel_mark_body')->where(['novelid' => $novel['id']])->select();
        $mark = Db::query('SELECT a.*,b.`title` FROM `novel_mark_body` a INNER JOIN `novel_mark` b ON b.`id`=a.`markid` WHERE a.`novelid`=?', [$novel['id']]);
        $list = Db::table('novel_chapter')->where(['novelid' => $novel['id']])->order('id asc')->select();

        $isCollect = $this->isCollect($id) ? '取消收藏' : '加入书架';
        View::load('novel/view', ['list' => $list, 'novel' => $novel, 'mark' => $mark,'isCollect' => $isCollect]);
    }

    // 文章收藏
    public function novelCollect(){
      $this->isLogin();
      $id = Request::get('id');

      if ($collectId = $this->isCollect($id)) {
        if(!Db::table('novel_collect')->where(['id' => $collectId['id']])->remove()){
          return Page::error('取消收藏失败');
        }
        return Url::redirect('/novel/view?id='.$id);
      }

      $where = ['userid' => $this->user['id'],'novelid' =>$id];
      if (!Db::table('novel_collect')->add($where)){
        return Page::error('收藏失败');
      }
      return Url::redirect('/novel/view?id='.$id);
    }

    public function isCollect($novelid) // 判断有无收场
    {
        $where = ['userid' => $this->user['id'],'novelid' =>$novelid];
        return Db::table('novel_collect')->field('id')->where($where)->find();
    }

    public function favorite()
    {
        $this->isLogin();
        $list = [];
        if ($collectId = Db::table('novel_collect')->field('novelId')->where(['userid' => $this->user['id']])->select(100)){
            foreach ($collectId as $value) {
                $novel = Db::table('novel')->find($value['novelId']);
                $novel['mark'] = NovelMark::getTitle($novel['id']);
                $list[] = $novel;
            }
        }

        View::load('novel/favorite', ['list' => $list]);
    }

    public function chapter()
    {
        $get = Request::get();
        $id = $get['id'];
        $page_no = 1;
        if (!empty($get['pageno'])) {
            $page_no = $get['pageno'];
        }

        $chapter = Db::table('novel_chapter')->find($id);

        if (!$novel = Db::table('novel')->find($chapter['novelid'])) {
            return Page::error('错误的位置！');
        }
        NovelHistory::save($this->user['id'], $chapter['novelid'], $id);
        //上一章
        $prev_chapter = Db::query('SELECT * FROM novel_chapter WHERE novelid=? AND id<? ORDER BY id desc LIMIT 1', [$chapter['novelid'], $id]);
        //下一章
        $next_chapter = Db::query('SELECT * FROM novel_chapter WHERE novelid=? AND id>? ORDER BY id asc LIMIT 1', [$chapter['novelid'], $id]);

        $prev_chapter_id = $prev_chapter ? $prev_chapter[0]['id'] : 0;
        $next_chapter_id = $next_chapter ? $next_chapter[0]['id'] : 0;
        $txt = file_get_contents($chapter['path']);

        $page_size = 500;
        $count = mb_strlen($txt);
        $page_total = ceil($count/$page_size);
        if ($page_no > $page_total) $page_no = $page_total;
        if ($page_no < 1) $page_no = 1;
        $context = mb_substr($txt, $page_size * ($page_no - 1), $page_size);

        $page = [
            'total' => $page_total,
            'no' => $page_no,
            'size' => $page_size
        ];

        View::load('novel/chapter', [
            'chapter' => $chapter,
            'context' => $context,
            'novel' => $novel,
            'page' => $page,
            'prev_chapter' => $prev_chapter_id,
            'next_chapter' => $next_chapter_id            
        ]);
    }

    /**
     * 阅读历史记录
     */
    public function history()
    {
        $list = NovelHistory::getList($this->user['id']);
        View::load('novel/history', [
            'list' => $list
        ]);
    }

    public function add()
    {
        if (Request::isPost()) {
            $post = Request::post(['title', 'photo', 'author', 'is_over', 'mark', 'wordcount', 'memo']);

            if (!$post['photo'] = downloadImage($post['photo'], uniqid(), 'static/novel/')) {
                return Response::json(['err' => 1, 'msg' => '添加失败, 图片路径错误']);
            }

            $data = [
                'title' => $post['title'],
                'photo' => '/' . $post['photo'],
                'author' => $post['author'],
                'is_over' => $post['is_over'],
                'wordcount' => $post['wordcount'],
                'memo' => $post['memo']
            ];
            // print_r($data);

            if (!$id = Db::table('novel')->add($data)) {
                return Response::json(['err' => 2, 'msg' => '添加失败']);
            }

            $mark = $post['mark'];
            foreach ($mark as $item) {
                Db::table('novel_mark_body')->add([
                    'markid' => $item,
                    'novelid' => $id
                ]);
            }

            Url::redirect('/novel/view?id=' . $id);
        } else {
            View::load('novel/add');
        }
    }

    public function webAdd()
    {
        
        $post = Request::post(['title', 'photo', 'author', 'mark', 'wordcount', 'memo']);
        // return Response::json($post);
        if (!$post['photo'] = downloadImage($post['photo'], uniqid(), 'static/novel/')) {
            return Response::json(['err' => 1, 'msg' => '添加失败, 图片路径错误']);
        }

        $data = [
            'title' => $post['title'],
            'photo' => '/' . $post['photo'],
            'author' => $post['author'],
            'wordcount' => $post['wordcount'],
            'memo' => $post['memo']
        ];
        // print_r($data);

        if (!$id = Db::table('novel')->add($data)) {
            return Response::json(['err' => 2, 'msg' => '添加失败']);
        }

        $mark = $post['mark'];
        foreach ($mark as $item) {
            Db::table('novel_mark_body')->add([
                'markid' => $item,
                'novelid' => $id
            ]);
        }
        // sleep(1);
        return Response::json(['err' => 0, 'msg' => '添加成功', 'id' => $id]);

    }

    public function addChapter()
    {
        if (Request::isPost()) {
            $post = Request::post(['id', 'title', 'context']);
            if (!Db::table('novel')->find($post['id'])) {
                return Page::error('母体选择错误');
            }

            if (!$id = Db::table('novel_chapter')->add(['title' => $post['title'], 'novelid' => $post['id']])) {
                return Page::error('添加失败');
            }

            $count = Db::table('novel_chapter')->where(['novelid' => $post['id']])->field('COUNT(1) AS count')->find()['count'];

            $txt_path = 'NovelChapter/' . $post['id'] . '/' . $count . '_' . $id . '.txt';
            $pathname = dirname($txt_path);

            if (!is_dir($pathname)) mkdir($pathname, 0777, true);
            file_put_contents($txt_path, $post['context']); //保存成文件

            Db::table('novel_chapter')->where(['id' => $id])->update(['path' => $txt_path]);

            echo '添加成功';
        } else {
            $id = Request::get('id');
            $novel = Db::table('novel')->find($id);
            View::load('novel/addChapter', ['novel' => $novel]);
        }
    }

    public function addMark()
    {
        $post = Request::post();
        $data = [
            'title' => $post['title']
        ];
        if (!$id = Db::table('novel_mark')->add($data)) {
            return Response::json([
                'err' => 1,
                'msg' => '添加失败！'
            ]);
        }

        return Response::json([
            'err' => 0,
            'id' => $id,
            'title' => $data['title'],
            'msg' => '添加成功！'
        ]);
    }

    public function mark()
    {
        $mark = Db::table('novel_mark')->select();
        return Response::json($mark);
    }

    public function class()
    {
        $id = Request::get('id');
        $list = Db::table('novel_mark_body')->where(['id' => $id])->select();
    }

    public function search()
    {
        $post = Request::get(['word', 'action']);
        $word = "%{$post['word']}%";
        $list = [];
        if ($post['action'] == 1 || $post['action'] == 0) {
            $list['title'] = Db::query("SELECT * FROM `novel` WHERE `title` LIKE ? LIMIT 20", [$word]);
        }
        if ($post['action'] == 2 || $post['action'] == 0) {
            $list['author'] = Db::query("SELECT * FROM `novel` WHERE `author` LIKE ? LIMIT 20", [$word]);
        }
        if ($post['action'] == 3 || $post['action'] == 0) {
            $list['mark'] = Db::query("SELECT * FROM `novel_mark` WHERE `title` LIKE ? LIMIT 20", [$word]);
        }
        View::load('novel/search', ['list' => $list, 'action' => $post['action']]);
    }
}
