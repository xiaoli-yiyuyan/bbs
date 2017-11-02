<?php
namespace Iam;

class Listen
{
	public static $func = [];

	public static function on($name, $callback = ''){ //注入代码
		self::$func[$name] = $callback;
	}

	public static function hook($name, $arguments = []){ //运行注入
		if (isset(self::$func[$name])) {
			call_user_func_array(self::$func[$name], $arguments);
		}
	}

	function __call($name, $arguments)
	{

	}
}
