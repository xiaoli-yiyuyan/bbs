<?php self::load('common/header',['title' => '后台管理-奖励设置']); ?>
<?php self::load('admin/header_nav'); ?>
<style>
    .list-item {
        border-bottom: 1px solid #eee;
    }
</style>
<div class="content">
    <div class="namespace">
        <a href="/admin/user/">系统设置</a> \ <div class="nav_title">主题管理</div>
    </div>
    <div class="page_nav">
        <a href="/admin/tpl">主题库</a>
        <a href="/admin/my_tpl">我的主题</a>
        <!-- <a href="/admin/add_page?type=1">添加页面</a> -->
    </div>
    <div class="list">
        <div class="list-group">
            <?php foreach ($list as $key => $item) {?>
                <div class="list-item">
                    <div class="tpl_title"><?=$item['title']?> <?=$item['version']?> (<?=$item['name']?>)</div>
                    <div class="btn_box">
                        <button class="btn btn-sm">修改</button>
                        <?php if($item['name'] == $setting['theme']) {?>
                            <button class="btn btn-sm">编辑</button>
                        <?php }else{?>
                            <button class="btn btn-sm btn-use" name="<?=$item['id']?>">使用</button>
                        <?php }?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $(".btn-use").click(function(){
        var id = parseInt($(this).attr('name'));
        if(isNaN(id) || id < 1){
            $.alert('参数错误');
            return false;
        }
        
        $.confirm('是否要使用该主题', {
            yes: function() {
                $.post('/admin/theme_use', {id : id},function(res){
                    $.alert(res.msg);
                })
            },
            no: function() {
                $.alert('你点击了取消');
            }
        });
    })
</script>
<?php self::load('common/footer'); ?>
