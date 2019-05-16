<?php
// error_reporting(0);
    date_default_timezone_set('PRC');
	define('DS', DIRECTORY_SEPARATOR);
    define('APP_PATH', __DIR__ . '/app/');
    define('IAM_PATH', __DIR__ . '/IAMCore/');
	define('COMM_PATH', __DIR__ . DS . 'comm' . DS);
    session_start();
    require IAM_PATH . '/run.php';
?>
