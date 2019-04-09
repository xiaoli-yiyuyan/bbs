<?php component('/components/common/header', ['title' => '我的帖子']); ?>
<?php component('/components/common/header_nav', ['back_url' => '/user/index', 'title' => '个人中心']); ?>
<?php $list = source('Model/ForumReply/replyList', ['reply_userid' => $user['id']]); ?>

<?php component('/components/forum/reply_list', ['list' => $list]); ?>
<!-- 分页 -->
<?=$list->render()?>
</div>
<?php component('/components/common/footer'); ?>