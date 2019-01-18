<?php self::load('common/header',['title' => '小说搜索']); ?>
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

    <?php if (in_array($action, [0,1])) { ?>
        <div class="title-nav"><span class="title-i"></span>按标题搜索的结果</div>
        <?php if (!empty($list['title'])) { ?>
            <?php foreach ($list['title'] as $item) { ?>
                <div><a href="/Novel/view?id=<?=$item['id']?>">《<?=$item['title']?>》</a>-<?=$item['author']?></div>
            <?php } ?>
        <?php } else { ?>
            <div>搜索结果为空，不要灰心换个关键词再试试吧！</div>
        <?php } ?>
    <?php } ?>
    <?php if (in_array($action, [0,2])) { ?>
        <div class="title-nav"><span class="title-i"></span>按作者搜索的结果</div>

        <?php if (!empty($list['author'])) { ?>
            <?php foreach ($list['author'] as $item) { ?>
                <div><a href="/Novel/view?id=<?=$item['id']?>">《<?=$item['title']?>》</a>-<?=$item['author']?></div>
            <?php } ?>
        <?php } else { ?>
            <div>搜索结果为空，不要灰心换个关键词再试试吧！</div>
        <?php } ?>
    <?php } ?>
    <?php if (in_array($action, [0,3])) { ?>
        <div class="title-nav"><span class="title-i"></span>按标签搜索的结果</div>
        <?php if (!empty($list['mark'])) { ?>
            <?php foreach ($list['mark'] as $item) { ?>
                <div><a href="/Novel/list?id=<?=$item['id']?>"><?=$item['title']?></a></div>
            <?php } ?>
        <?php } else { ?>
            <div>搜索结果为空，不要灰心换个关键词再试试吧！</div>
        <?php } ?>
    <?php } ?>
</div>
<?php self::load('common/novel_footer'); ?>
<?php self::load('common/footer'); ?>
