<?php component('/components/common/header', ['title' => '我的帖子']); ?>
<?php component('/components/common/header_nav', ['back_url' => '/user/index', 'title' => '个人中心']); ?>

<?php $list = source('Model/Forum/getList', ['user_id' => $user['id']]); ?>

<?php if ($list->total() == 0) { ?>
    <div class="bbs_empty">这个地方空空如也！</div>
<?php } else { ?>
    <div class="list list-img">
<?php foreach($list as $item) { ?>
    <?php component('/components/forum/list_img_text', ['item' => $item]); ?>
<?php } ?>
</div>

<!-- 分页 -->
<?=$list->render()?>
</div>
<?php } ?>
<?php component('/components/common/footer'); ?>