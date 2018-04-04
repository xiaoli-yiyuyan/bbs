<?php self::load('Common/header',['title' => '论坛中心']); ?>
<div class="header">
    <span class="back"></span>
    <span class="left-word"><?=$classInfo['title']?></span>
    <?php if (empty($user['id'] > 0)){ ?>
        <a href="/Login/index" class="right-nav">登陆/注册</a>
    <?php } else { ?>
        <a href="/User/index" class="right-nav"><?=$user['username']?></a>
    <?php } ?>
</div>
<?php self::load('Common/footer'); ?>
