<?php self::load('Common/header',['title' => '小说搜索']); ?>
    <div><a href="/">返回首页</a>|<a href="/Login">返回登陆</a></div>
    <?php if (in_array($action, [0,1])) { ?>
        <div>--按标题搜索的结果--更多</div>
        <?php if (!empty($list['title'])) { ?>
            <?php foreach ($list['title'] as $item) { ?>
                <div><a href="/Novel/view?id=<?=$item['id']?>">《<?=$item['title']?>》</a>-<?=$item['author']?></div>
            <?php } ?>
        <?php } else { ?>
            <div>搜索结果为空，不要灰心换个关键词再试试吧！</div>
        <?php } ?>
    <?php } ?>
    <?php if (in_array($action, [0,2])) { ?>

        <div>--按作者搜索的结果--更多</div>
        <?php if (!empty($list['author'])) { ?>
            <?php foreach ($list['author'] as $item) { ?>
                <div><a href="/Novel/view?id=<?=$item['id']?>">《<?=$item['title']?>》</a>-<?=$item['author']?></div>
            <?php } ?>
        <?php } else { ?>
            <div>搜索结果为空，不要灰心换个关键词再试试吧！</div>
        <?php } ?>
    <?php } ?>
    <?php if (in_array($action, [0,3])) { ?>
        <div>--按标签搜索的结果--更多</div>
        <?php if (!empty($list['mark'])) { ?>
            <?php foreach ($list['mark'] as $item) { ?>
                <div><a href="/Novel/list?id=<?=$item['id']?>"><?=$item['title']?></a></div>
            <?php } ?>
        <?php } else { ?>
            <div>搜索结果为空，不要灰心换个关键词再试试吧！</div>
        <?php } ?>
    <?php } ?>

<?php self::load('Common/footer'); ?>
