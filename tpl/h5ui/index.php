<?php component('/components/common/header?title=安米社区-专注于手机网站建设' ); ?>
<?php component('/components/common/left_menu'); ?>

<header class="header-bar">
    <div class="header-item left-menu">
        <i class="icon-svg svg-menu"></i>
    </div>
    
    <div class="header-title">安米社区</div>
    
    <div class="header-item">
        <i class="icon-svg svg-mail"></i>
    </div>
</header>
<?php $list = source('Model/Forum/getList'); ?>
<div class="list img_list">
<?php foreach($list as $item) { ?>
<?php component('/components/forum/list_img_text', ['item' => $item]); ?>
<?php } ?>
</div>

<?php component('/components/common/footer_nav', ['index' => 0]); ?>
<?php self::load('/common/footer'); ?>