<?php self::load('common/header',['title' => '后台管理-奖励设置']); ?>
<?php self::load('admin/header_nav'); ?>
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
        <a href="/admin/tpl">主题库</a>
        <a href="/admin/my_tpl">我的主题</a>
        <!-- <a href="/admin/add_page?type=1">添加页面</a> -->
    </div>
    <div class="list">
        <div class="list-group">
            <div class="list-item">
                <div class="tpl_title">白色简约（安米官方主题）v1.0.0</div>
                <div class="btn_box">
                    <button class="btn btn-sm">修改</button>
                    <button class="btn btn-sm">编辑</button>
                </div>
            </div>
            <div class="list-item">
                <div class="tpl_title">深色简约（安米官方主题）v1.0.0</div>
                <div>
                    <button class="btn btn-sm">修改</button>
                    <button class="btn btn-sm">使用</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php self::load('common/footer'); ?>
