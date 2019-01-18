<?php self::load('common/header',['title' => '修改密码']); ?>
<div class="header">
  <span class="logo"></span>
    <span class="right-nav"><a href="/">首页</a> | <a href="/User">个人中心</a></span>
</div>
<div class="">
    <form class="" action="/User/updatePwd" method="post">
      <table>
          <tr>
            <td>原始密码：</td>
            <td><input type="password" name="oldpwd" value=""></td>
          </tr>
          <tr>
            <td>重置密码：</td>
            <td><input type="password" name="password"></td>
          </tr>
          <tr>
            <td>确认密码：</td>
            <td><input type="password" name="passwordAgain"></td>
          </tr>
          <tr>
            <td colspan="2"><button> 提交修改 </button></td>
          </tr>
      </table>
    </form>
</div>
<?php self::load('common/footer'); ?>
<style>
table {width: 80%;margin-left:15%;padding: 20px 0;border-spacing: 10px}
table tr td:nth-child(1) {width: 22%;}
table tr td:nth-child(2) {width: 50%;}
table button{margin-left: 28%;border-radius: 3px}
</style>
