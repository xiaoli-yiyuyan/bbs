<?php self::load('common/header',['title' => '后台管理-系统设置']); ?>
<?php self::load('admin/header_nav'); ?>
<div class = "content">
    <div class="namespace">
        <a href="/admin/column/">系统管理</a> \ <div class="nav_title">系统设置</div>
    </div>
    <form id="add" class = "form-group" action="/admin/save_system" method="post">
        <div class="item-line item-lg">
            <div class="item-title">开启注册</div>
            <div class="item-input">
                <input class="input-radio" name="is_register" value="1" type="radio" <?php if(isset($is_register) && $is_register == 1){?> checked <?php }?>>开启
                <input class="input-radio" name="is_register" value="0" type="radio" <?php if(isset($is_register) && !$is_register){?> checked <?php }?>>关闭
            </div>
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