<?php
namespace Model;

use Iam\Db;
use Iam\Page;
use think\Model;

class ForumReply extends Model
{

    public function getAuthorAttr($val, $data)
    {
        return User::getAuthor($data['user_id']);
    }

    public function getForumArtAttr($val, $data)
    {
        $res = Forum::get($data['forum_id']);
        $res->append(['author', 'img_list']);
        return $res;
    }

    public static function getList2($forum_id = 0, $page = 1, $pagesize = 10)
    {
        $forum = Db::table('forum_reply');
        if ($forum_id > 0) {
            $forum->where(['forum_id' => $forum_id]);
        }
        return $forum->select(($page - 1) * $pagesize, $pagesize);
    }

    private static $options = [
        'page' => 1,
        'pagesize' => 10,
        'order' => 0,
        'sort' => 0
    ];
    // array (
    //     'forum_id' => 0,
    //     'user_id' => 0,
    //     'path' => '',
    //     'page' => 1,
    //     'pagesize' => 10,
    //     'order' => 0,0 动态排序，1 最新，2 阅读量 3 回复量
    //     'sort' => 0,0 正序 1 倒序
    //   )

    private static $order = ['id'];
    private static $sort = ['ASC', 'DESC'];

    public static function getList($options = []/*$class_id = 0, $page = 1, $pagesize = 10, $path*/)
    {
        $options = array_merge(self::$options, $options);
        $query = $options['query'];
        $where = [];
        if (!empty($options['forum_id'])) {
            $where['forum_id'] = $options['forum_id'];
            $query['id'] = $options['forum_id'];
        }
        if (!empty($options['user_id'])) {
            $where['user_id'] = $options['user_id'];
        }
        $count = Db::table('forum_reply')->field('count(1) as count')->where($where)->find()['count'];

        $order = [];

        $order_value = $options['order'];

        if (isset(self::$order[$order_value])) {
            $order_key = self::$order[$order_value];
            $order[$order_key] = 'ASC';

            $sort_value = $options['sort'];
            if (isset(self::$sort[$sort_value])) {
                $sort_key = self::$sort[$sort_value];
                $order[$order_key] = $sort_key;
            }
        }

        $forum = Db::table('forum_reply')->where($where);

        if (!empty($order)) {
            $forum->order($order);
        }
        $page = new Page([
            'count' => $count,
            'page' => $options['page'],
            'page_name' => $options['page_name'],
            'path' => '',
            'query' => $query,
            'pagesize' => $options['pagesize']
        ]);
        $page = $page->parse();

        $list = $forum->select(($page['page'] - 1) * $page['pagesize'], $page['pagesize']);
        
        return [
            'page' => $page,
            'data' => $list
        ];
    }
    
    /**
     * 获取回复帖列表 
     * @param int $reply_userid 回帖用户id
     * */

    public function replyList($reply_userid = '', $pagesize = 10)
    {
        $list = $this->field('user_id, forum_id, context, create_time')->where('user_id', $reply_userid)->order('create_time DESC')->paginate($pagesize);
        $list->append(['author']);
        return $list;
    }
}
