<?php
namespace Model;

use Iam\Db;

class Novel extends Common
{
    private static $options = [
        'order' => ['update_time' => 'DESC'],
        'page' => 1,
        'pagesize' => 10
    ];

    public static function getList($options/*is_over*/)
    {
        $options = array_merge(self::$options, $options);
        
        $novel = Db::table('novel');
        if (!empty($options['mark_id'])) {
            return Db::query('SELECT * FROM `novel` WHERE id IN(SELECT novelid FROM `novel_mark_body` WHERE `markid`=?) ORDER BY `update_time` ASC limit ' . ($options['page'] - 1) * $options['pagesize'] . ',' . $options['pagesize'], [$options['mark_id']]);
        }
        if (isset($options['order'])) {
            $novel->order($options['order']);
        }
        if (isset($options['is_over'])) {
            $novel->where(['is_over' => $options['is_over']]);
        }
        return $novel->select(($options['page'] - 1) * $options['pagesize'], $options['pagesize']);
    }
}
