<?php
namespace Model;

use Iam\Db;
use Iam\Page;

class User extends Common
{
    private static $options = [
        'page' => 1,
        'pagesize' => 10
    ];
    // array (
    //     'page' => 1,
    //     'pagesize' => 10,
    //     'order' => 0,0 动态排序，1 最新，2 阅读量 3 回复量
    //     'sort' => 0,0 正序 1 倒序
    //   )

    private static $order = ['last_time', 'id'];
    private static $sort = ['ASC', 'DESC'];

    private static $search = [];

    public static function getList($options = []/*$class_id = 0, $page = 1, $pagesize = 10, word*/)
    {
        // $query = [];
        $options = array_merge(self::$options, $options);
        $where = [];
        // if (!empty($options['class_id'])) {
        //     $where['class_id'] = $options['class_id'];
        // }
        // if (!empty($options['user_id'])) {
        //     $where['user_id'] = $options['user_id'];
        // }
        // if ($options['word']) {
        //     where('(`id` = :word OR `username` LIKE :word OR `nickname` LIKE :word)', ['word' => $options['word']]);
        // }
        $count = Db::table('user')->field('count(1) as count')->where($where)->find()['count'];

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

        $user = Db::table('user')->where($where);

        if (!empty($order)) {
            $user->order($order);
        }
        $page = new Page([
            'count' => $count,
            'page' => $options['page'],
            'path' => '',
            'query' => $where,
            'pagesize' => $options['pagesize']
        ]);
        $page = $page->parse();

        $list = $user->select(($page['page'] - 1) * $page['pagesize'], $page['pagesize']);
        
        return [
            'page' => $page,
            'data' => $list
        ];
    }
}
