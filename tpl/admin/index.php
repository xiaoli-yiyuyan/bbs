<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>
<div class="admin_logo">
    <img src="/static/images/admin/logo.png" alt="">
</div>

<div class="tips">
    <span>
        当前版本号 <span class="version">v<?=$version?></span>
    </span>
    <span>
        最新版本号 <span class="version"><?=$new_version?></span><span class="btn_update">[更新]</span>
    </span>
    <a href="http://ianmi.com">官网</a>
</div>

<div class="content">
    <div class="count_box">
        <div class="count_group">
            <div class="count_item">
                <div>会员总数</div>
                <div><?=$count?></div>
            </div>
            <div class="count_item">
                <div>今日注册</div>
                <div><?=$today_count?></div>
            </div>
            <div class="count_item">
                <div>当前在线</div>
                <div><?=$online_count?></div>
            </div>
        </div>
        <div class="count_group">
            <div class="count_item">
                <div>发帖总数</div>
                <div><?=$forum_count?></div>
            </div>
            <div class="count_item">
                <div>今日发帖</div>
                <div><?=$forum_today_count?></div>
            </div>
            <div class="count_item">
                <div>今日回复</div>
                <div><?=$forum_reply_today_count?></div>
            </div>
        </div>
    </div>
</div>
<div class="footer_nav">
    <div>安米程序 v<?=$version?> (2018新鲜出炉)</div>
    <div>本程序免费开源 官网地址 <a class="ianmi_link" href="http://ianmi.com">http://ianmi.com</a></div>
</div>
<style>
    .update_plane {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, .5);
        z-index: 9999;
        color: #FFFFFF;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 700;
        animation: myfirst 10s infinite;
    }
    @keyframes myfirst
    {
        0% {color: #FFFFFF;}
        50% {color: #00d642;}
        100% {color: #FFFFFF;}
    }

</style>
<div class="update_plane">
    程序正在升级中
</div>
<script>
    $('.btn_update').click(function() {
        $('.update_plane').css('display', 'flex');
        $.get('/admin/sys_update').then(function($data) {
            $('.update_plane').css('display', 'none');
            alert($data.msg);
        });
    });
</script>
<?php self::load('common/footer'); ?>
