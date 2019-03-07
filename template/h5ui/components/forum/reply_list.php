<?php if (empty($list['page']['count'])) { ?>
    <div class="bbs_empty replay_empty">暂无评论！</div>
<?php } else { ?>
<div class="list bbs_list">
    <?php foreach ($list['data'] as $item) { ?>
    <?php $this->load('/components/forum/reply_item', ['item' => $item]); ?>
    <?php } ?>

    <?php $this->load('/components/common/page_jump', ['page' => $list['page']]); ?>
</div>
<?php } ?>
