<?php self::load('Common/header',['title' => '发表帖子']); ?>
<div class="header">
    <span class="back"></span>
    <span class="header-center">发帖</span>
</div>

<style media="screen">
    .mark-out {
        padding-right: .5rem;
    }
    .mark-name{
        display: none;
    }
    .add-mark-show{
        display: inline-block;
    }
</style>
<form class="box-padding" action="/forum/add/?classid=<?=$class_info['id']?>" method="post">

    <div class="item-line item-lg">
        <div class="item-title">标题</div>
        <div class="item-input"><input type="text" class="input input-line input-lg" name="title" placeholder="标题"></div>
    </div>
    <div class="item-line item-lg">
        <div class="item-title">内容</div>
        <div class="item-input">
            <textarea name="context" class="input input-line input-lg" placeholder="简介"></textarea>
        </div>
    </div>
    <p><button class="btn btn-fill btn-lg">立即发表</button></p>
</form>

<?php self::load('Common/footer'); ?>
