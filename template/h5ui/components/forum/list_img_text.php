<div class="list-img">
    <a class="list-t-item" href="/forum/view?id=<?=$item['id']?>">
        <div class="title"><?=$item['title']?></div>
        <div class="text-image flex-box">
            <div class="flex context"><?=$item['mini_context']?></div>
            <?php if (!empty($item['img_list'])) { ?>
                <img class="image" src="<?=$item['img_list'][0]['path']?>" alt="加载中...">
            <?php } ?>
            </div>
            <div class="user flex-box">
            <img class="photo" src="<?=$item['author']['photo']?>" alt="">
            <div class="flex"><?=$item['author']['nickname']?> · <?=$item['reply_count']?> 评论</div>
            <div class="create_time"><?=friendlyDateFormat($item['create_time'])?></div>
        </div>
            </a>
    <div class="hr"></div>
</div>