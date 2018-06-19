<?php self::load('Common/header',['title' => '修改资料']); ?>

<div class="header">
    <span class="logo"></span>
    <div class="head_center">修改资料</div>
    <span class="header-right">
        <a class="icon-svg svg-user" href="/User/index"></a>
    </span>
</div>
<form class="box-padding" action="/User/edit_info" method="post">

<!-- <div class="update-photo-box">
  <img src="<?=$user['photo']?>" alt="">
  <?=$user['username']?>
</div> -->
<div class="item-line item-lg">
    <div class="item-title">昵称</div>
    <div class="item-input"><input type="text" class="input input-line input-lg" name="nickname" placeholder="昵称" value="<?=$user['nickname']?>"></div>
</div>

<div class="item-line item-lg">
    <div class="item-title">小尾巴</div>
    <div class="item-input"><textarea name="explain" class="input input-line input-lg" placeholder="小尾巴"><?=$user['explain']?></textarea></div>
</div>

<p><button class="btn btn-fill btn-lg" style="width: 100%;">修改</button></p>
</form>


<!-- <div class="">
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
</div> -->

<?php self::load('Common/footer'); ?>
<style>
table {width: 80%;margin-left:15%;padding: 20px 0;border-spacing: 10px}
table tr td:nth-child(1) {width: 17%;}
table tr td:nth-child(2) {width: 50%;}
table button{margin-left: 28%;border-radius: 3px}
</style>
