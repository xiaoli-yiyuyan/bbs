<?php
namespace Model;

use Iam\Db;
use Iam\Page;
use think\Model;
use comm\Setting;

class Friend extends Model
{
    /**
     * 获取粉丝列表
     */
    public static function getList($user_id = '', $type = 'fans' /** fans|care */, $page = 1, $pagesize = '')
    {
        $friend = self::where('1','1');
        if ($type == 'fans') {
            $friend->where('care_user_id', $user_id);
        } else {
            $friend->where('user_id', $user_id);
        }
        $pagesize = !empty($pagesize) ? $pagesize : Setting::get('pagesize');
        return $friend->paginate($pagesize);
    }

    /**
     * 获取关注数
     */
    public static function getCareCount($user_id)
    {
        return self::where('user_id', $user_id)->count();
    }

    /**
     * 获取粉丝数
     */
    public static function getFansCount($user_id)
    {
        return self::where('care_user_id', $user_id)->count();
    }

    /**
     * 获取所有粉丝的id
     * @param int $user_id 指定用户的id
     */
    public static function getAllFansId($user_id)
    {
        return self::where('care_user_id', $user_id)->column('user_id');
    }

    /**
     * 获取所有关注的id
     * @param int $user_id 指定用户的id
     */
    public static function getAllCareId($user_id)
    {
        return self::where('user_id', $user_id)->column('care_user_id');
    }

    /**
     * 判断用户a是否关注b
     */
    public static function isCare($user_id, $care_user_id)
    {
        return self::get([
            'user_id' => $user_id,
            'care_user_id' => $care_user_id,
        ]);
    }

    private static $options = [
        // 'path' => '/forum/list',
        'page' => 1,
        'pagesize' => 10,
        'order' => 0,
        'sort' => 0
    ];
    // array (
    //     'class_id' => 0,
    //     'user_id' => 0,
    //     'page' => 1,
    //     'pagesize' => 10,
    //     'order' => 0,0 动态排序，1 最新，2 阅读量 3 回复量
    //     'sort' => 0,0 正序 1 倒序
    //   )

    private static $order = ['id'];
    private static $sort = ['ASC', 'DESC'];

    public static function getList2($options = []/*$class_id = 0, $page = 1, $pagesize = 10, $status*/)
    {
        $options = array_merge(self::$options, $options);
        $query = $options['query'];
        $where = [];
        if (!empty($options['user_id'])) {
            $where['user_id'] = $options['user_id'];
        }
        if (!empty($options['care_user_id'])) {
            $where['care_user_id'] = $options['care_user_id'];
        }
        // $_where = array_merge($where, ['status' => 0]);
        $count = Db::table('friend')->field('count(1) as count')->where($where)->find()['count'];

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

        $forum = Db::table('friend')->where($where);

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
