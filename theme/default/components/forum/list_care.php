<div class="list-care">
    <div class="user">
        <img class="photo" src="<?=$item['author']['photo']?>" alt="">
        <div class="info">
            <div class="nickname"><?=$item['author']['nickname']?> <span class="level">Lv.<?=$item['author']['lv']['level']?></span></div>
            <div class="mark">
                <span><?=friendlyDateFormat($item['create_time'])?></span>
                <span><?=$item->class_info['title']?></span>
            </div>
        </div>
    </div>
    <a class="text" href="/forum/view?id=<?=$item['id']?>">
        <div class="title">
        <?php if($item['is_top'] == 1){?><span class='forum_top'>顶</span><?php }?>
        <?php if($item['is_cream'] == 1){?><span class='forum_cream'>精</span><?php }?>
        <!-- <?php if($item['img_data'] != ''){?><span class='forum_img'>图</span><?php }?> -->
        <?php if($item['file_data'] != ''){?><span class='forum_file'>附</span><?php }?>
        <?=$item['title']?></div>
        <div class="context"><?=$item['mini_context']?></div>
        <?php if (!empty($item['img_list'])) { ?>
            <div class="images">
                <?php for ($i = 0; $i < min(3, count($item['img_list'])); $i ++) { ?>
                <img src="<?=$item['img_list'][$i]['path']?>" alt="加载中...">
                <?php } ?>
            </div>
        <?php } ?>
    </a>
    <?php if (count($item->markBody)) { ?>
    <div class="_list_mark">
        <?php foreach ($item->markBody as $_item) { ?>
        <div class="_item">
            <span class="_j">#</span>
            <a href="/forum/search?mark_id=<?=$_item['id']?>" class="_title"><?=$_item['title']?></a>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
    <div class="count">
        <div class="reply">
            <i class="icon-svg svg-bbs_reply"></i>
            <?=$item['reply_count']?>
        </div>
        <div class="read">
            <i class="icon-svg svg-look"></i>
            <?=$item['read_count']?>
        </div>
    </div>
    <div class="hr"></div>
</div>