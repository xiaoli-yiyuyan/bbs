<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Page;
use Iam\Listen;
use Iam\Session;
use Iam\Request;
use Iam\Response;
use Iam\FileUpload;
use Model\Friend;
use Model\User as MUser;
use Model\Message as MMessage;

class User extends Common
{
    public function __construct()
    {
        parent::__construct();
        // $this->isLogin();
    }

    public function editInfo($options/*id, 'nickname', 'explain'*/)
    {
        if (!$this->isLogin()) {
            return ['err' => 1, 'msg' => '会员未登录'];
        }
        $options['nickname'] = htmlspecialchars($options['nickname']);
        $options['explain'] = htmlspecialchars($options['explain']);
        if (mb_strlen($options['nickname']) < 2) {
            return ['err' => 2, 'msg' => '昵称长度不能小于2个字符哦！'];
        }
        if (mb_strlen($options['nickname']) > 16) {
            return ['err' => 3, 'msg' => '昵称太长啦，我记不住！'];
        }
        if (empty($options['explain'])) {
            return ['err' => 4, 'msg' => '你忘了你的小尾巴了！'];
        }
        if (mb_strlen($options['explain']) > 500) {
            return ['err' => 5, 'msg' => '你的小尾巴了太长了，我记不住！'];
        }
        DB::table('user')->where(['id' => $this->user['id']])->update(['nickname' => $options['nickname'], 'explain' => $options['explain']]);
        return ['id' => $this->user['id']];

    }

    public function updatePassword($options/*id, password, password1, password2*/){
        if (!$this->isLogin()) {
            return ['err' => 1, 'msg' => '会员未登录'];
        }
        $id = $this->user['id'];

        if (md5($options['password']) != $this->user['password']) {
            return ['err' => 2, 'msg' => '原始密码错误！'];
        }

        if(!preg_match("/^.{6,12}$/", $options['password1'])){
            return ['err' => 3, 'msg' => '新密码位数必须在 6~12 位之间'];
        }

        if($options['password1'] != $options['password2']){
            return ['err' => 4, 'msg' => '两次密码输入不一致'];
        }

        if($options['password'] == $options['password1']){
            return ['err' => 5, 'msg' => '新密码与原始密码不能一致'];
        }

        if (!DB::table('user')->where(['id' => $id])->update([
            'password'=>md5($options['password1']),
            'sid' => $this->user['id'] . '_' . getRandChar(16)
        ])) {
            return ['err' => 5, 'msg' => '修改失败'];
        }
        return ['id' => $this->user['id']];
    }

    public function base64Upload($options/*id, $base64, path*/)
    {
        if (!$this->isLogin()) {
            return ['err' => 1, 'msg' => '会员未登录'];
        }
        $base64 = $options['base64'];
        if ($path = base64Upload($base64, $options['path'], $this->user['id']) . '?t=' . time()) {
            Db::table('user')->where(['id' => $this->user['id']])->update(['photo' => $path]);
        }
        return ['msg' => $path];

        // Db::table('user')->where(['id' => $this->user['id']])->update(['photo' => substr($photoPath, 1) . $photoUrl]);
    }

    public function quit(){
      session_destroy();
      $this->user = ['id' => 0];
      return [1];
    }

    public function info($options = [])
    {
        if (empty($options['id'])) {
            unset($options['id']);
            return $this->user;
        }
        return Db::table('user')->where(['id' => $options['id']])->find();
    }

    public function list($options)
    {
        $list = MUser::getList($options);
        return $list;
    }

    public function register($options /*['username', 'password', 'password2', 'email']*/)
    {
        $post = $options;
        $check = $this->dataCheck($post);
        if ($check['err']) {
            return $check;
        }
        if (Db::table('user')->where(['username' => $post['username']])->find()) {
            return ['err' => 8, 'msg' => '用户名重复，请更换！'];
        }
        $id = Db::table('user')->add([
            'username' => $post['username'],
            'nickname' => $post['username'],
            'password' => md5($post['password']),
            'photo' => '/static/images/photo.jpg',
            'email' => $post['email'],
            'last_time' => now(),
            'create_ip' => Request::ip()
        ]);
        $sid = $id . '_' . getRandChar(16);
        Db::table('user')->where(['id' => $id])->update([
            'sid' => $sid
        ]);

        Session::set('sid', $sid);

        return ['err' => 0];
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

    public function login($options /*['username', 'password']*/)
    {
        $post = $options;
        if (empty($post['username']) || empty($post['password'])) {
            return ['err' => 1, 'msg' =>'用户名或密码为空！'];
        }

        $where = ['username' => $post['username'], 'password' => md5($post['password'])];
        if (!$user = Db::table('user')->where($where)->find()) {
            return ['err' => 2, 'msg' =>'用户名或密登录失败！码为空！'];
        }

        Session::set('sid', $user['sid']);
        return ['err' => 0, 'msg' =>'登陆成功'];
    }

    public function isCare($options)
    {
        $options = array_merge([
            'user_id' => $this->user['id'],
            'care_user_id' => 0
        ], $options);
        if (empty($options['user_id'])) {
            return;
        }
        if (!$res = Db::table('friend')->where(['user_id' => $options['user_id'], 'care_user_id' => $options['care_user_id']])->find()) {
            return;
        }
        return true;
    }

    public function setCare($options)
    {
        $options = array_merge([
            'user_id' => $this->user['id'],
            'care_user_id' => 0
        ], $options);
        if (empty($options['user_id'])) {
            return ['err' => 1, 'msg' => '用户未登录'];
        }

        if ($options['care_user_id'] == $this->user['id']) {
            return ['err' => 2, 'msg' => '不能关注自己'];
        }


        if ($options['care_user_id'] == 0 || !$this->info(['id' => $options['care_user_id']])) {
            return ['err' => 3, 'msg' => '关注的用户不存在'];
        }

        if ($this->isCare($options)) {
            Db::table('friend')->where(['user_id' => $options['user_id'], 'care_user_id' => $options['care_user_id']])->remove();

            $content = '<a href="/user/show?id=' . $this->user['id'] . '">' .$this->user['nickname'] . '</a> 取消了对你的关注！';
            MMessage::create(0, $options['care_user_id'], $content);
            return ['msg' => '取消关注成功', 'is_care' => 0];

        }
        Db::table('friend')->add(['user_id' => $options['user_id'], 'care_user_id' => $options['care_user_id']]);
        
        $content = '<a href="/user/show?id=' . $this->user['id'] . '">' .$this->user['nickname'] . '</a> 关注了你！';
        MMessage::create(0, $options['care_user_id'], $content);
        return ['msg' => '关注成功', 'is_care' => 1];
    }

    public function fansList($options)
    {
        if (empty($options['care_user_id'])) {
            $options['care_user_id'] = $this->user['id'];
        }
        // $options = array_merge([
        //     'care_user_id' => $this->user['id']
        // ], $options);
        // if (empty($options['user_id'])) {
        //     return ['err' => 1, 'msg' => '用户未登录'];
        // }
        return Friend::getList($options);
    }

    public function careList($options)
    {
        if (empty($options['user_id'])) {
            $options['user_id'] = $this->user['id'];
        }
        // $options = array_merge([
        //     'user_id' => $this->user['id']
        // ], $options);
        // if (empty($options['user_id'])) {
        //     return ['err' => 1, 'msg' => '用户未登录'];
        // }
        return Friend::getList($options);
    }
}
