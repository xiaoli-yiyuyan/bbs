<?php self::load('Common/header',['title' => '安米小说']); ?>
<link rel="stylesheet" href="/static/swiper/css/swiper.min.css">
<script src="/static/swiper/js/swiper.min.js"></script>
<script src="/static/js/iscroll.js"></script>

<div class="header">
    <span class="logo"></span>
    <?php if (empty($user['id'] > 0)){ ?>
        <a href="/Login/index" class="right-nav">登陆/注册</a>
    <?php } else { ?>
        <a href="/User/index" class="right-nav"><?=$user['username']?></a>
    <?php } ?>
</div>
    <form class="index-search" action="/Novel/search" method="get">
        <div><input type="text" name="word" value="" placeholder="输入您要搜索的关键词！"></div>
        <div><button name="action" value="0">搜全部</button> <button name="action" value="1">搜书名</button> <button name="action" value="2">搜作者</button> <button name="action" value="3">搜标签</button></div>
    </form>

    <!-- Begin 滑动导航 -->
<div class="nav-touch" id="wrapper2">
            <div class="nav-touch-box">
                
            <?php foreach ($mark as $item) { ?>
                <a class="nav-link" href="/Novel/list?id=<?=$item['id']?>"><?=$item['title']?></a>
            <?php } ?>
            </div>
        </div>
    <!-- End 滑动导航 -->
    <a href="/chat/room/?id=2">聊天室</a>
    <a href="/forum/index/?id=2">论坛</a>

    <!-- <div class="mark-title">
        <?php foreach ($mark as $item) { ?>
            <a href="/Novel/list?id=<?=$item['id']?>"><?=$item['title']?></a>
        <?php } ?>
    </div> -->
    <div class="title-nav"><span class="title-i"></span>最新</div>
    <div>

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
    <div class="footer">IANMI 安米小说系统</div>
    <script>


    $(function() {

        $('.nav-touch-box').width(function() {
            return this.scrollWidth;
        });
        var navScroll = new IScroll("#wrapper2", {
            snap: 'a',
            scrollX:true,
            scrollY:false,
            click: true,
            taps:true
        });
    });
    
    </script>
<?php self::load('Common/footer',['title' => '网页标题']); ?>
