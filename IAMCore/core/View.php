<?php
namespace Iam;

use Iam\Db;
use Iam\Listen;
use Iam\Component;

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

	/**
	 * 模板加载
	 * @param string $name 模板路径
	 * @param array $data 变量参数
	 */
	public static function load($name, $data = [], $allow_json = false)
	{
		if (Request::isAjax() && $allow_json) {
			return Response::json($data);
		}
		$config = Config::get('TEMPLATE');
		$tpl_path = ROOT_PATH . $config['PATH'] . DS . $name . $config['EXT'];

		if (file_exists($tpl_path)) {
			(function() use($data, $tpl_path){
				extract(array_merge(self::$data, $data)); //数组转化为变量
				include($tpl_path);
			})();
		} else {
			$tpl = '404';
			echo $tpl_path;
		}
		//return $tpl;
	}

	/**
	 * 模板加载
	 * @param string $name 模板路径
	 * @param array $data 变量参数
	 */
	public static function page($name, $data = [])
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

	/**
	 * 变量参数设置
	 * @param string $name 变量名
	 * @param array $data 变量值
	 */
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

	/**
	 * 模板加载
	 * @param string $name 模板路径
	 * @param array $data 变量参数
	 */
	public static function loadComponent($name, $data = [])
	{
		$component = new Component([
            'model' => 'default'
        ]);
        $component->load($name);
		// Listen::hook('loadComponentBefore', ['name' => $name]);
		// $component = self::$components[$name];
		// foreach ($component['props'] as $key => &$value) {
		// 	if (isset($data[$key])) {
		// 		$value = $data[$key];
		// 	}
		// }
		// $data = $component['data']($component);
		// self::load($component['template'], $data);
	}


	private static $components = [];

	/**
	 * 创建组件
	 */
	public static function component($name, $options = [])
	{
		if (empty($options)) {
			return self::$components['name'];
		}
		return self::$components[$name] = $options;
	}


	private $config = [
		'tag_begin' => '<_',
		'tag_end' => '_>'
	];


	/**
	 * 模板解析输出
	 * @param string $context 模板内容
	 */
	public static function template($context)
	{
		// $config = [
		// 	'tag_begin' => '<_',
		// 	'tag_end' => '_>',
		// 	'tag_over' => '/'
		// ];
		// // if(preg_replace_callback('/<\!--include:(.+?)-->/', function($met){
		// // 	$this->context = str_replace($met[0],file_get_contents(".".$met[1]),$this->context);
		// // }, $this->context));$pattern
		// $pattern = '/' . $config['tag_begin'] . '([a-zA-Z0-9]+)( +(.+?)="(.+?)")*?\/' . $config['tag_end'] . '/';
		// $pattern = '/<_.*? (.+?)="(.+?)"\/_>/';
		// preg_match_all($pattern, $context,$mat, PREG_SET_ORDER);

	}
}
