<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>

<div class="content">

    <div class="namespace">
        <a href="/admin/user/">系统设置</a> \ <div class="nav_title">代码自定义</div>
    </div>

    <div class="page_nav">
        <a href="/admin/add_code">添加自定义</a>
        <!-- <a href="/admin/add_page?type=1">添加页面</a> -->
    </div>
    <?php if (empty($list)) { ?>
        <div class="empty">请添加你的代码</div>
    <?php } ?>
    <div class="list tree">
    <?php foreach ($list as $key => $value) { ?>
        <div class="list-group list-arrow">
            <div class="list-item">
                <i class="icon-svg svg-code"></i>
                <div class="namespace_link"><?=$value['title']?>[<span class="code_name"><?=$value['name']?></span>]</div>
                <a data-link="/admin/remove_code?id=<?=$value['id']?>" class="btn_delete btn btn-fill btn-danger btn-sm">删除</a>
                <a href="/admin/edit_code?id=<?=$value['id']?>" class="btn-margin-left btn btn-fill btn-sm">编辑</a>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<?=$page?>

<script>
$('.btn_delete').click(function() {
    var link = $(this).data('link');
    $.confirm('确定删除此自定义代码？<br>删除后无法恢复</b>！', {
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
