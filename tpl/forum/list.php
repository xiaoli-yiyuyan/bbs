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
<?php foreach ($list as $item) { ?>
    <div class="list-group">
        <a href="/forum/view/?id=<?=$item['id']?>" class="list-item">
            <?=$item['title']?>
        </a>
        <div class="bbs_info border-t">
            <div class="bbs_user"><img class="bbs_user_photo" src="<?=$item['photo']?>" alt=""> <?=$item['nickname']?></div>
            <div class="create_time">
                <span class="bbs_replay_num"><?=$item['reply_count']?>回/<?=$item['read_count']?>逛</span>
                <?=$item['create_time']?>
            </div>
        </div>
    </div>
<?php } ?>
<!-- 分页 -->
<?=$page?>
</div>
<?php } ?>
<?php self::load('common/footer'); ?>
