<?php
namespace Iam;
// use Iam\Loader;

class App
{
	protected static $approot = 'app';
	protected static $namespace = 'App';
	protected static $controller = 'controller';
	protected static $baseUrl;
	protected static $class = 'Index';
	protected static $action = 'index';
	protected static $admin = 'Admin';	

	public static function init()
	{
		include(APP_PATH . 'function.php');
		self::parseUrl();
	}

	public static function run()
	{
		self::init();
		self::runTpl();
		// $appPath = self::$approot . DS . self::$controller;
		// print_r($appPath);
		// Loader::addClassMap(self::$namespace, $appPath); //添加命名空间
		// $modelPath = self::$approot . DS . 'model';
		// Loader::addClassMap('Model', $modelPath); //添加命名空间
		// $appClass = new \app\Main;
		// $appClass->index(self::$baseUrl);
	}

	public static function runTpl()
	{
		$runClass = '\\' . self::$namespace . '\\' . self::$class;
		if (!class_exists($runClass)) {
			return self::setErrorPage();
		}
		$appClass = new $runClass;
		$appAction = self::$action;
		if (!method_exists($appClass, $appAction)) {
			return self::setErrorPage();
		}

		// 执行带参数的方法
		$method = new \ReflectionMethod($runClass, $appAction);
		$params = $method->getParameters();
		$args = [];
		// 设置参数
		foreach ($params as $param) {
			$paramName = $param->getName();
			if (isset($_REQUEST[$paramName])) {
				$args[] = $_REQUEST[$paramName];
			} elseif ($param->isDefaultValueAvailable()) {
				$args[] = $param->getDefaultValue();
			}
		}

		// 执行方法
		if (count($args) == $method->getNumberOfParameters()) {
			$method->invokeArgs($appClass, $args);
		} else {
			throw new \Exception('参数错误，缺少参数');
		}

		//$appClass->$appAction();
	}

	private static function setErrorPage()
	{
		header('HTTP/1.1 404 Not Found');
		header("status: 404 Not Found");
		echo '404 您访问的网页不存在[2] <a href="/">点击返回首页</a>';
	}
	
	private static function parseUrl()
	{
		if (!isset($_SERVER['REQUEST_URI'])) {
			$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],1 );
			if (isset($_SERVER['QUERY_STRING'])) { $_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING']; }
		}
		$requestUrl = $_SERVER['REQUEST_URI'];
		self::baseUrl($requestUrl);
		$url = explode('/', self::$baseUrl);
		$k = Config::get('REWRITE');
		if (!empty($url[$k])) {
			$class = explode('_', $url[$k]);
			foreach ($class as &$item) {
				$item = ucfirst($item);
			}
			self::$class = implode('', $class);
		}
		
		if (!empty($url[$k + 1])) {
			$action = explode('_', $url[$k + 1]);
			foreach ($action as &$item) {
				$item = ucfirst($item);
			}
			self::$action = lcfirst(implode('', $action));
		}
	}

	private static function baseUrl($url)
	{
		self::$baseUrl = strpos($url, '?') ? strstr($url, '?', true) : $url;
	}
}
