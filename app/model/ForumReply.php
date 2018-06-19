<?php
namespace Model;

use Iam\Db;

class ForumReply extends Common
{
    public static function getList($forum_id = 0, $page = 1, $pagesize = 10)
    {
        $forum = Db::table('forum_reply');
        if ($forum_id > 0) {
            $forum->where(['forum_id' => $forum_id]);
        }
        return $forum->select(($page - 1) * $pagesize, $pagesize);
    }
}
