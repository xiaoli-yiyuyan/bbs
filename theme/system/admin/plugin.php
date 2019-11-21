<?php self::load('common/header',['title' => '后台管理-奖励设置']); ?>
<?php self::load('admin/header_nav'); ?>
<script src="/static/js/template.js?v=<?=$version?>"></script>

<style>
    .list-item {
        border-bottom: 1px solid #eee;
    }
</style>
<div class="content">
    <div class="namespace">
        <a href="/admin/user/">系统设置</a> \ <div class="nav_title">主题管理</div>
    </div>
    <div class="page_nav">
        <a href="/admin/my_plugin">我的插件</a>
        <a href="/admin/plugin">插件库</a>
        <!-- <a href="/admin/add_page?type=1">添加页面</a> -->
    </div>
</div>
<?php self::load('common/footer_nav'); ?>
<?php self::load('common/footer'); ?>
