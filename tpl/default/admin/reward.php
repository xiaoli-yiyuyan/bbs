<?php self::load('common/header',['title' => '后台管理-奖励设置']); ?>
<?php self::load('admin/header_nav'); ?>
<div class="content">
    <div class="namespace">
        <a href="/admin/user/">用户管理</a> \ <div class="nav_title">奖励设置</div>
    </div>

    <form id="add" class="form-group" method="post" action="/admin/save_setting">
        
        <div class="item-line item-lg">
            <div class="item-title">每日登陆</div>
            <div class="item-input"><input type="text" name="login_reward" class="input input-lg" placeholder="每日登录奖励" value="<?=$login_reward?>"></div>
        </div>

        <div class="item-line item-lg">
            <div class="item-title">发帖</div>
            <div class="item-input"><input type="text" name="forum_reward" class="input input-lg" placeholder="发帖奖励" value="<?=$forum_reward?>"></div>
        </div>

        <div class="item-line item-lg">
            <div class="item-title">评论</div>
            <div class="item-input"><input type="text" name="reply_reward" class="input input-lg" placeholder="评论奖励" value="<?=$reply_reward?>"></div>
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
