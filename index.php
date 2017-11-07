<?php

    define('APP_PATH', __DIR__ . '/app/');
    define('IAM_PATH', __DIR__ . '/IAMCore/');

    session_start();

    require IAM_PATH . '/run.php';
?>