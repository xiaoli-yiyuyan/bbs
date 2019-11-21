<?php self::load('common/header',['title' => '后台管理-奖励设置']); ?>
<?php self::load('admin/header_nav'); ?>
<?php
    $edit = new comm\core\EditSetting;
?>
<style>
.iframe {
    display: block;
    margin: auto;
    margin-top: 10px;
    width: 98%;
    min-height: 100vh;
}
</style>
<div class="content">
    <div class="namespace">
        <a href="#">系统设置</a> \ <a href="#">主题管理</a> \ <div class="nav_title">主题配置</div>
    </div>
    
    <iframe class="iframe" src="/admin/theme/settingIframe" frameborder="0" onLoad="iframeOnliad(this)"></iframe>
</div>
<?php self::load('common/footer_nav'); ?>

<script>
    function iframeOnliad(iframe) {
        setTimeout(function() {
            iframe.height = iframe.contentDocument.body.scrollHeight;
        }, 500);
    }
</script>
<?php self::load('common/footer'); ?>
