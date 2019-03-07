<?php
namespace app\common;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Session;
use Model\Category;
use app\common\IamVersion;
use Model\User;
use app\Setting;
use Model\SignLog;

class CommonPublic
{
    public $user = ['id' => 0];
    public $upExp = 25;

    private $version;
    private $expMax = 60;

    public function __construct()
    {
        $this->version = IamVersion::$version;
        if (Session::has('sid')) {
            if ($this->user = Db::table('user')->find('sid', Session::get('sid'))) {
                $last_time = strtotime($this->user['last_time']);
                $_last_time = strtotime(date('Y-m-d', $last_time));
                $now_time = time();

                if ($now_time - $_last_time >= 86400) {

                    $login_reward = Setting::get('login_reward');
                    User::changeCoin($this->user['id'], $login_reward);
                }

                $exp = $now_time - $last_time;
                $exp = min($exp, $this->expMax) + $this->user['exp'];

                Db::table('user')->where('sid', Session::get('sid'))->update(['last_time' => now(), 'exp' => $exp]);
                $level_info = getUserLevel($this->user['exp'], $this->upExp);
                $this->user = array_merge($this->user, $level_info);
                $this->user['is_today_sign'] = SignLog::isTodaySign($this->user['id']);
            }
        } else {
        }
        View::data([
            'user' => $this->user,
            'version' => $this->version
        ]);

    }

    /**
     * 判断是否登录
     */
    public function isLogin()
    {
      if ($this->user['id'] == 0) {
        return;
      }
      return true;
    }

    /**
     * 获取用户昵称
     */
    protected function getNickname($userid)
    {
        return User::get($userid)->nickname;
    }

    /**
     * 获取用户信息
     */
    protected function getUserInfo($field, $userid)
    {
        return User::get($userid);
    }

    /**
     * 获取当前网址
     */
    public function getUrl()
    {
        return urlencode($_SERVER['REQUEST_URI']);
    }

    /**
     * 管理员权限判断
     */
    protected function isAdmin($user_id, $class_id)
    {
        if ($user_id == 1) {
            return true;
        }
        $class = Category::info($class_id);
        $admin_id = $class['bm_id'] ? explode(',', $class['bm_id']) : [];
        // print_r(in_array($user_id, $admin_id));
        if (in_array($user_id, $admin_id)) {
            return true;
        }
    }
}
