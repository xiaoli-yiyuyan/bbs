<?php
namespace Model;

use Iam\Db;
use Iam\Page;

class Forum extends Common
{
    private static $options = [
        // 'path' => '/forum/list',
        'page' => 1,
        'pagesize' => 10,
        'order' => 0,
        'sort' => 0,
        'status' => 0,
        'query' => [],
        'page_name' => 'p'
    ];
    // array (
    //     'class_id' => 0,
    //     'user_id' => 0,
    //     'page' => 1,
    //     'pagesize' => 10,
    //     'order' => 0,0 动态排序，1 最新，2 阅读量 3 回复量
    //     'sort' => 0,0 正序 1 倒序
    //   )

    private static $order = ['update_time', 'id', 'read_count', 'reply_count'];
    private static $sort = ['ASC', 'DESC'];

    public static function getList($options = []/*$class_id = 0, $page = 1, $pagesize = 10, $status*/)
    {
        $options = array_merge(self::$options, $options);
        $query = $options['query'];
        $where = [];
        if (!empty($options['class_id'])) {
            $where['class_id'] = $options['class_id'];
        }
        if (!empty($options['user_id'])) {
            $where['user_id'] = $options['user_id'];
        }
        if (!empty($options['status'])) {
            $where['status'] = $options['status'];
        }
        // $_where = array_merge($where, ['status' => 0]);
        $count = Db::table('forum')->field('count(1) as count')->where($where)->find()['count'];

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

        $forum = Db::table('forum')->where($where);

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
}
