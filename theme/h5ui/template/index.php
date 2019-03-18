<?php component('/components/common/header?title=安米社区-专注于手机网站建设' ); ?>
<?php component('/components/common/header_menu_nav?title=安米社区' ); ?>
<div class="img_bar">
    <a href="http://bbs.ianmi.com/forum/view?id=9151"><img src="/static/images/ad_bar.jpg" alt=""></a>
</div>
<?php $list = source('Model/Forum/getList'); ?>
<div class="list img_list">
<?php foreach($list as $item) { ?>
<?php component('/components/forum/list_img_text', ['item' => $item]); ?>
<?php } ?>
</div>

<?php component('/components/common/footer_nav', ['index' => 0]); ?>
<?php self::load('/common/footer'); ?>