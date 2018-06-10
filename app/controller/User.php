<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Page;
use Iam\Listen;
use Iam\Request;
use Iam\Response;
use Iam\FileUpload;

class User extends Common
{
    public function __construct()
    {
        parent::__construct();
        $this->isLogin();
    }
    public function index()
    {
  	   View::load('User/index',['a' => 1]);
    }

    public function updateInfo(){
      if (Request::isPost()) {
          $nickname = Request::post('nickname');
          $explain = Request::post('explain');
          DB::table('user')->where(['id' => $this->user['id']])->update(['nickname' => $nickname, 'explain' => $explain]);
          echo "修改成功";
      }
      View::load('User/updateInfo');
    }

    public function editInfo()
    {
        $data = Request::post(['nickname', 'explain']);
        $data['nickname'] = htmlspecialchars($data['nickname']);
        $data['explain'] = htmlspecialchars($data['explain']);
        if (mb_strlen($data['nickname']) < 2) {
            return Page::error('昵称长度不能小于2个字符哦！');
        }
        if (mb_strlen($data['nickname']) > 16) {
            return Page::error('昵称太长啦，我记不住！');
        }
        if (empty($data['explain'])) {
            return Page::error('你忘了你的小尾巴了！');
        }
        if (mb_strlen($data['explain']) > 500) {
            return Page::error('你的小尾巴了太长了，我记不住！');
        }
        DB::table('user')->where(['id' => $this->user['id']])->update($data);
        return Page::success('修改成功');

    }

    public function photoUpload()
    {
          $photoPath = "./public/photo/";
          print_r($photoPath);
      $up = new FileUpload();
        //设置属性（上传的位置、大小、类型、设置文件名是否要随机生成）
        $up->set("path",$photoPath);
        $up->set("maxsize",2000000); //kb
        $up->set("allowtype",array("gif","png","jpg","jpeg"));//可以是"doc"、"docx"、"xls"、"xlsx"、"csv"和"txt"等文件，注意设置其文件大小
        $up->set("israndname",true);//true:由系统命名；false：保留原文件名

        //使用对象中的upload方法，上传文件，方法需要传一个上传表单的名字name：pic
        //如果成功返回true，失败返回false

        if($up->upload("photo")){
          echo '<pre>';
          //获取上传成功后文件名字
          $photoUrl= $up->getFileName();
          Db::table('user')->where(['id' => $this->user['id']])->update(['photo' => substr($photoPath, 1) . $photoUrl]);
          echo '</pre>';

        }else{
          echo '<pre>';
          //获取上传失败后的错误提示
          var_dump($up->getErrorMsg());
          echo '<pre/>';
        }
    }

    public function base64Upload()
    {
        $base64 = Request::post('base64');
        if ($path = base64Upload($base64, 'static/uploads/photo/', $this->user['id']) . '?t=' . time()) {
            Db::table('user')->where(['id' => $this->user['id']])->update(['photo' => $path]);
        }
        return Response::json(['err' => 1, 'msg' => $path]);

        // Db::table('user')->where(['id' => $this->user['id']])->update(['photo' => substr($photoPath, 1) . $photoUrl]);
    }

    public function myBooks(){
      $this->isLogin();
      $collectId = Db::table('novel_collect')->field('novelId')->where(['userid' => $this->user['id']])->select();

      $count = count($collectId);
      if ($count){
        foreach ($collectId as $key => $value) {
          $myBooks[] = Db::table('novel')->find('id',$value['novelId']);
        }
        foreach ($myBooks as &$item) {
            $item['mark'] = $this->getMarkTitle($item['id']);
         }
      }

      $bookList = $count ? $myBooks : '您还没有添加任何书籍';
      View::load('User/myBooks',['new_list' => $bookList,'count' => $count]);
    }
    public function getMarkTitle($novelid)
    {
      // echo "<pre>";
      //  print_r($novelid);
        $mark = Db::query('SELECT * FROM `novel_mark` WHERE `id` IN(SELECT `markid` FROM `novel_mark_body` WHERE `novelid`=?)', [$novelid]);
        return $mark;
     }
    public function updatePwd(){
      if (Request::isPost()) {
        $id = $this->user['id'];
        $oldPwd = $this->user['password'];
        $postdata = Request::post();
        if( strlen($postdata['password']) < 6 ){
          return Page::error('密码位数不得低于6位');
        }
        if( $postdata['password'] == $postdata['oldpwd']){
          return Page::error('原始密码与新密码不能一样');
        }
        if( $postdata['password'] != $postdata['passwordAgain']){
          return Page::error('密码与密码确认不一致');
        }

        if( md5($postdata['oldpwd'])  != $oldPwd){
            return Page::error('原始密码不正确');
        }
        DB::table('user')->where(['id' => $id])->update(['password'=>md5($postdata['password'])]);
        echo "修改成功";
      }
      View::load('User/updatePwd');
    }

    public function quit(){
      session_destroy();
      $this->user = ['id' => 0];
      Url::redirect('/Login/index');
    }
}
