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
    <?php if (empty($list['data'])) { ?>
    <div class="bbs_empty">这个地方空空如也！</div>
    <?php } else { ?>
    <div class="list">
        <div class="list-group list-arrow">
            <?php foreach ($list['data'] as $key => $item) { ?>
            <div class="list-item list-item-image-text border-b">
                <div class="list-item-image">
                    <img src="<?=$item['photo']?>" alt="">
                </div>
                <div class="list-item-text">
                    <div>
                        <?=$item['nickname']?>(ID:<?=$item['id']?>))
                    </div>
                    <div>
                        VIP:<?=$item['vip_level']?> 金币:<?=$item['coin']?> 点券:<?=$item['money']?>
                    </div>
                    <div>
                        [<a href="/admin/edit_user?id=<?=$item['id']?>">修改</a> <a class="btn_user_remove" data-href="/admin/remove_user?id=<?=$item['id']?>">删除</a>]
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="bbs_page">
            <div class="bbs_page_action">
                <div class="bbs_page_jump_box">
                    <a class="bbs_page_jump" href="<?=$list['page']['href'][0]?>">首页</a>
                    <a class="bbs_page_jump" href="<?=$list['page']['href'][1]?>">上页</a>
                    <input type="text" class="input bbs_page_jump" placeholder="<?=$list['page']['page']?>/<?=$list['page']['page_count']?>">
                    <a class="bbs_page_jump" href="<?=$list['page']['href'][2]?>">下页</a>
                    <a class="bbs_page_jump" href="<?=$list['page']['href'][3]?>">尾页</a>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<div class="footer_nav">
    <div>安米程序 v<?=$version?> (2018新鲜出炉)</div>
    <div>本程序免费开源 官网地址 <a class="ianmi_link" href="http://ianmi.com">http://ianmi.com</a></div>
</div>
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
