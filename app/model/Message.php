<?php
namespace Model;

use Iam\Db;
use Iam\Page;
use think\Model;

class Message extends Model
{
    public function getReadStatusAttr($val, $data)
    {

    }

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
    
    private static $order = ['id', 'read_time'];
    private static $sort = ['ASC', 'DESC'];

    public static function send($user_id, $to_user_id, $content)
    {
        if ($user_id == $to_user_id) {
            return;
        }
        self::create([
            'user_id' => $user_id,
            'to_user_id' => $to_user_id,
            'content' => $content
        ]);
    }

    public static function getCount($user_id, $status)
    {
        $where = ['to_user_id' => $user_id];
        if ($status == 0 || $status == 1) {
            $where['status'] = $status;
        }
        return Db::table('message')->field('count(id)')->where($where)->find()['count(id)'];
    }

    public static function readStatus($id, $user_id)
    {
        Db::query('UPDATE `message` SET `status`=? WHERE `id` =? AND `to_user_id` =? AND `status` =?', [1, $id, $user_id, 0]);
    }

    public static function getList($options)
    {
        $options = array_merge(self::$options, $options);
        $query = $options['query'];

        $where = [];
        if (!empty($options['user_id'])) {
            $where['user_id'] = $options['user_id'];
        }

        if (!empty($options['to_user_id'])) {
            $where['to_user_id'] = $options['to_user_id'];
        }
        $count = Db::table('message')->field('count(id) as count')->where($where)->find()['count'];

        $page = new Page([
            'count' => $count,
            'page' => $options['page'],
            'page_name' => $options['page_name'],
            'path' => '',
            'query' => $query,
            'pagesize' => $options['pagesize']
        ]);
        $page = $page->parse();

        $list = Db::table('message')->where($where)->order('status ASC, create_time DESC')->select(($page['page'] - 1) * $page['pagesize'], $page['pagesize']);
        foreach ($list as $item) {
            Message::readStatus($item['id'], $item['to_user_id']);
        }
        return [
            'page' => $page,
            'data' => $list
        ];
    }
}
