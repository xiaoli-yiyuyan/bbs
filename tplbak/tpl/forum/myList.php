<?php self::load('common/header',['title' => '论坛中心']); ?>
<div class="header">
    <span class="back"></span>
    <a href="/user" class="left-word">个人中心</a>

    <span class="header-right">
        <a class="icon-svg user" href="/User/index"></a>
    </span>
</div>

<div class="bbas_action">
    <div class="flex-box">
        <img class="bbs_photo" src="<?=$user['photo']?>" alt="">
        <div>
            <div class="bbas_action_title">我的所有发帖</div>
            <div class="create_time">总数：<?=$page['count']?></div>
        </div>
    </div>
    <div>
    </div>
</div>

<div class="bbs_order border-b">
    <div class="bbs_order_title">话题</div>
    <div>最近回复</div>
</div>
<?php if (empty($list)) { ?>
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
<div class="bbs_page">
    <div class="bbs_page_action">
        <div class="bbs_page_jump_box">
            <a class="bbs_page_jump" href="<?=$page['href'][0]?>">首页</a>
            <a class="bbs_page_jump" href="<?=$page['href'][1]?>">上页</a>
            <input type="text" class="input bbs_page_jump" placeholder="<?=$page['page']?>/<?=$page['page_count']?>">
            <a class="bbs_page_jump" href="<?=$page['href'][2]?>">下页</a>
            <a class="bbs_page_jump" href="<?=$page['href'][3]?>">尾页</a>
        </div>
    </div>
    <!-- <div class="bbs_page_jump flex-box">
        <div>当前第1页，共2000页</div>
        <div>
            <div class="input-search">
                <input type="text" class="input" placeholder="页数">
                <span class="btn btn-fill">跳页</span>
            </div>
        </div>
    </div> -->
</div>
</div>
<?php } ?>
<?php self::load('common/footer'); ?>
