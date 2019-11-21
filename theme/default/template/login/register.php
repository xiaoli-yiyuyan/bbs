<?php useComp('components/common/header',['title' => '登陆网站']); ?>
<?php useComp('/components/common/header_nav', ['back_url' => '/', 'title' => '欢迎入住']); ?>
<div class="login-main">
    <form class="login" action="/login/register" method="post">
        <div class="login-item">
            <div class="icon-svg user"></div>
            <input class="input input-lg" type="text" name="username" placeholder="用户名">
        </div>
        <div class="login-item">* 如果昵称留空则以用户名作为昵称显示哦(*^▽^*)</div>
        <div class="login-item">
            <div class="icon-svg like"></div>
            <input class="input input-lg" type="text" name="nickname" placeholder="昵称">
        </div>
        <div class="login-item">
            <div class="icon-svg pass"></div>
            <input class="input input-lg" type="password" name="password" placeholder="密码">
        </div>
        <div class="login-item">
            <div class="icon-svg pass"></div>
            <input class="input input-lg" type="password" name="password2" placeholder="重复密码">
        </div>
        <div class="login-item">
            <div class="icon-svg message"></div>
            <input class="input input-lg" type="text" name="email" placeholder="邮箱">
        </div>
        <div class="login-item"><button class="btn btn-fill btn-block btn-lg">立即注册</button></div>
    </form>
</div>

<?php useComp('components/common/footer'); ?>
