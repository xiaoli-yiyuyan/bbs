<?php self::load('Common/header',['title' => '操作成功']); ?>
<div class="header">
    <span class="logo"></span>
    <div class="head_center">操作成功</div>
    <div></div>
</div>
<div class="page-msg-box">
    <i class="icon-svg svg-true"></i>
    <?=$msg?>
</div>
<script>
    setTimeout(function(){
        <?php if (empty($url)) { ?>
            history.go(-1);
        <?php } else { ?>
            location.href="<?=$url?>";
        <?php } ?>
    }, 1000);
</script>
<?php self::load('Common/footer'); ?>
