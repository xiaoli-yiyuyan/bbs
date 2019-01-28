<?php self::load('common/header',['title' => '搜索结果']); ?>
<?php self::load('common/header_nav',['title' => '搜索结果', 'back_url' => '/','message_count' => 0]); ?>

<?php if ($list->total() == 0) { ?>
    <div class="bbs_empty">换个关键词试试吧，这个地方空空如也！</div>
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
<?php self::load('common/footer'); ?>
