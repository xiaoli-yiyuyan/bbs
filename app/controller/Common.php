<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Session;
use Model\Category;
use app\common\IamVersion;

class Common
{
    public $user = ['id' => 0];
    public $upExp = 25;

    private $version;

    public function __construct()
    {
        $this->version = IamVersion::$version;
        if (Session::has('sid')) {
            if ($this->user = Db::table('user')->find('sid', Session::get('sid'))) {
                Db::table('user')->where('sid', Session::get('sid'))->update(['last_time' => now()]);
                $level_info = getUserLevel($this->user['exp'], $this->upExp);
                $this->user = array_merge($this->user, $level_info);
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
        // print_r($userid);
        // print_r(Db::table('user')->field('nickname')->find(2));
        return Db::table('user')->field('nickname')->find($userid)['nickname'];
    }

    protected function getUserInfo($field, $userid)
    {
        // print_r($userid);
        // print_r(Db::table('user')->field('nickname')->find(2));
        return Db::table('user')->field($field)->find($userid);
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
