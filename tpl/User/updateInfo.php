<?php self::load('Common/header',['title' => '修改昵称']); ?>
<div class="header">
  <span class="logo"></span>
    <span class="right-nav"><a href="/">首页</a> | <a href="/User">个人中心</a></span>
</div>
<div class="">
    <form class="" action="/User/updateInfo" method="post">
      <table>
          <tr>
            <td>用户名：</td>
            <td><?=$user['username']?></td>
          </tr>
          <tr>
            <td>昵 称：</td>
            <td><input type="text" name="nickname" value="<?=$user['nickname']?>"></td>
          </tr>
          <tr>
            <td colspan="2"><button> 提交修改 </button></td>
          </tr>
      </table>
    </form>
</div>

<?php self::load('Common/footer'); ?>
<style>
table {width: 80%;margin-left:15%;padding: 20px 0;border-spacing: 10px}
table tr td:nth-child(1) {width: 17%;}
table tr td:nth-child(2) {width: 50%;}
table button{margin-left: 28%;border-radius: 3px}
</style>
