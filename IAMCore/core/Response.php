<?php
namespace Iam;

class Response
{
	public static function json($arr = [])
	{
		header('Content-Type: application/json; charset=utf-8');
		self::write(json_encode($arr, JSON_UNESCAPED_UNICODE));
	}

	public static function write($str)
	{
		echo $str;
	}
}
