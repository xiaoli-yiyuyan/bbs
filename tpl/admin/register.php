<?php self::load('Common/header',['title' => '登陆网站']); ?>
    <div><a href="/">返回首页</a>|<a href="/Login">返回登陆</a></div>
    <form class="" action="/Login/register" method="post">
        <div>用户名：<input type="text" name="username" placeholder="用户名"></div>
        <div>密码：<input type="text" name="password" placeholder="密码"></div>
        <div>重复密码：<input type="text" name="password2" placeholder="重复密码"></div>
        <div>邮箱：<input type="text" name="email" placeholder="重复密码"></div>
        <div>√同意注册协议 | <button>立即注册</button></div>
    </form>
<?php self::load('Common/footer'); ?>
