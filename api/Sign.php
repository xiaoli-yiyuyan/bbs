<?php
namespace api;

use Model\SignLog;
use Model\User;

class Sign extends \api\Api
{
    private $sign_reward = [
        'start' => 1, // 第一次签到奖励
        'next' => 1, // 累加值
        'max' => 1, // 累加后最大可得奖励
        'vip' => [0, 1, 2, 3, 4, 5], // VIP奖励
        'rand' => [1, 20], // 随机奖励
        'is_mul' => 1 // 开启暴击
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取签到相关
     */
    public function info()
    {
        $today_log = SignLog::where('user_id', $this->user['id'])->order('id DESC')->find();
        $last_time = strtotime($today_log['create_time']);
        $_last_time = strtotime(date('Y-m-d', $last_time));
        $now_time = time();
        $diff_time = $now_time - $_last_time;

        // 如果今天已经签到
        $is_sign = $diff_time < 86400;
        return ['is_sign' => $is_sign];
    }

    /**
     * 签到
     */
    public function sign($content = '')
    {
        if ($user = source('/api/User/info')) {
            $this->error(1, '会员未登录');
            return;
        }

        $signInfo = $this->info();
        if ($signInfo['is_sign']) {
            $this->error(2, '签到失败，今日已经签到！');
            return;
        }
        $content = htmlspecialchars($content);

        $time = $diff_time >= 86400 * 2 ? 1 : $new_log['time'] + 1;
        $reward_coin = $this->getSignCoin($time, $user['vip_level']);
        $coin = array_sum($reward_coin['coin']) * $reward_coin['mul'];
        User::changeCoin($user['id'], $coin);
        SignLog::create([
            'user_id' => $user['id'],
            'memo' => json_encode($reward_coin),
            'coin' => $coin,
            'content' => $content,
            'time' => $time
        ]);
        $this->message('签到成功！');
        return ['coin' => $coin];
    }

    private function getSignCoin($time, $vip_level)
    {
        $sign_reward = $this->sign_reward;
        $coin = [];
        $coin[] = $sign_reward['start'];
        $coin[] = max($time * $sign_reward['next'], $sign_reward['max']);
        $coin[] = $sign_reward['vip'][$vip_level];
        $coin[] = call_user_func_array('mt_rand', $sign_reward['rand']);
        $mul = 1;
        if ($sign_reward['is_mul']) {
            $is_mul = mt_rand(0, 99);
            if ($is_mul < 10) {
                $mul = 2;
            }
        }
        return ['coin' => $coin, 'mul' => $mul];
    }

    /**
     * 获取签到记录
     */
    public function list($user_id = '', $page = 1, $pagesize = 10, $sort = 1, $order = 1)
    {
        $signLog = SignLog::where(1, 1);

        $user_id = parseParam($user_id);
        if (!empty($user_id)) {
            $signLog->where('user_id', 'IN', $user_id);
        }

        $orderSort = [];
        /**
         * 排序
         */
        // if ($order == 1) {
        //     // 动态
        //     $orderSort[] = 'last_time';
        // } else {
            // 顺序
            $orderSort[] = 'id';
        // }

        if ($sort == 1) {
            $orderSort[] = 'DESC';
        } else {
            $orderSort[] = 'ASC';
        }
        $signLog->order($orderSort[0], $orderSort[1]);

        $list = $signLog->paginate($pagesize, true, ['page' => $page]);
        return $list->toArray();
    }
}
