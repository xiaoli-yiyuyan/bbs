<?php self::load('Common/header',['title' => '论坛中心']); ?>
<script src="/static/js/iscroll.js"></script>

<div class="header">
    <span class="back"></span>
    <span class="left-word">论坛</span>

    <span class="header-right">
        <a class="icon-svg user" href="/User/index"></a>
    </span>
</div>
<!-- Begin 滑动导航 -->
<div class="nav-touch" id="wrapper2">
    <div class="nav-touch-box">
    <?php foreach ($class_list as $item) { ?>
        <a class="nav-link" href="/forum/list?id=<?=$item['id']?>"><?=$item['title']?></a>
    <?php } ?>
    </div>
</div>
<!-- End 滑动导航 -->

<div class="forum_index_title">新帖导航</div>

<div class="list bbs_list">
<?php foreach ($list as $item) { ?>
    <div class="list-group">
        <div class="list-item">
            <?=$item['title']?>
        </div>
        <div class="bbs_info border-t">
            <div class="bbs_user"><img class="bbs_user_photo" src="<?=$item['photo']?>" alt=""> <?=$item['nickname']?></div>
            <div class="create_time">
                <span class="bbs_replay_num"><?=$item['read_count']?>回/<?=$item['replay_count']?>逛</span>
                <?=$item['create_time']?>
            </div>
        </div>
    </div>
<?php } ?>
</div>

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
<?php self::load('Common/footer'); ?>
