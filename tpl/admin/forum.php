<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>
<div class="content">
    <div class="namespace">
        <a href="/admin/forum/">帖子回收站</a> \
    </div>
    <?php if ($list->isEmpty()) { ?>
    <div class="bbs_empty">这个地方空空如也！</div>
    <?php } else { ?>
    <div class="list">
        <div class="list-group list-arrow">
            <?php foreach ($list as $key => $item) { ?>
            <div class="list-item border-b">
                ID:<?=$item['id']?>) <a href="/forum/view?id=<?=$item['id']?>"><?=$item['title']?></a>
                [<a class="btn_forum_back" data-href="/admin/back_forum?id=<?=$item['id']?>">恢复</a>
                <a class="btn_forum_remove" data-href="/admin/remove_forum?id=<?=$item['id']?>">删除</a>]
            </div>
            <?php } ?>
        </div>
        <?=$list->render()?>
    </div>
    <?php } ?>
</div>
<div class="footer_nav">
    <div>安米程序 v<?=$version?> (2018新鲜出炉)</div>
    <div>本程序免费开源 官网地址 <a class="ianmi_link" href="http://ianmi.com">http://ianmi.com</a></div>
</div>
<script>
    $('.btn_forum_back').click(function() {
        var link = $(this).data('href');
        $.confirm('确定恢复显示？', {
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
    
    $('.btn_forum_remove').click(function() {
        var link = $(this).data('href');
        $.confirm('确定删除此文章？<br>删除后无法恢复</b>！', {
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
