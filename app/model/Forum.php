<?php
namespace Model;

use Iam\Db;

class Forum extends Common
{
    public static function getList($class_id = 0, $page = 1, $pagesize = 10)
    {
        $forum = Db::table('forum');
        if ($class_id > 0) {
            $forum->where(['class_id' => $class_id]);
        }
        return $forum->select(($page - 1) * $pagesize, $pagesize);
    }
}
