<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Session;

class Common
{
    public $user = ['id' => 0];
    public function __construct()
    {
        if (Session::has('sid')) {
            $this->user = Db::table('user')->find('sid', Session::get('sid'));
        } else {
        }
        View::data([
            'user' => $this->user
        ]);
    }

    protected function isLogin()
    {
      if (!$this->user['id']) {
        Url::redirect('/Login/index');
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
        return Db::table('user')->field($field)->find($userid)[$field];
    }
}
