<?php
namespace Iam;

class Response
{
	public static function json($arr = [])
	{
		self::write(json_encode($arr));
	}

	public static function write($str)
	{
		echo $str;
	}
}
