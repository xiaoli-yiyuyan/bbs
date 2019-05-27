<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>

<div class="content">

    <div class="namespace">
        <a href="#">内容</a> \ <div class="nav_title">标签管理</div>
    </div>

    <div class="page_nav">
        <!-- <a href="/admin/forum_mark/add">添加标签</a> -->
        <a href="/admin/forum_mark/index">标签列表</a>
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
                <a data-link="<?=href('/admin/forum_mark/remove?id=' . $value['id'])?>" class="btn_delete btn btn-fill btn-danger btn-sm">删除</a>
                <!-- <a href="/admin/" class="btn-margin-left btn btn-fill btn-sm">编辑</a> -->
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<?=$list->render()?>
<script>

$('.btn_delete').click(function() {
    var link = $(this).data('link');
    $.confirm('确定删除？<br>删除后无法恢复</b>！', {
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
