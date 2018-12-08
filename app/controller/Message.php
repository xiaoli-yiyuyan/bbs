<?php
namespace App;

use Model\Message as MMessage;

class Message extends Common
{
    public function list($options)
    {
        $options['to_user_id'] = $this->user['id'];
        return MMessage::getList($options);
    }

    /**
     * 获取消息数量
     * 0 未读 1已读 2所有
     */
    public function count($options)
    {
        return MMessage::getCount($this->user['id'], $options['status']);
    }
}