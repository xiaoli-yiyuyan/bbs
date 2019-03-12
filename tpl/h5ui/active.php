<?php component('/components/common/header?title=安米社区-专注于手机网站建设' ); ?>
<?php component('/components/common/header_menu_nav?title=关注动态' ); ?>

<?php
    $userinfo = source('app/common/CommonPublic/getUserInfo');
    $care_id = source('Model/Friend/getAllCareId', ['user_id' => $userinfo['id']]);
    $list = source('Model/Forum/getList', ['user_id' => $care_id]);
?>
<div class="list img_list">
<?php if ($list->isEmpty()) { ?>
    <div class="empty_word">还没有关注其他人哦！</div>
<?php } ?>
<?php foreach($list as $item) { ?>
<?php component('/components/forum/list_img_text', ['item' => $item]); ?>
<?php } ?>
</div>

<?php component('/components/common/footer_nav', ['index' => 3]); ?>
<?php self::load('/common/footer'); ?>