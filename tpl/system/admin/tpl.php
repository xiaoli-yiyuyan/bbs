<?php self::load('common/header',['title' => '后台管理-奖励设置']); ?>
<?php self::load('admin/header_nav'); ?>
<div class="content">
    <div class="namespace">
        <a href="/admin/user/">系统设置</a> \ <div class="nav_title">主题管理</div>
    </div>

    <form id="add" class="form-group" method="post" action="/admin/save_setting">
        
    <div class="item-line item-lg">
            <div class="item-title">主题标识</div>
            <div class="item-input"><input type="text" name="theme" class="input input-lg" placeholder="主题标识" value="<?=$theme?>"></div>
        </div>

        <div class="item-line item-lg">
            <div class="item-title">组件标识</div>
            <div class="item-input"><input type="text" name="component" class="input input-lg" placeholder="组件标识" value="<?=$component?>"></div>
        </div>

        <button class="btn btn-fill btn-lg btn-block">保存</button>
    </form>
</div>
<div class="footer_nav">
    <div>安米程序 v<?=$version?> (2018新鲜出炉)</div>
    <div>本程序免费开源 官网地址 <a class="ianmi_link" href="http://ianmi.com">http://ianmi.com</a></div>
</div>

<script>
    $('#add').submit(function() {
        var $this = $(this)
        $.post($this.attr('action'), $this.serialize()).then(function(data) {
            data = JSON.parse(data);
            if (data.err) {
                $.alert(data.msg);
            } else {
                $.alert('保存成功');
                // location.href = '/admin/user';
            }
        });
        return false;
    });
</script>
<?php self::load('common/footer'); ?>
