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

    public static function isTodaySign($user_id)
    {
        $today_log = self::where('user_id', $user_id)->order('id DESC')->find();
        $last_time = strtotime($today_log['create_time']);
        $_last_time = strtotime(date('Y-m-d', $last_time));
        $now_time = time();
        $diff_time = $now_time - $_last_time;

        // 如果今天已经签到
        return $diff_time < 86400;
    }
}
