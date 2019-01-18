<?php self::load('common/header',['title' => '错误提示']); ?>
<div class="header">
    <span class="logo"></span>
    <div class="head_center">错误提示</div>
    <div></div>
</div>

<div class="page-msg-box">
    <i class="icon-svg svg-false"></i>
    <div class="page-msg-box false"><?=$msg?></div>
</div>
<script>
    setTimeout(function(){
        history.go(-1);
    }, 2000);
</script>
<?php self::load('common/footer'); ?>
