<?php
namespace Model;

use think\Model;

class SignLog extends Model
{
    public function getUserInfoAttr($value, $data)
    {
        return User::get($data['user_id']);
    }

    public function getFriendlyCreateTimeAttr($value, $data)
    {
        return date('m-d H:i', strtotime($data['create_time']));
    }

    public function getInfoAttr($value, $data)
    {
        return json_decode($data['memo'], true);
    }
}
