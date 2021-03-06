<?php
	define('EXT', '.php');
	define('CORE_PATH', __DIR__ . DS . 'core' . DS);
	define('ROOT_PATH', dirname(realpath(APP_PATH)) . DS);

	// require CORE_PATH . 'Loader.php'; //自动加载类

	require ROOT_PATH . 'vendor/autoload.php';
	require IAM_PATH . 'function.php';

	$config = \Iam\Config::set(include COMM_PATH . 'datebase' . EXT); //设置并返回配置

	\think\Db::setConfig([
		// 数据库类型
		'type'        => 'mysql',
		// 数据库连接DSN配置
		'dsn'         => '',
		// 服务器地址
		'hostname'    => $config['host'],
		// 数据库名
		'database'    => $config['dbname'],
		// 数据库用户名
		'username'    => $config['user'],
		// 数据库密码
		'password'    => $config['pass'],
		// 数据库连接端口
		'hostport'    => $config['port'],
		// 数据库连接参数
		'params'      => [],
		// 数据库编码默认采用utf8
		'charset'     => 'utf8',
		// 数据库表前缀
		'prefix'      => '',
		'paginate'    => [
			'type'      => 'comm\ext\IPage',
			'var_page'  => 'page',
			'list_rows' => 15,
		],
	]);

	include(COMM_PATH . 'function.php');
	// \Iam\Loader::register();
	// \Iam\Url::$hide = true;
	\Iam\Config::set(include IAM_PATH . 'convention' . EXT);
	\Iam\Config::set(include COMM_PATH . 'config' . EXT);
	\Iam\Plugin::instance()->load();
	\Iam\Listen::hook('beforeCreate');
	\Iam\App::run();
	\Iam\Listen::hook('created');
	\Iam\Listen::hook('destroyed');
