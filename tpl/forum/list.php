<?php self::load('common/header',['title' => '论坛中心']); ?>
<div class="header-height"></div>
<div class="header">
    <span class="back"></span>
    <a href="/" class="left-word">首页</a>

    <span class="header-right">
        <a class="icon-svg user" href="/User/index"></a>
    </span>
</div>

<div class="bbas_action">
    <div class="flex-box">
        <img class="bbs_photo" src="https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=2779070586,3489688379&fm=58" alt="">
        <div>
            <div class="bbas_action_title"><?=$class_info['title']?></div>
            <div class="create_time">总数：<?=$list->toArray()['total']?></div>
        </div>
    </div>
    <div>
        <a class="btn" href="/forum/add_page?class_id=<?=$class_info['id']?>" style="display:inline-block;">发帖</a>
    </div>
</div>

<div class="bbs_order border-b">
    <div class="bbs_order_title">话题</div>
    <div>最近回复</div>
</div>
<?php if ($list->toArray()['total'] == 0) { ?>
    <div class="bbs_empty">这个地方空空如也！</div>
<?php } else { ?>
    <div class="list bbs_list">
<?php foreach($list as $item) { ?>
    <?php component('/components/forum/list_item', ['item' => $item]); ?>

<?php } ?>
</div>

<!-- 分页 -->
<?=$page?>
</div>
<?php } ?>
<?php self::load('common/footer'); ?>
