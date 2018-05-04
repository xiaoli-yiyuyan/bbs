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

	public static function parseUrl()
	{
		$requestUrl = $_SERVER['REQUEST_URI'];
		self::baseUrl($requestUrl);
		$url = explode('/',self::$baseUrl);
		$k = Config::get('REWRITE');
		if (!empty($url[$k])) self::$class = $url[$k];
		if (!empty($url[$k + 1])) self::$action = $url[$k + 1];
	}

	public static function baseUrl($url)
	{
		self::$baseUrl = strpos($url, '?') ? strstr($url, '?', true) : $url;
	}
}
