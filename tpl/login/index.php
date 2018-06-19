<?php self::load('Common/header',['title' => '登陆网站']); ?>
<div class="login-main">
    <a class="logo" href="/">

    </a>
    <form class="" action="/Login/login" method="post">
        <div><input type="text" name="username" placeholder="用户名"></div>
        <div><input type="password" name="password" placeholder="密码"></div>
        <div><button>登陆</button></div>
        <div class="login-reg-nav">
            <a class="func-null">忘记密码</a>
            <a href="/Login/register">立即注册</a>
        </div>
    </form>
</div>
<?php self::load('Common/footer'); ?>
