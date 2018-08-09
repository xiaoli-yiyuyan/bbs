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
        最新版本号 <span class="version">v-.-.-</span>[更新]
    </span>
    <a href="http://ianmi.com">官网</a>
</div>

<div class="content">
    <div class="count_box">
        <div class="count_group">
            <div class="count_item">
                <div>会员总数</div>
                <div>0</div>
            </div>
            <div class="count_item">
                <div>今日注册</div>
                <div>0</div>
            </div>
            <div class="count_item">
                <div>当前在线</div>
                <div>0</div>
            </div>
        </div>
        <div class="count_group">
            <div class="count_item">
                <div>发帖总数</div>
                <div>0</div>
            </div>
            <div class="count_item">
                <div>今日发帖</div>
                <div>0</div>
            </div>
            <div class="count_item">
                <div>今日回复</div>
                <div>0</div>
            </div>
        </div>
    </div>
</div>
<div class="footer_nav">
    <div>安米程序 v<?=$version?> (2018新鲜出炉)</div>
    <div>本程序免费开源 官网地址 <a class="ianmi_link" href="http://ianmi.com">http://ianmi.com</a></div>
</div>
<?php self::load('common/footer'); ?>
