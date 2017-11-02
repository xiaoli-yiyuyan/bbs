<?php self::load('Common/header',['title' => $novel['title'] . '-小说阅读']); ?>
<div class="header">
    <span class="back"></span>
    <span class="left-word"><?=$novel['title']?></span>
    <?php if (empty($user['id'] > 0)){ ?>
        <a href="/Login/index" class="right-nav">登陆/注册</a>
    <?php } else { ?>
        <a href="/User/index" class="right-nav"><?=$user['username']?></a>
    <?php } ?>
</div>
<div class="content-main">
    <div class="novel-view">
        <div class="novel-view-box box">
            <div class="novel-photo" style="background-image:url(<?=$novel['photo']?>);"></div>
            <div class="novel-info">
                <div class="novel-title"><?=$novel['title']?></div>
                <div>作者：<?=$novel['author']?></div>
                <div>评分：★★★★☆(8.0/278人评过)</div>
                <div>标签：<?php foreach ($mark as $item) { ?><a href="/Novel/list?id=<?=$item['markid']?>"><?=$item['title']?></a><?php } ?></div>
                <div>32.589万字|连载</div>
            </div>
        </div>
        <div class="novel-action box">
            <a class="button" href="/Novel/chapter?id=<?=end($list)['id']?>">开始阅读</a>
            <a class="button" href="/Novel/novelCollect?id=<?=$novel['id']?>"><?=$isCollect?></a>
        </div>
        <div class="novel-memo"><?=$novel['memo']?></div>
    </div>

    <div class="novel-nav">目录<?php if($user['id'] == 1) { ?>(<a href="/Novel/addChapter?id=<?=$novel['id']?>">添加章节</a>)<?php } ?></div>
    <?php foreach ($list as $item) { ?>
        <div class="novel-nav-list"><a href="/Novel/chapter?id=<?=$item['id']?>"><?=$item['title']?></a></div>
    <?php } ?>
</div>
<script type="text/javascript">
    $('.novel-memo').click(function() {
        $(this).toggleClass('novel-memo-more');
    });
</script>
<?php self::load('Common/footer'); ?>
