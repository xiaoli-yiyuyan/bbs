<?php component('common/header?title=操作成功'); ?>
<?php $list = source('app/common/Ubb/getTips?msg=123456&type=1'); ?>

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
<?php component('common/footer'); ?>
