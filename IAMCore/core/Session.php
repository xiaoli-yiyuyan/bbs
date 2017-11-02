<?php
namespace Iam;

class Session
{
	// public static $data = [];

	public static function set($name, $value = '')
	{
		$_SESSION[$name] = $value;
	}

	public static function get($name)
	{
		return $_SESSION[$name];
	}

	public static function has($name)
	{
		return isset($_SESSION[$name]);
	}

	public static function remove($name)
	{
		unset($_SESSION[$name]);
	}
}
