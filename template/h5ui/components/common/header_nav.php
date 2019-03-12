<div class="header-bar">
    <div class="header-item back">
        <i class="icon-svg svg-left"></i>
    </div>
    
    <div class="header-title ellipsis"><?=$title?></div>
    
    <div class="header-item">
        <a href="/message"><i class="icon-svg svg-mail"></i></a>
    </div>
</div>
<script>
$(function() {
    $('.func-null').click(function() {
        alert('功能开发中！');
    });
    $('.header-bar .back').click(function() {
        history.go(-1);
    });
    $('.header-bar .logo').click(function() {
        location.href='/';
    });
});
</script>
