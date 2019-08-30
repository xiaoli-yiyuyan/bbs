<?php
namespace api;

use Model\SignLog;
use Model\User;

use Model\Message as MessageModel;

class Message extends \api\Api
{
    /**
     * 获取当前用户消息列表
     */
    public function list($page = 1, $pagesize = 10, $sort = 1, $order = 1, $type = 0)
    {
        if ($user = source('/api/User/info')) {
            $this->error(1, '会员未登录');
            return;
        }
        $message = MessageModel::where(1, 1);
        
        if ($type == 1) {
            $message->where('user_id', $user['id']);
        } else {
            $message->where('to_user_id', $user['id']);
        }

        $orderSort = [];

        $orderSort[] = 'id';

        if ($sort == 1) {
            $orderSort[] = 'DESC';
        } else {
            $orderSort[] = 'ASC';
        }
        $message->order($orderSort[0], $orderSort[1]);
        $list = $message->paginate($pagesize, true, ['page' => $page]);
        return $list->toArray();
    }

    /**
     * 获取消息数量
     * 0 未读 1已读 2所有
     */
    public function count($status = 0)
    {
        $count = MessageModel::getCount($this->user['id'], $status);
        return $count;
    }
}
