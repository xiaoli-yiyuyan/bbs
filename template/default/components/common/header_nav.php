<div class="header-height"></div>
<div class="header">
    <div class="flex-box">
        <span class="back"></span>
        <a href="<?=$back_url?>" class="left-word"><?=$title?></a>
    </div>
    <div class="flex-box">
      
        <?php if ($message_count = source('App/Message/count') > 0) { ?>
            <a href="/user/message" class="new_message_icon"><?=$message_count?></a>
        <?php } ?>
    <a href="/user/index" class="icon-svg user"></a>
    <div class="icon-svg menu left-menu"></div>
    </div>
</div>

<?php $this->load('/components/common/left_menu'); ?>
