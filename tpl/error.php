<?php self::load('Common/header',['title' => '错误提示']); ?>
<?=$msg?>
<script>
    setTimeout(function(){
        history.go(-1);
    }, 2000);
</script>
<?php self::load('Common/footer'); ?>
