<?php component('components/common/header',['title' => '登陆网站']); ?>
<?php component('/components/common/header_nav', ['back_url' => '/', 'title' => '首页']); ?>
<div class="login-main">
    <a class="logo" href="/" style="background-image:url(../<?=$weblogo?>);">

    </a>
    <form class="" action="/login/login" method="post">
        <div><input class="input input-lg" type="text" name="username" placeholder="用户名"></div>
        <div><input class="input input-lg" type="password" name="password" placeholder="密码"></div>
        <div><button class="btn btn-fill btn-block btn-lg">登陆</button></div>
        <div class="login-reg-nav">
            <a class="func-null">忘记密码</a>
            <?php if($is_register == 1) {?><a href="/login/register">立即注册</a><?php }?>
        </div>
    </form>
</div>
<div class="g_word"><?=$webname?> - 手机建站</div>
<?php component('components/common/footer'); ?>
