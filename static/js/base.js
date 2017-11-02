$(function() {
    $('.func-null').click(function() {
        alert('功能开发中！');
    });
    $('.header .back').click(function() {
        history.go(-1);
    });
    $('.header .logo').click(function() {
        location.href='/';
    });
});
