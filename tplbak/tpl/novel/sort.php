<?php self::load('common/header',['title' => '安米小说']); ?>

<link rel="stylesheet" href="/static/css/novel/style.css?v=0.0.1">

<div class="header">
    <span class="back"></span>
    <a href="/novel/index" class="left-word">小说首页</a>
    <span class="header-right flex-box novel-header-right">
        <a class="icon-svg svg-user2" href="/User/index"></a>
        <a class="icon-svg svg-book" href="/User/myBooks"></a>
    </span>
</div>

<div class="novel-list-box mark-sort">
    <div class="title-nav"><span class="title-i"></span>标签分类</div>
    <?php foreach ($mark as $item) { ?>
        <a class="novel-list" href="/Novel/list?id=<?=$item['id']?>">
            <div class="novel-photo" style="background-image:url(<?=$item['fitst_novel_photo']?>);"></div>
            <div class="novel-info">
                <div class="novel-title"><?=$item['title']?></div>
                <div class="novel-memo">总数：<?=$item['count']?></div>
            </div>
            <div class="novel-mark-right">
                <i class="icon-svg svg-arrow-right"></i>
            </div>
        </a>
    <?php } ?>
</div>
<?php self::load('common/novel_footer'); ?>
<?php self::load('common/footer',['title' => '网页标题']); ?>
