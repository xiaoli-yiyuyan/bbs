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
    <div class="list list-img">
<?php foreach($list as $item) { ?>
<div class="list-group">
    <a class="list-t-item" href="/forum/view?id=<?=$item['id']?>">
        <div class="title"><?=$item['title']?></div>
        <div class="text-image flex-box">
            <div class="flex context"><?=$item['mini_context']?></div>
            <?php if (!empty($item['img_list'])) { ?>
                <img class="image" src="<?=$item['img_list'][0]['path']?>" alt="加载中...">
            <?php } ?>
            </div>
            <div class="user flex-box">
            <div class="flex"><?=$item['author']['nickname']?> · <?=$item['reply_count']?> 评论</div>
            <div class="more"></div>
        </div>
            </a>
    <div class="hr"></div>
</div>
<?php } ?>
</div>

<!-- 分页 -->
<?=$page?>
</div>
<?php } ?>
<?php self::load('common/footer'); ?>
