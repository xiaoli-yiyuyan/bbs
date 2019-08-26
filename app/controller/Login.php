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
use app\Setting;
use Iam\Config;
use \Firebase\JWT\JWT;

class Login extends Common
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

    /**
     * 会员登录
     */
    public function login($username = '', $password = '')
    {
        $post = Request::post(['username', 'password']);
        if (empty($username) || empty($password)) {
            return Page::error('用户名或密码为空！');
        }

        $where = ['username' => $username, 'password' => md5($password)];
        if (!$user = User::where($where)->find()) {
            return Page::error('登录失败！');
        }
        $token = JWT::encode([
            'id' => $user->id,
            'time' => time()
        ], Config::get('TOKEN_KEY')); //输出Token
        $res = ['err' => 0, 'msg' => '登录成功', 'token' => $token];

        Session::set('sid', $user['sid']);
        Url::redirect('/user/index', $res, true);
    }

    /**
     * 微信登录接口
     */
    public function wxLogin($code = '', $encryptedData = '', $iv = '')
    {
        $params = [
            'appid' => 'wx3b40e8e0abf69986',
            'secret' => '4515af0345049c02a3feb8fb9dd000a8',
            'js_code' => $code,
            'grant_type' => 'authorization_code'
        ];
        $res = http('https://api.weixin.qq.com/sns/jscode2session', $params);
        $res = json_decode($res, true);
        if (!isset($res['openid'])) {
            return Response::json(['err' => 1, 'msg' => '获取身份信息失败！']);
        }
        if (!$user = User::get(['wx_open_id' => $res['openid']])) {
            $userinfo = decryptData( $params['appid'] , $res['session_key'], $encryptedData, $iv );
            $user = User::create([
                'wx_open_id' => $res['openid'],
                'nickname' => $userinfo['nickName'],
                'photo' => $userinfo['avatarUrl']
            ]);
            // print_r($user);
            $user = User::get($user->id);
        }
        $token = JWT::encode([
            'id' => $user->id,
            'time' => time()
        ], Config::get('TOKEN_KEY')); //输出Token
        return Response::json(['err' => 0, 'msg' => '登录成功', 'userinfo' => [
            'nickname' => $user->nickname,
            'photo' => $user->photo,
            'id' => $user->id,
            'coin' => $user->coin,
            'comm_id' => $user->comm_id,
            'identity' => $user->identity
        ],'token' => $token]);
    }

    public function loginApi()
    {
        $post = Request::post(['username', 'password']);
        if (empty($post['username']) || empty($post['password'])) {
            return Response::json(['err' => 1, 'msg' =>'用户名或密码为空！']);
        }

        $where = ['username' => $post['username'], 'password' => md5($post['password'])];
        if (!$user = Db::table('user')->where($where)->find()) {
            return Response::json(['err' => 2, 'msg' =>'用户名或密登录失败！码为空！']);
        }

        Session::set('sid', $user['sid']);
        return Response::json(['err' => 0, 'msg' =>'登陆成功']);
    }

    /**
     * 用户注册
     */
    public function register()
    {
        $setting = Setting::get(['is_register']);
        $setting['is_register'] = $setting['is_register'] ?? 1;
        if($setting['is_register'] == 0){
            Url::redirect('/Login/index');
        }
        if (Request::isPost()) {
            $post = Request::post(['username', 'password', 'password2', 'email']);
            $check = $this->dataCheck($post);
            if ($check['err']) {
                return Page::error($check['msg']);
            }
            $user = new User;
            if ($user->where(['username' => $post['username']])->whereOr(['email' => $post['email']])->find()) {
                return Page::error('用户名或邮箱重复，请更换！');
            }
            $id = $user->insertGetId([
                'username' => $post['username'],
                'nickname' => $post['username'],
                'password' => md5($post['password']),
                'photo' => '/static/images/photo.jpg',
                'email' => $post['email'],
                'addip' => Request::ip()
            ]);
            $sid = $id . '_' . getRandChar(16);
            $user->where(['id' => $id])->update([
                'sid' => $sid
            ]);

            $token = JWT::encode([
                'id' => $user->id,
                'time' => time()
            ], Config::get('TOKEN_KEY')); //输出Token
            $res = ['err' => 0, 'msg' => '登录成功', 'token' => $token];
            Session::set('sid', $sid);

            Url::redirect('/user/index', $res, true);
        } else {
            View::load('login/register');
        }
    }

    private function dataCheck($value)
    {
        $username = $value["username"];
        $password = $value["password"];
        $err = ["err" => 0];
        if($username == ""){
            $err["err"] = 1;
            $err["msg"] = '用户名不能为空';
        }elseif(!preg_match("/^[a-zA-Z0-9_\x{4e00}-\x{9fa5}\\s·]{6,12}$/u",$username)){
            $err["err"] = 2;
            $err["msg"] = '用户名不能有特殊字符,且长度为6~12位';
        }elseif(preg_match("/(^\_)|(\__)|(\_+$)/",$username)){
            $err["err"] = 3;
            $err["msg"] = '用户名首尾不能出现下划线';
        // }elseif(preg_match("/^\d+\d+\d$/",$username)){
        //     $err["err"] = 4;
        //     $err["msg"] = '用户名不能全为数字';
        }elseif(!preg_match("/^.{6,12}$/",$password)){
            $err["err"] = 5;
            $err["msg"] = '密码必须6到12位，且不能出现空格';
        }elseif($value["password"] != $value['password2']){
            $err["err"] = 6;
            $err["msg"] = '两次密码不一致';
        }elseif(!preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",$value["email"])){
            $err["err"] = 7;
            $err["msg"] = '邮箱输入错误';
        }
        return $err;
    }

}
