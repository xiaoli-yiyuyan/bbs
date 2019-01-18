<?php self::load('common/header',['title' => '安米小说']); ?>

<link rel="stylesheet" href="/static/swiper/css/swiper.min.css">
<script src="/static/swiper/js/swiper.min.js"></script>

<link rel="stylesheet" href="/static/css/novel/style.css?v=0.0.1">

<div class="header">
    <span class="back"></span>
    <a href="/" class="left-word">首页</a>
    <span class="header-right flex-box novel-header-right">
        <a class="icon-svg svg-user2" href="/user/index"></a>
        <a class="icon-svg svg-book" href="/novel/favorite"></a>
    </span>
</div>
<div class="banner swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="/static/images/novel/bar/bar2.jpg" alt=""></div>
        <div class="swiper-slide"><img src="/static/images/novel/bar/bar1.jpg" alt=""></div>
        <div class="swiper-slide"><img src="/static/images/novel/bar/bar3.jpg" alt=""></div>
        <div class="swiper-slide"><img src="/static/images/novel/bar/bar4.jpg" alt=""></div>
    </div>
    <div class="swiper-pagination"></div>
</div>
    
<form class="index-search" action="/Novel/search" method="get">
    <div><input type="text" name="word" value="" placeholder="输入您要搜索的关键词！"></div>
    <div><button name="action" value="0">搜全部</button> <button name="action" value="1">搜书名</button> <button name="action" value="2">搜作者</button> <button name="action" value="3">搜标签</button></div>
</form>

<div class="flex-box top-nav">
    <div class="flex">
        <a href="/novel/sort">
            <i class="icon-svg icon-sort"></i>
            <div class="top-nav-word">分类</div>
        </a>
    </div>
    <div class="flex">
        <a href="/novel/rank?tp=1">
            <i class="icon-svg icon-rank"></i>
            <div class="top-nav-word">排行</div>
        </a>
    </div>
    <!-- <div class="flex">
        <a href="">
            <i class="icon-svg icon-fuli"></i>
            <div class="top-nav-word">福利</div>
        </a>
    </div> -->
    <div class="flex">
        <a href="/novel/rank?tp=2">
            <i class="icon-svg icon-newbook"></i>
            <div class="top-nav-word">新书</div>
        </a>
    </div>
    <div class="flex">
        <a href="/novel/rank?tp=3">
            <i class="icon-svg icon-finishbook"></i>
            <div class="top-nav-word">完本</div>
        </a>
    </div>
</div>

<div class="novel-list-box">
    <div class="title-nav"><span class="title-i"></span>最近更新小说</div>
    <?php foreach ($new_list as $item) { ?>
        <a class="novel-list" href="/Novel/view?id=<?=$item['id']?>">
            <div class="novel-photo" style="background-image:url(<?=$item['photo']?>);"></div>
            <div class="novel-info">
                <div class="novel-title"><?=$item['title']?> - <?=$item['author']?></div>
                <div>标签：<?php foreach ($item['mark'] as $mark) { ?><?=$mark['title']?> <?php } ?></div>
                <div class="novel-memo">简介：<?=$item['memo']?></div>
            </div>
        </a>
    <?php } ?>
</div>
<script>
$(function() {
    var mySwiper = new Swiper ('.swiper-container', {
        autoplay: true,
        pagination: {
            'el': '.swiper-pagination'
        }
    })
});
</script>
<?php self::load('common/novel_footer'); ?>
<?php self::load('common/footer',['title' => '网页标题']); ?>
