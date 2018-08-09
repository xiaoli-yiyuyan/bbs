<?php $this->load('components/common/header',['title' => '登陆网站']); ?>
<?php $this->load('/components/common/header_nav', ['back_url' => '/', 'title' => '首页']); ?>
<div class="login-main">
    <form class="" action="/login/register" method="post">
        <div><input class="input input-lg" type="text" name="username" placeholder="用户名"></div>
        <div><input class="input input-lg" type="text" name="password" placeholder="密码"></div>
        <div><input class="input input-lg" type="text" name="password2" placeholder="重复密码"></div>
        <div><input class="input input-lg" type="text" name="email" placeholder="邮箱"></div>
        <div><button class="btn btn-fill btn-block btn-lg">立即注册</button></div>
    </form>
</div>
<div class="g_word">安米社区 - 手机建站</div>

<?php $this->load('components/common/footer'); ?>
