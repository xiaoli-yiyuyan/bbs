<?php
namespace Iam;
use Iam\Loader;

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
		$appPath = self::$approot . DS . self::$controller;
		// print_r($appPath);
		Loader::addClassMap(self::$namespace, $appPath); //添加命名空间
		$modelPath = self::$approot . DS . 'model';
		Loader::addClassMap('Model', $modelPath); //添加命名空间
		// linux 下和 windows 下斜杠和反斜杠问题
		if (!(self::$namespace == 'App' && self::$class == self::$admin)) {
			$appClass = new \app\Main;
			$appClass->index(self::$baseUrl);
			return; 
		}
		$runClass = '\\' . self::$namespace . '\\' . self::$class;
		if (class_exists($runClass)) {
			$appClass = new $runClass;
			$appAction = self::$action;
			if (method_exists($appClass, $appAction)) {
				$appClass->$appAction();
			} else {
				echo '404 您访问的网页不存在[1]';
			}
		} else {
			echo '404 您访问的网页不存在[2]';
		}
	}

	private static function parseUrl()
	{
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
