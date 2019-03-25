<?php self::load('common/header',['title' => '后台管理-奖励设置']); ?>
<?php self::load('admin/header_nav'); ?>
<style>
    .list-item {
        border-bottom: 1px solid #eee;
    }
    .newName{   
         margin: 0 10px;
        padding: 0 5px;
        line-height: 25px;
        display:none;
    }
    .change-btn-name{display:none}
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
                    <div class="tpl_title"><input value="<?=$item['title']?>" class="newName" name="<?=$item['id']?>"><span class="title-name"><?=$item['title']?></span> <?=$item['version']?> (<?=$item['name']?>)</div>
                    <div class="btn_box">
                        <div class="change-btn-name">
                            <button class="btn btn-sm btn-change-yes">确认</button>
                            <button class="btn btn-sm btn-change-none">取消</button>
                        </div>
                        <button class="btn btn-sm btn-change-name">修改</button>
                        <?php if($item['name'] == $setting['theme']) {?>
                            <!-- <button class="btn btn-sm">编辑</button> -->
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
    //主题切换
    $(".btn-use").click(function(){
        var id = parseInt($(this).attr('name'));
        if(isNaN(id) || id < 1){
            $.alert('参数错误');
            return false;
        }
        
        $.confirm('是否要使用该主题', {
            yes: function() {
                $.post('/admin/theme_use', {id : id},function(res){
                    if(res.err){
                        $.alert(res.msg);
                        return false;
                    }
                    location.href='';
                })
            },
            no: function() {
            }
        });
    })
    
    //修改名称
    $('.btn-change-name').click(function(){
        var parent = $(this).parent().parent();
        parent.find('.title-name').hide();
        parent.find('.newName').show();
        $(this).hide();
        parent.find('.change-btn-name').show();
    })
    //取消修改
    $('.btn-change-none').click(function(){
        var parent = $(this).parent().parent().parent();
        parent.find('.newName').hide();
        parent.find('.title-name').show();
        parent.find('.change-btn-name').hide();
        parent.find('.btn-change-name').show();
    })
    //确认修改
    $('.btn-change-yes').click(function(){
        var parent = $(this).parent().parent().parent();
        var newName = parent.find('.newName');
        var title = newName.val();
        var id = newName.attr('name');
        $.post('/admin/tpl_title',{title: title, id: id}, function(res){
            if(res.err){
                        $.alert(res.msg);
                        return false;
                    }
                    location.href='';
        }, 'json')
    })
</script>
<?php self::load('common/footer'); ?>
