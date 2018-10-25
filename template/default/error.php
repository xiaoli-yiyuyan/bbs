<?php $this->load('components/common/header',['title' => $title]); ?>
<?php $this->load('/components/common/header_nav', ['back_url' => '/index', 'title' => '首页']); ?>

<div class="page-msg-box">
    <i class="icon-svg svg-false"></i>
    <div class="page-msg-box false"><?=$msg?></div>
</div>
<script>
    setTimeout(function(){
        history.go(-1);
    }, 2000);
</script>
<?php $this->load('components/common/footer'); ?>
