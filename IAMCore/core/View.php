<?php
namespace Iam;

class View
{
	public static $data = [];

	public static function show($str, $data = []){
		$str = self::parseInclude($str);
		if(!empty($data)) {
			$str = self::parseTags($str, $data);
		}
		//$str = self::parseFunction($str);
		Listen::hook('show', [&$str]);
		echo $str;
	}

	public static function load($name, $data = [])
	{
		$config = Config::get('TEMPLATE');
		$tpl_path = ROOT_PATH . $config['PATH'] . DS . $name . $config['EXT'];
		if (file_exists($tpl_path)) {
			(function() use($data, $tpl_path){
				extract(array_merge(self::$data, $data)); //数组转化为变量
				include($tpl_path);
			})();
		} else {
			$tpl = '404';
		}
		//return $tpl;
	}

	public static function data($name, $value = '')
	{
		if (is_string($name)) {
			if (empty($value)) { //取值操作
				return self::$data[$name];
			} else { //赋值
				self::$data[$name] = $value;
			}
		} elseif(is_array($name)) {
			self::$data = array_merge(self::$data, $name);
		}
	}
}
