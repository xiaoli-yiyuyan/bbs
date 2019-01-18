<?php self::load('common/header',['title' => $mark_info['title']]); ?>
<link rel="stylesheet" href="/static/css/novel/style.css?v=0.0.1">

<div class="header">
    <span class="back"></span>
    <a href="/novel" class="left-word">小说首页</a>

    <span class="header-right flex-box novel-header-right">
        <a class="icon-svg svg-user2" href="/User/index"></a>
        <a class="icon-svg svg-book" href="/User/myBooks"></a>
    </span>
</div>

<div class="list novel-list-box">
    <div class="title-nav"><span class="title-i"></span><?=$mark_info['title']?></div>
    
    <?php if (empty($list)) { ?>
    <div class="bbs_empty">这个地方空空如也！</div>
    <?php } else { ?>
        <?php foreach ($list as $item) { ?>
        <a class="novel-list" href="/Novel/view?id=<?=$item['id']?>">
            <div class="novel-photo" style="background-image:url(<?=$item['photo']?>);"></div>
            <div class="novel-info">
                <div class="novel-title"><?=$item['title']?> - <?=$item['author']?></div>
                <div>标签：<?php foreach ($item['mark'] as $mark) { ?><?=$mark['title']?> <?php } ?></div>
                <div class="novel-memo">简介：<?=$item['memo']?></div>
            </div>
        </a>
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
</div>
<?php self::load('common/novel_footer'); ?>
<?php self::load('common/footer'); ?>