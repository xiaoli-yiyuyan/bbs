<?php
namespace app\common;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Session;
use Iam\Request;
use Iam\Config;
use Iam\Controller;
use Model\Category;
use app\common\IamVersion;
use Model\User;
use app\Setting;
use Model\SignLog;
use \Firebase\JWT\JWT;

class CommonPublic extends Controller
{
    public $user = ['id' => 0];
    public $upExp = 25;

    private $version;
    private $expMax = 60;

    public function __construct()
    {
        $this->version = IamVersion::$version;
        
        $setting = Setting::get(['login_reward', 'weblogo', 'webname']);

        if ($user = $this->getMyUser()) {
            $this->user = $user;
            $last_time = strtotime($this->user['last_time']);
            $_last_time = strtotime(date('Y-m-d', $last_time));
            $now_time = time();

            if ($now_time - $_last_time >= 86400) {

                $login_reward = $setting['login_reward'];
                User::changeCoin($this->user['id'], $login_reward);
            }

            $exp = $now_time - $last_time;
            $exp = min($exp, $this->expMax) + $this->user['exp'];
            $this->user->last_time = now();
            $this->user->exp = $exp;
            $this->user->save();
            $level_info = getUserLevel($this->user['exp'], $this->upExp);
            $this->user = array_merge($this->user->toArray(), $level_info);
            $this->user['is_today_sign'] = SignLog::isTodaySign($this->user['id']);
        }

        View::data([
            'user' => $this->user,
            'version' => $this->version,
            'weblogo' => $setting['weblogo'],
            'webname' => $setting['webname'],
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
     * 获取当前已登录用户信息
     */
    private function getMyUser()
    {
        if (Session::has('sid') && $user = User::get(['sid'=> Session::get('sid')])) {
            return $user;
        } else {
            $jwt = $_SERVER['HTTP_X_TOKEN'] ?? Request::get('x_token');
            try {
                JWT::$leeway = 60;
                $decoded = JWT::decode($jwt, Config::get('TOKEN_KEY'), ['HS256']);
                $arr = (array)$decoded;
                if ($user = User::get($arr['id'])) {
                    return $user;
                }
            } catch (\UnexpectedValueException $e) {
            } catch(Exception $e) {
            }
        }
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
