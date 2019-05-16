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
use Model\Forum;
use Model\ForumReply;
use Model\User as MUser;
use Model\Message as MMessage;
use Model\SignLog;

class User extends Common
{
    public function __construct()
    {
        parent::__construct();
        // $this->isLogin();
    }

    public function index()
    {
        $fans_count = Friend::where('care_user_id', $this->user['id'])->count();
        $care_count = Friend::where('user_id', $this->user['id'])->count();

        // 帖子相关
        $forum_count = Forum::where('user_id', $this->user['id'])->count();
        $forum_data = Forum::where('user_id', $this->user['id'])->order('id', 'desc')->find();

        // 评论相关
        $reply_count = ForumReply::where('user_id', $this->user['id'])->count();
        $reply_data = ForumReply::where('user_id', $this->user['id'])->order('id', 'desc')->find();
        View::load('user/index',[
            'fans_count' => $fans_count,
            'care_count' => $care_count,
            'forum_count' => $forum_count,
            'forum_data' => $forum_data,
            'reply_count' => $reply_count,
            'reply_data' => $reply_data
        ]);
    }

    /**
     * 资料修改界面
     */
    public function editPage()
    {
        View::load('user/edit_page');
    }

    /**
     * 修改资料
     */
    public function editInfo($nickname = '', $explain = '')
    {
        if (!$this->isLogin()) {
            return ['err' => 1, 'msg' => '会员未登录'];
        }
        $nickname = htmlspecialchars($nickname);
        $explain = htmlspecialchars($explain);
        if (mb_strlen($nickname) < 2) {
            return Response::json(['err' => 2, 'msg' => '昵称长度不能小于2个字符哦！']);
        }
        if (mb_strlen($nickname) > 16) {
            return Response::json(['err' => 3, 'msg' => '昵称太长啦，我记不住！']);
        }
        if (empty($explain)) {
            return Response::json(['err' => 4, 'msg' => '你忘了你的小尾巴了！']);
        }
        if (mb_strlen($explain) > 500) {
            return Response::json(['err' => 5, 'msg' => '你的小尾巴了太长了，我记不住！']);
        }
        MUser::where(['id' => $this->user['id']])->update(['nickname' => $nickname, 'explain' => $explain]);
        return Response::json(['id' => $this->user['id']]);

    }

    /**
     * 密码修改界面
     */
    public function updatePasswordPage()
    {
        View::load('user/update_password_page');
    }

    /**
     * 修改密码
     */
    public function updatePassword($password = '', $password1 = '', $password2 = ''){
        if (!$this->isLogin()) {
            return Response::json(['err' => 1, 'msg' => '会员未登录']);
        }
        $id = $this->user['id'];

        if (md5($password) != $this->user['password']) {
            return Response::json(['err' => 2, 'msg' => '原始密码错误！']);
        }

        if(!preg_match("/^.{6,12}$/", $password1)){
            return Response::json(['err' => 3, 'msg' => '新密码位数必须在 6~12 位之间']);
        }

        if($password1 != $password2){
            return Response::json(['err' => 4, 'msg' => '两次密码输入不一致']);
        }

        if($password == $password1){
            return Response::json(['err' => 5, 'msg' => '新密码与原始密码不能一致']);
        }

        if (!MUser::where(['id' => $id])->update([
            'password'=>md5($password1),
            'sid' => $this->user['id'] . '_' . getRandChar(16)
        ])) {
            return Response::json(['err' => 5, 'msg' => '修改失败']);
        }
        return Response::json(['id' => $this->user['id']]);
    }

    public function base64Upload($base64 = '')
    {
        if (!$this->isLogin()) {
            return Response::json(['err' => 1, 'msg' => '会员未登录']);
        }
        if ($path = base64Upload($base64, 'upload/user/', $this->user['id']) . '?t=' . time()) {
            MUser::where(['id' => $this->user['id']])->update(['photo' => $path]);
        }
        return Response::json(['msg' => $path]);

        // Db::table('user')->where(['id' => $this->user['id']])->update(['photo' => substr($photoPath, 1) . $photoUrl]);
    }

    public function quit(){
      session_destroy();
      $this->user = ['id' => 0];
      Url::redirect('/login');
    }

    /**
     * 我的粉丝
     */
    public function friendFans()
    {
        $fans_list = source('Model/Friend/getList', [
            'user_id' => $this->user['id']
        ]);
        
        $care_list = source('Model/Friend/getList', [
            'user_id' => $this->user['id'],
            'type' => 'care'
        ]);
        View::load('user/friend_fans', [
            'fans_list' => $fans_list,
            'care_list' => $care_list

        ]);
    }

    /**
     * 我关注的
     */
    public function friendCare()
    {
        $fans_list = source('Model/Friend/getList', [
            'user_id' => $this->user['id']
        ]);
        
        $care_list = source('Model/Friend/getList', [
            'user_id' => $this->user['id'],
            'type' => 'care'
        ]);
        View::load('user/friend_care', [
            'fans_list' => $fans_list,
            'care_list' => $care_list

        ]);
    }

    /**
     * 关注/取消关注
     */
    public function careUser($id = '')
    {
        if (!$this->isLogin()) {
            return Response::json(['err' => 1, 'msg' => '会员未登录']);
        }

        if ($id == $this->user['id']) {
            return Response::json(['err' => 2, 'msg' => '不能关注自己']);
        }


        if (empty($id) || !MUser::get($id)) {
            return Response::json(['err' => 3, 'msg' => '关注的用户不存在']);
        }

        if (source('Model/Friend/isCare', ['user_id' => $this->user['id'], 'care_user_id' => $id])) {
            Friend::where(['user_id' => $this->user['id'], 'care_user_id' => $id])->delete();

            $content = '<a href="/user/show?id=' . $this->user['id'] . '">' . $this->user['nickname'] . '</a> 取消了对你的关注！';
            MMessage::create(0, $id, $content);
            return Response::json(['msg' => '取消关注成功', 'is_care' => 0]);

        }
        Friend::create(['user_id' => $this->user['id'], 'care_user_id' => $id]);
        
        $content = '<a href="/user/show?id=' . $this->user['id'] . '">' . $this->user['nickname'] . '</a> 关注了你！';
        MMessage::create(0, $id, $content);
        return Response::json(['msg' => '关注成功', 'is_care' => 1]);
    }

    /**
     * 用户信息展示
     */
    public function show($id = '')
    {
        $userinfo = MUser::get($id);
        View::load('user/show', [
            'userinfo' => $userinfo
        ]);
    }

    public function info($options = [])
    {
        if (empty($options['id'])) {
            unset($options['id']);
            return $this->user;
        }
		$user = Db::table('user')->where(['id' => $options['id']])->find();
		$level_info = getUserLevel($user['exp'], $this->upExp);
        $user = array_merge($user, $level_info);
        $user['is_today_sign'] = SignLog::isTodaySign($user['id']);
        return $user;
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
        return Friend::getList($options);
    }

    public function careList($options)
    {
        if (empty($options['user_id'])) {
            $options['user_id'] = $this->user['id'];
        }
        return Friend::getList($options);
    }

    /**
     * 获取用户排行榜
     */
    public function rank()
    {

        View::load('user/rank');
    }
}
