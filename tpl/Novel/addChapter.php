<?php self::load('Common/header',['title' => '添加文章']); ?>
<div class="header">
    <span class="back"></span>
    <span class="header-center">发表章节</span>
</div>
<form class="box-padding" action="/Novel/addChapter" method="post">

    <input type="hidden" name="id" value="<?=$novel['id']?>">
    <div class="item-line item-lg">
        <div class="item-title">小说</div>
        <div class="item-input"><?=$novel['title']?></div>
    </div>
    <div class="item-line item-lg">
        <div class="item-title">章节标题</div>
        <div class="item-input"><input type="text" class="input input-line input-lg" name="title" placeholder="标题"></div>
    </div>
    <div class="item-line item-lg">
        <div class="item-title">内容</div>
        <div class="item-input">
            <textarea name="context" class="input input-line input-lg" placeholder="内容"></textarea>
        </div>
    </div>
    <p><button class="btn btn-fill btn-lg">立即添加</button></p>
    </form>
<?php self::load('Common/footer'); ?>
