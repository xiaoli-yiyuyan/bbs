<?php self::load('common/header', ['title' => '安米小说']); ?>
<?php $list = forum([ 'id' => 1, 'order' => 'new', 'pagesize' => 10 ]); ?>
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
</div>
<?php } ?>
<?php self::load('common/footer',['title' => '网页标题']); ?>
