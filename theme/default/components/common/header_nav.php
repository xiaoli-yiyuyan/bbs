<?php
    $rightBottom = $rightBottom ?? [];
?>

<div class="header-bar">
    <div class="header-item back">
        <i class="icon-svg svg-left"></i>
    </div>
    
    <div class="header-title ellipsis"><?=$title?></div>
    
    <div class="header-item">
        <?php if (!empty($rightBottom)) { ?>
        <div class="_right_bottom"><?=$rightBottom['text']?></div>
        <?php } else { ?>
            
        <?php $newMessageCount = source('/api/message/count'); ?>
        <a href="/message" class="message-icon">
            <i class="icon-svg svg-mail"></i>
            <?php if (!empty($newMessageCount)) { ?>
                <div class="top-right-count new-message-count"><?=$newMessageCount?></div>
            <?php } ?>
        </a>
        <?php } ?>
    </div>
</div>
<script>
$(function() {
    $('.func-null').click(function() {
        alert('功能开发中！');
    });
    $('.header-bar .back').click(function() {
        if(window.history.length > 1){
            history.go(-1);
        }else{
            location.href='/';
        }

    });
    $('.header-bar .logo').click(function() {
        location.href='/';
    });
});
</script>
