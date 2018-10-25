<!-- Begin 滑动导航 -->
<div class="nav-touch new_user_box" id="wrapper2">
    <div class="nav-touch-box">
        <?php foreach ($user_list['data'] as $item) { ?>
        <a href="/user/show?id=<?=$item['id']?>" class="nav-link new_user">
            <img class="bbs_user_photo" src="<?=$item['photo']?>" alt="<?=$item['nickname']?>">
            <span><?=$item['nickname']?></span>
        </a>
        <?php } ?>
    </div>
</div>
<!-- End 滑动导航 -->
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