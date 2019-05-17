<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>

<div class="content">

    <div class="namespace">
        <a href="/admin/user/">系统设置</a> \ <div class="nav_title">标签管理</div>
    </div>

    <div class="page_nav">
        <!-- <a href="/admin/forum_mark/add">添加标签</a> -->
        <a href="/admin/forum_mark/pass_list">审核列表</a>
    </div>
    <?php if (empty($list)) { ?>
        <div class="empty">还没有任何标签！</div>
    <?php } ?>
    <div class="list tree">
    <?php foreach ($list as $key => $value) { ?>
        <div class="list-group list-arrow">
            <div class="list-item">
                <i class="icon-svg svg-mark"></i>
                <div class="namespace_link"><?=$value['title']?></div>
                <a data-link="/admin/remove_code?id=<?=$value['id']?>" class="btn_delete btn btn-fill btn-danger btn-sm">删除</a>
                <a href="/admin/edit_code?id=<?=$value['id']?>" class="btn-margin-left btn btn-fill btn-sm">编辑</a>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<?=$list->render()?>
<?php self::load('common/footer'); ?>
