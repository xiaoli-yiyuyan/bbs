<?php self::load('Common/header',['title' => '操作成功']); ?>
<?=$msg?>
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
