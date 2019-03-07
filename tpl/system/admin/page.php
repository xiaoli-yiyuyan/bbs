<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>

<div class="content">
    <div class="namespace"><a href="/admin/page/">根分类</a> /
    <?php
        $namespace_path = '/';
        foreach ($namespace_index as $item) {
            $namespace_path .= $item . '/';
    ?>
        <a href="/admin/page/?namespace=<?=$namespace_path?>"><?=$item?></a> /
    <?php } ?>
    </div>
    <div class="page_nav">
        <a href="/admin/add_namespace?namespace=<?=$namespace_parent?>">添加分类</a>
        <a href="/admin/add_component/#/?namespace=<?=$namespace_parent?>">添加组件</a>
        <!-- <a href="/admin/add_page?type=1">添加页面</a> -->
    </div>
    <?php if (empty($namespace) && empty($component)) { ?>
        <div class="empty">请添加分类或组件</div>
    <?php } ?>
    <div class="list tree">
    <?php foreach ($namespace as $key => $value) { ?>
        <div class="list-group list-arrow">
            <div class="list-item">
                <i class="icon-svg svg-namespace"></i>
                <a class="namespace_link" href="/admin/page/?namespace=<?=$namespace_parent . $key . '/'?>"><?=$key?></a>
                <span data-link="/admin/namespace_remove?namespace=<?=$namespace_parent . $key . '/'?>" class="btn btn-fill btn-sm btn-danger btn_delete">删除</span>
            </div>
        </div>
    <?php } ?>
    <?php foreach ($component as $key => $value) { ?>
        <div class="list-group list-arrow">
            <div class="list-item">
                <i class="icon-svg svg-component"></i>
                <div class="namespace_link"><?=$key?></div>
                <a data-link="/admin/component_remove?namespace=<?=$namespace_parent . '/'?>&amp;component=<?=$key?>" class="btn_component_remove btn btn-fill btn-danger btn-sm">删除</a>
                <a class="btn-margin-left btn btn-fill btn-sm" href="/admin/add_component/#/?namespace=<?=$namespace_parent . '/'?>&amp;component=<?=$key?>">编辑</a>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<script>
$('.btn_delete').click(function() {
    var link = $(this).data('link');
    $.confirm('确定删除此命名空间？<br>删除后其下级所有组件和命名空间将被清空且<b>无法恢复</b>！', {
        yes: function() {
            location.href = link;
        }
    });
});
$('.btn_component_remove').click(function() {
    var link = $(this).data('link');
    $.confirm('确定删除此组件？<br>删除后无法恢复</b>！', {
        yes: function() {
            location.href = link;
        }
    });
});
</script>
<div class="footer_nav">
    <div>安米程序 v<?=$version?> (2018新鲜出炉)</div>
    <div>本程序免费开源 官网地址 <a class="ianmi_link" href="http://ianmi.com">http://ianmi.com</a></div>
</div>
<?php self::load('common/footer'); ?>
