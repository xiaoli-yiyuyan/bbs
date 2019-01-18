<?php self::load('common/header',['title' => '登陆网站']); ?>
<div class="header">
    <span class="logo"></span>
</div>
<div class="login-main">
    <form class="" action="/Login/register" method="post">
        <div><input type="text" name="username" placeholder="用户名"></div>
        <div><input type="text" name="password" placeholder="密码"></div>
        <div><input type="text" name="password2" placeholder="重复密码"></div>
        <div><input type="text" name="email" placeholder="邮箱"></div>
        <div><button>立即注册</button></div>
    </form>
</div>
<?php self::load('common/footer'); ?>
