<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>
<div class="content">
    <div class="namespace">
        <a href="/admin/user/">会员管理</a> \
    </div>
    <!-- <div class="page_nav">
        <a href="/admin/add_column">添加会员</a>
    </div> -->
    <!-- <div class="page_nav">
        <div class="input-search">
            <input type="text" class="input" name="word" placeholder="ID/昵称/账号">
            <span class="btn btn-fill btn_user_search"><i class="icon-search"></i></span>
        </div>
    </div> -->
    <?php if (empty($list)) { ?>
    <div class="bbs_empty">这个地方空空如也！</div>
    <?php } else { ?>
    <div class="list admin-list">
        <div class="list-group">
            <?php foreach ($list as $key => $item) { ?>
            <div class="list-item border-b">
                <div class="admin-user-box">
                    <img class="admin-user-photo" src="<?=$item['photo']?>" alt="">
                    <div class="admin-user-info">
                        <div>
                            <?=$item['nickname']?>(ID:<?=$item['id']?>))
                        </div>
                        <div>
                            VIP:<?=$item['vip_level']?> 金币:<?=$item['coin']?> 点券:<?=$item['money']?>
                        </div>
                    </div>
                </div>
                <div class="action-box border-t">
                    <a class="btn btn-sm" href="/admin/edit_user?id=<?=$item['id']?>">修改</a>
                    <a class="btn btn-sm btn_user_remove" data-href="/admin/remove_user?id=<?=$item['id']?>">删除</a>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="bbs_page">
        </div>
    </div>
    
    <?php } ?>
</div>
<?=$list->render();?>

<?php self::load('common/footer_nav'); ?>
<script>
    $('.btn_user_remove').click(function() {
        var link = $(this).data('href');
        $.confirm('确定删除此用户？<br>删除后无法恢复</b>！', {
            yes: function() {
                $.getJSON(link).then(function(data) {
                    if (data.err) {
                        $.alert(data.err);
                    } else {
                        location.reload();
                    }
                });
            }
        });
    });
</script>
<?php self::load('common/footer'); ?>
