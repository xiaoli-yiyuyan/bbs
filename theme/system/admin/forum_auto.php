<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>
<div class="content">
    <div class="namespace">
        <a href="/admin/forum/">待审核帖子</a> \
    </div>
    
    <div class="page_nav">
        <!-- <a href="/admin/forum_mark/add">添加标签</a> -->
        <a href="/admin/forum/auto">审核类表</a>
        <a href="/admin/forum/auto?status=2">拒绝列表</a>
    </div>
    <?php if ($list->isEmpty()) { ?>
    <div class="bbs_empty">这个地方空空如也！</div>
    <?php } else { ?>
    <div class="list admin-list">
        <div class="list-group">
            <?php foreach ($list as $key => $item) { ?>
            <div class="list-item border-b">
                ID:<?=$item['id']?>) <a href="/forum/view?id=<?=$item['id']?>"><?=!empty($item['title']) ? $item['title'] : $item['mini_context'] ?></a>
                <div class="action-box border-t">
                    <a class="btn btn-sm btn_forum_look" href="/forum/view?id=<?=$item['id']?>">查看</a>
                    <a class="btn btn-sm btn_forum_back" data-href="/admin/forum/pass?id=<?=$item['id']?>&status=0">通过</a>
                    <?php if ($item['status'] == 1) { ?>
                        <a class="btn btn-sm btn_forum_remove" data-href="/admin/forum/pass?id=<?=$item['id']?>&status=2">拒绝</a>
                    <?php } else { ?>
                        <a class="btn btn-disabled btn-sm btn_forum_remove">拒绝</a>
                    <?php } ?>
                </div>
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
        $.confirm('确定通过？', {
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
        $.confirm('确定拒绝？', {
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
