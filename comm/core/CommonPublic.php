<?php
namespace comm\core;

use think\Db;
use Iam\Url;
use Iam\View;
use Iam\Session;
use Iam\Controller;
use Model\Category;
use Model\User;
use comm\Setting;
use Model\SignLog;

class CommonPublic extends Controller
{
    public $user = ['id' => 0, 'uuid' => ''];
    public $upExp = 25;

    private $version;
    private $expMax = 60;

    public function __construct()
    {
        if (!isMobile()) {
            \think\Db::setConfig([
                'paginate' => [
                    'type'      => '\think\paginator\driver\Bootstrap',
                    'var_page' => 'page'
                ]
            ]);
        }
        $this->version = IamVersion::$version;
        
        $setting = Setting::get(['login_reward', 'weblogo', 'webname']);
        if (Session::has('id')) {
            if ($user = User::get(Session::get('id'))) {
                // <2.3.2 升级兼容
                if (isset($user->toArray()['uuid'])) {
                    token($user->uuid);
                }
                $this->user = $user->toArray();
                $last_time = strtotime($this->user['last_time']);
                $_last_time = strtotime(date('Y-m-d', $last_time));
                $now_time = time();

                if ($now_time - $_last_time >= 86400) {

                    $login_reward = $setting['login_reward'];
                    User::changeCoin($this->user['id'], $login_reward);
                }

                $exp = $now_time - $last_time;
                $exp = min($exp, $this->expMax) + $this->user['exp'];
                Db::table('user')->where('id', Session::get('id'))->update(['last_time' => now(), 'exp' => $exp]);
                $level_info = getUserLevel($this->user['exp'], $this->upExp);
                $this->user = array_merge($this->user, $level_info);
                $this->user['is_today_sign'] = SignLog::isTodaySign($this->user['id']);
            }
        } else {
        }
        View::data([
            'user' => $this->user,
            'version' => $this->version,
            // 'weblogo' => $setting['weblogo'],
            // 'webname' => $setting['webname'],
            // 'keywords' => '',
            // 'description' => '',
            // 'webname_after' => ''
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
    public function getUserInfo($user_id = '') //$field, 
    {
        if (empty($user_id)) {
            return $this->user;
        }
        if ($user = User::get($user_id)) {
            return $user;
        }
        return ['id' => 0];
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
