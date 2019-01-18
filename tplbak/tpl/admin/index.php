<?php self::load('common/header',['title' => '后台管理']); ?>
<link rel="stylesheet" href="/static/css/admin/style.css" type="text/css">
<div class="header_nav">
    <a href="/admin">后台首页</a>
    <a href="/">网站首页</a>
    <a class="ianmi_link" href="http://ianmi.com">安米程序(测试版)</a>
    <!-- <a href="/">待处理(0)</a> -->
</div>
<!-- <div>
    <a href="/Novel/add">添加小说</a>
</div>
<div>
    <a href="/Novel/mark">小说标签</a>
</div> -->

<!-- <div class="list list-lg">
    <div class="list-group list-arrow">
    <a href="/Novel/add" class="list-item ellipsis">添加小说</a>

    </div>
</div> -->
<div class="top_nav_box">
    <div class="top_nav tab tab-toggle">
        <div class="tab-header">
            <div class="tab-link tab-active" data-to-tab=".tab1">系统</div>
            <div class="tab-link" data-to-tab=".tab2">栏目</div>
            <div class="tab-link" data-to-tab=".tab3">会员</div>
            <div class="tab-link" data-to-tab=".tab4">内容</div>
            <div class="tab-link" data-to-tab=".tab5">其它</div>
        </div>
        <div class="tab-content">
                <div class="tab-page tab1 tab-active">
                    <div>网站基础配置</div>
                    <div>论坛配置</div>
                    <div>会员配置</div>
                    <div><a href="/admin/page">模板管理</a></div>
                </div>
                <div class="tab-page tab2">
                    <div>全部栏目</div>
                    <div>自定义</div>
                    <div>论坛</div>
                    <div>聊天室</div>
                </div>
                <div class="tab-page tab3">
                    <div>所有用户</div>
                    <div>查找用户</div>
                    <div>管理员/版主</div>
                    <div>vip会员</div>
                    <div>黑名单</div>
                    <div>回收站</div>
                </div>
                <div class="tab-page tab4">
                    <!-- <div>系统通知</div> -->
                    <div>帖子</div>
                    <div>聊天室</div>
                    <div>友链</div>
                </div>
                <div class="tab-page tab5">
                    <div>数据库备份/还原</div>
                    <div>流量统计</div>
                    <div>UBB大全</div>
                    <div>帮助文档</div>
                    <div>检查更新</div>
                </div>
        </div>
    </div>
</div>
<div class="admin_logo">
    <img src="/static/images/admin/logo.png" alt="">
</div>

<div class="tips">
    <span>
        当前版本号 <span class="version">v<?=$version?></span>
    </span>
    <span>
        最新版本号 <span class="version">v0.0.5</span>[更新]
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
