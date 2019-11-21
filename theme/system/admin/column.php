<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>
<div class="content">
    <div class="namespace">
        <a href="/admin/column/">栏目管理</a> \
    </div>
    <div class="page_nav">
        <a href="/admin/add_column">添加栏目</a>
    </div>
    <?php if ($list->isEmpty()) { ?>
    <div class="bbs_empty">这个地方空空如也！</div>
    <?php } else { ?>
    <div class="list">
        <div class="list-group list-arrow">
            <?php foreach ($list as $key => $item) { ?>
            <div class="list-item ellipsis border-b">
                ID:<?=$item['id']?>) <?=$item['title']?>
                [<a href="/admin/edit_column?id=<?=$item['id']?>">修改</a>
                <a class="btn_column_remove" data-href="/admin/remove_column?id=<?=$item['id']?>">删除</a>]
            </div>
            <?php } ?>
        </div>
        <?=$list->render()?>
    </div>
    <?php } ?>
</div>
<?php self::load('common/footer_nav'); ?>
<script>
    $('.btn_column_remove').click(function() {
        var link = $(this).data('href');
        $.confirm('确定删除此栏目？<br>删除后无法恢复</b>！', {
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
</script>
<?php self::load('common/footer'); ?>
