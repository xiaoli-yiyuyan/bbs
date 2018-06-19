<?php self::load('Common/header',['title' => '安米小说']); ?>
<div class="header">
    <span class="back"></span>
    <span class="left-word">书架列表</span>
    <?php if (empty($user['id'] > 0)){ ?>
        <a href="/Login/index" class="right-nav">登陆/注册</a>
    <?php } else { ?>
        <a href="/User/index" class="right-nav"><?=$user['username']?></a>
    <?php } ?>
</div>
<div>
<?php if ($count !=0) {foreach ($new_list as $item) { ?>
    <a class="novel-list" href="/Novel/view?id=<?=$item['id']?>">
        <div class="novel-photo" style="background-image:url(<?=$item['photo']?>);"></div>
        <div class="novel-info">
            <div class="novel-title"><?=$item['title']?> - <?=$item['author']?></div>
            <div>标签：<?php foreach ($item['mark'] as $mark) { ?><?=$mark['title']?> <?php } ?></div>
            <div class="novel-memo">简介：<?=$item['memo']?></div>
        </div>
    </a>
<?php } } else{echo $new_list;} ?>
</div>
<?php self::load('Common/footer',['title' => '安米小说']); ?>
