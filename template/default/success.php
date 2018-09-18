<?php $this->load('components/common/header',['title' => $title]); ?>
<?php $this->load('/components/common/header_nav', ['back_url' => '/index', 'title' => '首页']); ?>

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
<?php $this->load('components/common/footer'); ?>
