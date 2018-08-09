<?php $this->load('components/common/user_header',['title' => '修改资料']); ?>
<?php $this->load('/components/common/header_nav', ['back_url' => '/user/index', 'title' => '个人中心']); ?>

<form id="add" class="box-padding" action="/user/ajax_edit_info" method="post">

<div class="item-line item-lg">
    <div class="item-title">昵称</div>
    <div class="item-input"><input type="text" class="input input-line input-lg" name="nickname" placeholder="昵称" value="<?=$userinfo['nickname']?>"></div>
</div>

<div class="item-line item-lg">
    <div class="item-title">小尾巴</div>
    <div class="item-input"><textarea name="explain" class="input input-line input-lg" placeholder="小尾巴"><?=$userinfo['explain']?></textarea></div>
</div>

<p><button class="btn btn-fill btn-lg" style="width: 100%;">修改</button></p>
</form>
<script>
        $('#add').submit(function() {
        var $this = $(this)
        $.post($this.attr('action'), $this.serialize()).then(function(data) {
            data = JSON.parse(data);
            if (data.err) {
                $.alert(data.msg);
            } else {
                location.href = '/user/index';
            }
        });
        return false;
    });
</script>
<?php $this->load('components/common/footer'); ?>