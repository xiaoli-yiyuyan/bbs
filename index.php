<?php
// error_reporting(0);
    date_default_timezone_set('PRC');
    define('APP_PATH', __DIR__ . '/app/');
    define('IAM_PATH', __DIR__ . '/IAMCore/');
    session_start();
    require IAM_PATH . '/run.php';
?>
