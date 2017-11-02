<?php self::load('Common/header',['title' => $novel['title'] . '-小说阅读']); ?>
<div class="chapter-main">
    <div class="chapter-title">《<a href="/Novel/view?id=<?=$novel['id']?>"><?=$novel['title']?></a>》-<?=$novel['author']?></div>
    <div class="chapter-title2">---<?=$chapter['title']?>---</div>
    <div><?=$context?></div>
    <div class="chapter-page box">
        共<?=$page['no']?>/<?=$page['total']?>页
        <?php if ($prev_chapter > 0) { ?>
        <a href="/Novel/chapter?id=<?=$prev_chapter?>">上一章</a>
        <?php } ?>
        <a href="/Novel/chapter?id=<?=$chapter['id']?>&amp;pageno=<?=$page['no']-1?>">上一页</a>
        <a href="/Novel/chapter?id=<?=$chapter['id']?>&amp;pageno=<?=$page['no']+1?>">下一页</a>
        <?php if ($next_chapter > 0) { ?>
            <a href="/Novel/chapter?id=<?=$next_chapter?>">下一章</a>
        <?php } ?>
    </div>
</div>
<?php self::load('Common/footer'); ?>
