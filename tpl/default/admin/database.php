<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>
<div class="content">
    <div class="namespace">
        <a href="/admin/column/">备份列表</a> \
    </div>
    <div class="page_nav">
        <a href="/admin/database_backup">马上备份</a>
    </div>
    <?php if (empty($list['file'])) { ?>
        <div class="empty">暂无备份</div>
    <?php } ?>

    <div class="list tree">
    <?php foreach ($list['file'] as $key => $value) { ?>
        <div class="list-group list-arrow">
            <div class="list-item">
                <div class="namespace_link"><?=$value?></div>
                <a data-href="/admin/database_remove?name=<?=$value?>" class="btn_database_remove btn btn-fill btn-danger btn-sm">删除</a>
                <a class="btn-margin-left btn btn-fill btn-sm btn_database_restore" data-href="/admin/database_restore?name=<?=$value?>">还原</a>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<div class="footer_nav">
    <div>安米程序 v<?=$version?> (2018新鲜出炉)</div>
    <div>本程序免费开源 官网地址 <a class="ianmi_link" href="http://ianmi.com">http://ianmi.com</a></div>
</div>
<script>
    $('.btn_database_remove').click(function() {
        var link = $(this).data('href');
        $.confirm('确定删除此备份？<br>删除后无法恢复</b>！', {
            yes: function() {
                $.getJSON(link).then(function(data) {
                    if (data.err) {
                        $.alert(data.msg);
                    } else {
                        location.reload();
                    }
                });
            }
        });
    });
    $('.btn_database_restore').click(function() {
        var link = $(this).data('href');
        $.confirm('确定恢复此备份？！', {
            yes: function() {
                $.getJSON(link).then(function(data) {
                    if (data.err) {
                        $.alert(data.msg);
                    } else {
                        $.alert('还原成功');
                    }
                });
            }
        });
    });
</script>
<?php self::load('common/footer'); ?>
