<?php
    if (!empty($view['err'])) {
        $this->load('/error', ['title' => '查看失败', 'msg' => $view['msg']]);
        exit();
    }
?>
<?php $this->load('/components/common/header', ['title' => $view['info']['title']]); ?>
<style>
    body {
        background: #FFF;
    }
</style>
<?php $this->load('/components/common/header_nav', ['back_url' => '/forum/list?id=' . $view['class_info']['id'], 'title' => $view['class_info']['title']]); ?>

<div class="content-main">
    <div class="view_head border-b">
        <div class="view_title">
            <?=$view['info']['title']?>
            <?php if ($view['info']['user_id'] == $userinfo['id'] || $view['class_info']['is_admin']) { ?>
            <div class="view_action">
                <a class="btn" href="/forum/editor?id=<?=$view['info']['id']?>">修改</a>
                <a class="btn btn_remove" data-id="<?=$view['info']['id']?>">删除</a>
            </div>
            <?php } ?>
        </div>
        <div class="view_user_info">
            <div>
                <img class="view_user_info_photo" src="<?=$view['user']['photo']?>" alt="">
                <?=$view['user']['nickname']?>
            </div>
            
            <div class="create_time"><?=$view['info']['create_time']?></div>
        </div>
    </div>
    <div class="view_context">
        <?=$view['info']['context']?>
    </div>
    <?php if (!empty($view['info']['file_list'])) { ?>
    <div class="view_context_file box_card">
        <div class="box_title">共有附件(<?=count($view['info']['file_list'])?>)个</div>
        <div class="box_content">
        <?php foreach ($view['info']['file_list'] as $key => $value) { ?>
            <div class="forum_file_list">
                <div><?=$value['name']?></div>
                <a href="<?=$value['path']?>">点击下载(<?=$value['format_size']?>)</a>
            </div>
        <?php } ?>
        </div>
    </div>
    <?php } ?>
</div>
<!-- 代码自定义 BEGIN -->
<?=code('ad_forum')?>
<!-- 代码自定义 END -->

<div class="replay_box content-main">
    <div class="replay_title border-b">全部回复 <?=$reply_list['page']['count']?> 条</div>
    
<?php if (empty($reply_list['page']['count'])) { ?>
    <div class="bbs_empty replay_empty">暂无评论！</div>
<?php } else { ?>
<div class="list bbs_list">
<?php foreach ($reply_list['data'] as $item) { ?>
    <?php $this->load('/components/forum/reply_item', ['item' => $item]); ?>
<?php } ?>
    <div class="reply_more"><a href="/forum/reply?id=<?=$view['info']['id']?>">展开全部回复 <?=$reply_list['page']['count']?> 条</a></div>
</div>
<?php } ?>

<script>
    $('.btn_remove').click(function() {
        var id = $(this).data('id');
        $.confirm('确定删除该帖子？', {
            yes: function() {
                $.getJSON('/forum/ajax_remove', {id: id}).then(function(data) {
                    $.msg('删除成功');
                    setTimeout(function() {
                        location.href = '/forum/list?id=' + data.class_id;
                    }, 1000);
                });
            },
            no: function() {
                $.alert('好吧，我以为你想清楚了。');
            }
        });
    });
</script>
<?php $this->load('/components/forum/reply_form', ['forum_id' => $view['info']['id']]); ?>

<?php $this->load('components/common/footer'); ?>