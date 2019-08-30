<?php
namespace api;

use Model\ForumReply as ForumReplyModel;
use comm\core\Ubb;

class ForumReply extends \api\Api
{
    /**
     * 回复类表
     */
    public function list($forum_id = '', $user_id = '', $page = 1, $pagesize = 10)
    {

        $forumReply = ForumReplyModel::where(1, 1);

        $forum_id = parseParam($forum_id);
        if (!empty($forum_id)) {
            $forumReply->where('forum_id', 'IN', $forum_id);
        }

        $user_id = parseParam($user_id);
        if (!empty($user_id)) {
            $forumReply->where('user_id', 'IN', $user_id);
        }

        // 获取回复数据
        $list = $forumReply->paginate($pagesize, false, [
            'page' => $page
        ])->each(function($item, $key) {
            $item->context = Ubb::face($item->context);
            $item->context = Ubb::altUser($item->context);
        });
        $list->append(['author']);
        return $list;
    }

}
