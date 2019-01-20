<?php component('/components/common/header?title=安米社区-专注于手机网站建设' ); ?>
<link rel="stylesheet" href="/static/css/novel/style.css?v=0.0.1">


<script src="/static/js/iscroll.js"></script>
<div class="header-height"></div>
<header class="header">
    <span class="logo"></span>
    <div class="flex-box">
      
    <?php if (source('app/Message/count') > 0) { ?>
            <a href="/user/message" class="new_message_icon"><?=$message_count?></a>
        <?php } ?>
    <a href="/user/index" class="icon-svg user"></a>
    <div class="icon-svg menu left-menu"></div>
    </div>
</header>
<?//=source('app/common/Ubb/getTips?msg=123456&type=1')?>
<?php component('/components/common/left_menu'); ?>
<div class="index_top_nav index_link">
    <a href="<?=href('/forum/list?id=1')?>">综合</a>
    <a href="<?=href('/forum/list?id=2')?>">源码</a>
    <a href="<?=href('/forum/list?id=3')?>">任务</a>
    <a href="<?=href('/user/index')?>">个人</a>
    <a href="<?=href('/user/friend')?>">粉丝</a>
</div>
<?php $column = source('App/Column/list'); ?>
<div class="column_nav">
    <?php foreach ($column as $item) { ?>
    <a class="column_link" href="/forum/list?id=<?=$item['id']?>">
        <img class="column_photo" src="<?=$item['photo']?>" alt="<?=$item['title']?>">
        <div class="column_info">
            <div class="column_title"><?=$item['title']?></div>
            <div class="column_count">
                总数: <?php //component('/components/forum/get_count_by_class_id', ['class_id' => $item['id']]); ?>
            </div>
        </div>
    </a>
    <?php } ?>
</div>


<div class="link_title">更新于：2018-10-26</div>
<div class="m_nav">
  	新《<a href="/sign/index">暴击签到</a>》 今天签到了吗，来看看今天人品如何。<br>
  	《<a href="/chat/room?id=2">第一聊天室</a>》 再次上线！实时聊天，无需刷新等待！
</div>
</div>
<div class="m_nav">
    <div class="nav_title"><a href="/forum/view?id=4589">[安米程序] 安米程序V1.0.0正式版下载</a></div>
    <div class="nav_memo">
        安米程序[新一代H5手机建站程序]是一款专注于H5手机网站/app建设的一款程序，具有免费开源，上手难度低，程序精简（程序不足1M），功能强大，不懂编程也能轻松定制自己想要的功能。后台强大的组件编写功能，可以像堆积木一样，随意组合出你想要的功能。
    </div>
</div>
<?php //self::load('/components/forum/simple_list', ['list' => $list2]); ?>

<div class="m_body">
    <div class="title-nav"><span class="title-i"></span>最近活跃会员 <a class="user_rank_link" href="/user/rank">Top 排行榜</a></div>
    <?php self::loadComponent('/components/user/new_user_list'); ?>
</div>
<div class="link_title">最新资讯</div>

<?php //self::load('/components/forum/img_list', ['list' => $list]); ?>

<?php self::loadComponent('/components/common/index_link'); ?>
<div class="footer_nav">
  <div>联系我QQ: 243802688</div>
  <div>安米程序 2018新鲜出炉</div>
    <div>本程序免费开源 官网地址 <a class="ianmi_link" href="http://ianmi.com">http://ianmi.com</a></div>
</div>
<?php // Iam\View::load('common/footer_nav'); ?>

<?php self::load('/common/footer'); ?>