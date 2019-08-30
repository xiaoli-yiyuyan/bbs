<?php
namespace api\login;

use api\Api;

class Login extends \api\Api
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 会员登录
     */
    public function login($username = '', $password = '')
    {
        if (empty($username) || empty($password)) {
            $this->error(1, '用户名或密码不能为空！');
            return;
        }
        $where = ['username' => $username, 'password' => md5($password)];
        if (!$user = User::where($where)->find()) {
            $this->error(2, '登录失败，用户名或密码错误！');
            return;
        }

        $token = $user->resetToken();

        Session::set('id', $user['id']);
        
        $this->message('登录成功！');
        return $this->data([
            'id' => $user->id,
            'token' => $token
        ]);
    }

    /**
     * 会员注册
     */
    public function register($username = '', $password = '', $password2 = '', $email = '')
    {
        $setting = Setting::get(['is_register']);
        $setting['is_register'] = $setting['is_register'] ?? 1;
        if($setting['is_register'] == 0){
            $this->error(1, '注册已关闭！');
            return;
        }

        $check = $this->dataCheck([
            'username' => $username,
            'password' => $password,
            'password2' => $password2,
            'email' => $email,
        ]);

        $check = $this->dataCheck($post);
        if ($check['err']) {
            $this->error($check['err'], $check['msg']);
            return;
        }
        $user = new User;
        if ($user->where(['username' => $post['username']])->whereOr(['email' => $post['email']])->find()) {
            $this->error(8, '用户名或邮箱重复，请更换！');
            return;
        }
        $id = $user->insertGetId([
            'username' => $post['username'],
            'nickname' => $post['username'],
            'password' => md5($post['password']),
            'photo' => '/static/images/photo.jpg',
            'email' => $post['email'],
            'addip' => Request::ip()
        ]);
        $sid = createToken($id . '_' . getRandChar(16));
        $user->where(['id' => $id])->update([
            'sid' => $sid
        ]);
        $token = $user->resetToken();
        Session::set('id', $id);

        $this->message('注册成功！');
        return $this->data([
            'id' => $id,
            'token' => $token
        ]);
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
