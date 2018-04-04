<?php self::load('Common/header',['title' => '查看帖子']); ?>
<div class="header">
    <span class="back"></span>
    <span class="left-word">标题</span>
    <?php if (empty($user['id'] > 0)){ ?>
        <a href="/Login/index" class="right-nav">登陆/注册</a>
    <?php } else { ?>
        <a href="/User/index" class="right-nav"><?=$user['username']?></a>
    <?php } ?>
</div>
<div class="content-main">
    <div class="flex-box">
        <div class="flex"></div>
    </div>
    <?=$forum_info['context']?>
</div>

<?php self::load('Common/footer'); ?>
