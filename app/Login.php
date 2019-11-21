<?php
namespace App;

use think\Db;
use Iam\Url;
use Iam\View;
use Iam\Page;
use Iam\Session;
use Iam\Request;
use Iam\Response;
use Model\User;
use comm\Setting;

class Login extends \comm\core\Home
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $setting = Setting::get(['is_register']);
        $setting['is_register'] = $setting['is_register'] ?? 1;
    	View::load('login/index',$setting);
    }

    public function login($username = '', $password = '')
    {
        $post = Request::post(['username', 'password']);
        $res = source('/api/login/Login/login', $post, $api);
        
        if ($error = $api->error()) {
            return Page::error($error['message']);
        }
        
        return Page::success('登录成功！', '/user/index');
    }

    public function register()
    {
        $setting = Setting::get(['is_register']);
        $setting['is_register'] = $setting['is_register'] ?? 1;
        if($setting['is_register'] == 0){
            return Page::error('注册已关闭！');
        }
        if (Request::isPost()) {
            $post = Request::post(['username', 'nickname', 'password', 'password2', 'email']);
            $res = source('/api/login/Login/register', $post, $api);
            if ($error = $api->error()) {
                return Page::error($error['message']);
            }
            return Page::success('注册成功！', '/user/index');
        } else {
            View::load('login/register');
        }
    }
}
