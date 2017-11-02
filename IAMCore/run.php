<?php
	define('DS', DIRECTORY_SEPARATOR);
	define('EXT', '.php');
	define('CORE_PATH', __DIR__ . DS . 'core' . DS);
	define('ROOT_PATH', dirname(realpath(APP_PATH)) . DS);

	require CORE_PATH . 'Loader.php'; //自动加载类

	\Iam\Loader::register();
	// \Iam\Url::$hide = true;
	\Iam\Config::set(include IAM_PATH . 'convention' . EXT);
	\Iam\App::run();
