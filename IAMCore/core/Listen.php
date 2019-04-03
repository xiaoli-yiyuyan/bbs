<?php
namespace Iam;

class Listen
{
	public static $func = [];

	/**
	 * 监听注入
	 */
	public static function on($name, $callback = ''){ //注入代码
		if (!isset(self::$func[$name])) {
			self::$func[$name] = [];
		}
		self::$func[$name][] = $callback;

	}

	/**
	 * 运行注入
	 */
	public static function hook($name, $arguments = []){ //运行注入
		if (isset(self::$func[$name])) {
			foreach (self::$func[$name] as $func) {
				call_user_func_array($func, $arguments);
			}
		}
	}

	function __call($name, $arguments)
	{

	}
}
