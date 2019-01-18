<?php self::load('common/header', ['title' => '安米小说']); ?>
<link rel="stylesheet" href="/static/css/novel/style.css?v=0.0.1">
<div class="header">
    <span class="back"></span>
    <a href="/novel" class="left-word">小说首页</a>

    <span class="header-right flex-box novel-header-right">
        <a class="icon-svg svg-user2" href="/User/index"></a>
        <a class="icon-svg svg-book" href="/User/myBooks"></a>
    </span>
</div>
<div class="novel-list-box">
    <div class="title-nav"><span class="title-i"></span>我的书架</div>
    
    <?php if (empty($list)) { ?>
    <div class="bbs_empty">这个地方空空如也！</div>
    <?php } else { ?>
        <?php foreach ($list as $item) { ?>
        <a class="novel-list" href="/Novel/view?id=<?=$item['id']?>">
            <div class="novel-photo" style="background-image:url(<?=$item['photo']?>);"></div>
            <div class="novel-info">
                <div class="novel-title"><?=$item['title']?> - <?=$item['author']?></div>
                <div>标签：<?php foreach ($item['mark'] as $mark) { ?><?=$mark['title']?> <?php } ?></div>
                <div class="novel-memo">简介：<?=$item['memo']?></div>
            </div>
        </a>
        <?php } ?>
    <?php } ?>
</div>
<?php self::load('common/novel_footer'); ?>
<?php self::load('common/footer',['title' => '网页标题']); ?>
