<?php
namespace Model;

use think\Db;
use Iam\Page;
use think\Model;

class Category extends Model
{
    public static function info($classid)
    {
        return Db::table('category')->find($classid);
    }

    public static function getSetting($name)
    {
        $group = explode('/', $name);
        $name = array_pop($group);
        print_r($group);
    }

    private static $options = [
        'page' => 1,
        'pagesize' => 10
    ];
    // array (
    //     'type' => 0,0 通用，1 论坛
    //     'page' => 1,
    //     'pagesize' => 10,
    //     'order' => 0,0 最新，1 后台设置排序
    //     'sort' => 0,0 正序 1 倒序
    //   )

    private static $order = ['id', 'order'];
    private static $sort = ['ASC', 'DESC'];

    public static function getList($var_page = 'page')
    {
        return self::paginate(20, true, [
            'var_page' => $var_page
        ]);
    }

    public static function getList_old($options = []/*$class_id = 0, $page = 1, $pagesize = 10*/)
    {
        // $query = [];
        $options = array_merge(self::$options, $options);
        $where = [];
        if (!empty($options['type'])) {
            $where['class_id'] = $options['class_id'];
        }
        $count = Db::table('category')->field('count(1) as count')->where($where)->find()['count'];

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

        $forum = Db::table('category')->where($where);

        if (!empty($order)) {
            $forum->order($order);
        }
        $page = new Page([
            'count' => $count,
            'page' => $options['page'],
            'path' => '/forum/list',
            'query' => $where,
            'pagesize' => $options['pagesize']
        ]);
        $page = $page->parse();

        $list = $forum->select(($page['page'] - 1) * $page['pagesize'], $page['pagesize']);
        
        return [
            'page' => $page,
            'data' => $list
        ];
    }

    public function getTotal()
    {
        return Forum::where('class_id', $this->id)->where('status', 0)->count();
    }

    /**
     * 判断是不是栏目管理
     */
    public function isBm($user_id)
    {
        $admin_id = $this->bm_id ? explode(',', $this->bm_id) : [];
        // print_r(in_array($user_id, $admin_id));
        if (in_array($user_id, $admin_id) || $user_id == 1) {
            return true;
        }
    }
}
