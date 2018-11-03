<?php
namespace App;

use Iam\View;
use Iam\Page;
use app\Setting;
use Iam\Request;
use Model\SignLog;

class Sign extends Common
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

    public function index()
    {
        $today_log = SignLog::where('user_id', $this->user['id'])->order('id DESC')->find();

    	View::load('sign/index');
    }

    public function sign()
    {
        $content = Request::post('content');
        $content = htmlspecialchars($content);
        $new_log = SignLog::where('user_id', $this->user['id'])->order('id DESC')->find();

        $last_time = strtotime($new_log['create_time']);
        $_last_time = strtotime(date('Y-m-d', $last_time));
        $now_time = time();
        $diff_time = $now_time - $_last_time;

        // 如果今天已经签到
        if ($diff_time < 86400) {
            return Page::error('签到失败！');
        }

        $time = $diff_time >= 86400 * 2 ? 1 : $new_log['time'] + 1;
        $reward_coin = $this->getSignCoin($time, $this->user['vip_level']);
        $coin = array_sum($reward_coin['coin']) * $reward_coin['mul'];
        MUser::changeCoin($this->user['id'], $coin);
        SignLog::create([
            'user_id' => $this->user['id'],
            'memo' => json_encode($reward_coin),
            'coin' => $coin,
            'content' => $content,
            'time' => $time
        ]);
        return Page::success('签到成功！', '/sign/index');
    }

    private function getSignCoin($time, $vip_level)
    {
        $sign_reward = $this->sign_reward;
        $coin = [];
        $coin[] = $sign_reward['start'];
        $coin[] = max($time * $sign_reward['next'], $sign_reward['max']);
        $coin[] = $sign_reward[$vip_level];
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

    public function getList()
    {

    }
}
