<?php $this->load('/components/common/header', ['title' => '首页']); ?>

<link rel="stylesheet" href="/static/swiper/css/swiper.min.css">
<script src="/static/swiper/js/swiper.min.js"></script>

<link rel="stylesheet" href="/static/css/novel/style.css?v=0.0.1">


<script src="/static/js/iscroll.js"></script>
<div class="header-height"></div>
<header class="header">
    <span class="logo"></span>
    <div class="flex-box">
    <a href="/user/index" class="icon-svg user"></a>
    <div class="icon-svg menu left-menu"></div>
    </div>
</header>
<?php $this->load('/components/common/left_menu'); ?>

<div class="m_nav">
    <div class="h1">安米程序 v0.1.0(测试版)</div>
    <div class="test_site">演示网站: <a href="http://test.ianmi.com">http://test.ianmi.com</a></div>
    <div class="btn">点击下载(2.51M)</div>
</div>

<div class="column_nav">
    <?php foreach ($column_list['data'] as $item) { ?>
    <a class="column_link" href="/forum/list?id=<?=$item['id']?>">
        <img class="column_photo" src="<?=$item['photo']?>" alt="<?=$item['title']?>">
        <div class="column_info">
            <div class="column_title"><?=$item['title']?></div>
            <div class="column_count">
                总数: <?php $this->load('/components/forum/get_count_by_class_id', ['class_id' => $item['id']]); ?>
            </div>
        </div>
    </a>
    <?php } ?>
</div>

<div class="m_body">
    <div class="title-nav"><span class="title-i"></span>最近活跃会员</div>
    <?php $this->load('/components/user/new_user_list'); ?>
</div>
<?php $this->load('/components/forum/list', ['list' => $list]); ?>

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
<?php $this->load('/components/common/footer'); ?>