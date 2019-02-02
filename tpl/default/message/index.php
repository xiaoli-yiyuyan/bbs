<?php component('components/common/user_header',['title' => '消息列表']); ?>
<?php component('/components/common/header_nav', ['back_url' => '/user/index', 'title' => '个人中心']); ?>


<?php if (empty($list)) { ?>
    <div class="bbs_empty">这个地方空空如也！</div>
<?php } else { ?>
<div class="list">
<?php foreach ($list as $item) { ?>
<?php $userinfo = source('Model/User/getAuthor', ['id' => $item['user_id']]); ?>
    <div class="list-group friend_list message_list">
        <div class="list-item list-item-image-text border-b">
            <div class="list-item-image">
                <img src="<?=$userinfo['photo']?>" alt="">
            </div>
            <div class="list-item-text">
                <div class="nickname"><?=$userinfo['nickname']?></div>
                <div class="explain"><?=$item['content']?></div>
            </div>
            <?php if (!$item['status']) { ?>
            <span class="new_message">新</span>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<?=$list->render()?>

</div>
<?php } ?>

<?php component('components/common/footer'); ?>