<?php $this->load('/components/common/header', ['title' => $column_info['title']]); ?>
<?php $this->load('/components/common/header_nav', ['back_url' => '/', 'title' => '首页']); ?>

<div class="bbas_action">
    <div class="flex-box">
        <img class="bbs_photo" src="<?=$column_info['photo']?>" alt="">
        <div>
            <div class="bbas_action_title"><?=$column_info['title']?></div>
            <div class="create_time">总数：<?=$list['page']['count']?></div>
        </div>
    </div>
    <div>
        <?php if ($column_info['user_add'] || $column_info['is_admin']) { ?>
        <a class="btn" href="/forum/add?id=<?=$column_info['id']?>" style="display:inline-block;">发帖</a>
        <?php } ?>
    </div>
</div>

<div class="bbs_order border-b">
    <div class="bbs_order_title">话题</div>
    <div>最近回复</div>
</div>
<?php $this->load('/components/forum/list', ['list' => $list]); ?>
<?php $this->load('/components/common/footer'); ?>