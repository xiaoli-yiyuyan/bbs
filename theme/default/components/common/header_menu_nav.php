<?php useComp('/components/common/left_menu'); ?>
<?php $newMessageCount = source('/api/message/count'); ?>
<header class="header-bar">
    <div class="header-item left-menu">
        <i class="icon-svg svg-menu"></i>
    </div>
    
    <div class="header-title"><?=$title?></div>
    
    <div class="header-item">
        <a href="/message" class="message-icon">
            <i class="icon-svg svg-mail"></i>
            <?php if (!empty($newMessageCount)) { ?>
            <div class="top-right-count new-message-count"><?=$newMessageCount?></div>
            <?php } ?>
        </a>
    </div>
</header>