<?php self::load('Common/header',['title' => $title]); ?>
<div class="header">
  <span class="logo"></span>
  <?php if (empty($user['id'] > 0)){ ?>
      <a href="/Login/index" class="right-nav">登陆</a>
  <?php } else { ?>
      <span  class="right-nav"><a href="/">首页</a> | <a href="/User/index"><?=$user['username']?></a></span>
  <?php } ?>
</div>
<div class="list">
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
</div>
<div class="page">
  <?php if($morepage==1) {?><label><a href="<?=$nextPage?>">查看更多</a></label>
<?php }else{?> <span>没有更多了</span> <?php } ?>

</div>
<?php self::load('Common/footer'); ?>
<style>
.list{padding-top: 5px;padding-left: 10px}
.novelList{height: 40px;line-height: 40px;border-bottom: 1px solid #f9f9f9}
.list a:link{color:#584C4C}
.list a:hover{color:#F92020}
.author {font-size: 12px;}
.page{height: 40px;line-height: 40px;text-align: center;color:#ccc}
.page a{width: 100%}
</style>
