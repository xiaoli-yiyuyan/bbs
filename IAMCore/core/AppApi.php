<?php
namespace Iam;

class AppApi
{
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
		$appPath = self::$namespace . DS . self::$controller;
		Loader::addClassMap('App', $appPath); //添加命名空间
		$runClass = self::$namespace . DS . self::$class;
		if (class_exists($runClass)) {
			$appClass = new $runClass;
			$appAction = self::$action;
			if (method_exists($appClass, $appAction)) {
				$appClass->$appAction();
			} else {
				echo 'no action';
			}
		} else {
			echo 'no class';
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
