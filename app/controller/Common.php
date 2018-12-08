<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Session;
use Model\Category;
use app\common\IamVersion;
use Model\User as MUser;
use app\Setting;
use Model\SignLog;

class Common
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
                    MUser::changeCoin($this->user['id'], $login_reward);
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

    public function isLogin()
    {
      if ($this->user['id'] == 0) {
        // Url::redirect('/login/index');
        // exit();
        return;
      }
      return true;
    }

    protected function getNickname($userid)
    {
        return MUser::get($userid)->nickname;
    }

    protected function getUserInfo($field, $userid)
    {
        return MUser::get($userid);
    }

    public function getUrl()
    {
        return urlencode($_SERVER['REQUEST_URI']);
    }

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
