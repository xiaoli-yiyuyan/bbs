<?php
namespace App;

use Iam\View;
use Model\Message as MMessage;
use Model\Setting;

class Message extends Common
{
    public function index()
    {
        $list = MMessage::where('to_user_id', $this->user['id'])->paginate(Setting::get('pagesize'));
        View::load('message/index', [
            'list' => $list
        ]);
    }

    public function list($options)
    {
        $options['to_user_id'] = $this->user['id'];
        return MMessage::getList($options);
    }

    /**
     * 获取消息数量
     * 0 未读 1已读 2所有
     */
    public function count($status = 0)
    {
        return MMessage::getCount($this->user['id'], $status);
    }
}