<?php useComp("/components/common/header" ); ?>
<?php useComp("/components/common/header_menu_nav?title=首页" ); ?>


<link rel="stylesheet" href="/static/js/swiper.min.css?v=<?=$version?>">
<script src="/static/js/swiper.min.js?v=<?=$version?>"></script>


<?php useComp("/components/images/slider_link" ); ?>


<?php $column = source('Model/Category/getList', ['pagesize' => 10]); ?>
<div class="column_index_box flex-box">
    <?php foreach ($column as $item) { ?>
        <a class="column_index_item" href="/forum/list?id=<?=$item['id']?>">
            <div class="column_photo_box">
                <img class="column_photo" src="<?=$item['photo']?>" alt="<?=$item['title']?>">
            </div>
            <div class="column_title"><?=$item['title']?></div>
        </a>
    <?php } ?>
</div>
<div class="func-more">
    <a class="func-more-item" href="/sign/index">
        <div class="title">Go签到</div>
        <div class="info">暴击签到</div>
    </a>
    <a class="func-more-item" href="/forum/my_list">
        <div class="title">My帖子</div>
        <div class="info">发帖记录</div>
    </a>
    <a class="func-more-item" href="/forum/reply_art_list">
        <div class="title">My评论</div>
        <div class="info">互动记录</div>
    </a>
    <a class="func-more-item" href="/user/rank">
        <div class="title">名人榜</div>
        <div class="info">围观名人</div>
    </a>
</div>
<div class="empty-block"></div>
<?php
    $tp = \Iam\Request::get('tp', 1);
    if ($tp == 2) {
        $list = source('Model/Forum/getList', [
            'type' => 1
        ]);
    } elseif ($tp == 3) {
    
        $list = source('Model/Forum/getList', [
            'type' => 5
        ]);
    } elseif ($tp == 4) {
    
        $list = source('Model/Forum/getList', [
            'type' => 6
        ]);
    } elseif ($tp == 5) {
        $list = source('Model/Forum/getList', [
            'type' => 7
        ]);
    } else {
        $list = source('Model/Forum/getList', [
            'type' => 2
        ]);
    }

    // $forum = new \api\Sign;
    // $list = $forum->list();
    // print_r($list);die();
?>

<div class="_index_nav">
    <div <?=$tp == 1 ? 'class="_active"' : ''?>>
        <a href="/index/index?tp=1">推荐</a>
    </div>
    <div <?=$tp == 2 ? 'class="_active"' : ''?>>
        <a href="/index/index?tp=2">最新</a>
    </div>
    <div <?=$tp == 3 ? 'class="_active"' : ''?>>
        <a href="/index/index?tp=3">话题</a>
    </div>
    <div <?=$tp == 4 ? 'class="_active"' : ''?>>
        <a href="/index/index?tp=4">图片</a>
    </div>
    <div <?=$tp == 5 ? 'class="_active"' : ''?>>
        <a href="/index/index?tp=5">文件</a>
    </div>
</div>

<div class="list img_list">
<?php foreach($list as $item) { ?>
<?php useComp('/components/forum/list_care', ['item' => $item]); ?>
<?php } ?>
</div>
<?=$list->render([
    'tp' => $tp
])?>
<?=code('copyright')?>
<script>        
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        lazyLoading: true,
        spaceBetween: 0,
        loop: true,
        autoplay: 5000,
    }); 
</script>
<?php useComp('/components/common/footer_nav', ['index' => 0]); ?>
<?php useComp('/components/common/footer'); ?>