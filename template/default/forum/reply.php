<?php $this->load('/components/common/header', ['title' => $view['info']['title']]); ?>
<style>
    body {
        background: #FFF;
    }
</style>
<?php $this->load('/components/common/header_nav', ['back_url' => '/forum/view?id=' . $view['info']['id'], 'title' => '查看帖子']); ?>

<div class="content-main">
    <div class="view_head border-b">
        <div class="view_title">
            <a href="/forum/view?id=<?=$view['info']['id']?>"><?=$view['info']['title']?></a>
        </div>
        <div class="view_user_info">
            <div>
                <img class="view_user_info_photo" src="<?=$view['user']['photo']?>" alt="">
                <?=$view['user']['nickname']?>
            </div>
            
            <div class="create_time"><?=$view['info']['create_time']?></div>
        </div>
    </div>
</div>

<div class="replay_box content-main">
    <div class="replay_title border-b">全部回复 <?=$reply_list['page']['count']?> 条</div>
    
<?php if (empty($reply_list['page']['count'])) { ?>
    <div class="bbs_empty replay_empty">暂无评论！</div>
<?php } else { ?>
<div class="list bbs_list">
    <?php foreach ($reply_list['data'] as $item) { ?>
    <?php $this->load('/components/forum/reply_item', ['item' => $item]); ?>
    <?php } ?>

    <?php $this->load('/components/common/page_jump', ['page' => $reply_list['page']]); ?>
</div>
<?php } ?>

<?php $this->load('/components/forum/reply_form', ['forum_id' => $view['info']['id']]); ?>
<?php $this->load('/components/common/footer'); ?>