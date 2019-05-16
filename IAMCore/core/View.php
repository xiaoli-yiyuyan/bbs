<?php
namespace Iam;

use Iam\Db;
use Iam\Listen;
use Iam\Component;

class View
{
	public static $data = [];

	public static $config = [
		'DIR' => 'tpl',
		'PATH' => 'default',
		'EXT' => '.php'
	];

	/**
	 * 配置
	 */
	public static function setConfig($options = [])
	{
		$config = Config::get('TEMPLATE');
		self::$config = array_merge($config, $options);
		// 修改配置
		Listen::hook('viewConfigUpdate', [&self::$config]);
	}

	/**
	 * 获取路径
	 */
	public static function getPath($name)
	{
		
		$path = ROOT_PATH . self::$config['DIR'] . DS . self::$config['PATH'] . DS . $name . self::$config['EXT'];
		Listen::hook('viewGetPath', [&$path]);
		return $path;
	}

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
		$use_data = array_merge(self::$data, $data);
		// 开始加载模板
		Listen::hook('viewBeforeLoad', [&$name, &$use_data]);

		if (Request::isAjax() && $allow_json) {
			return Response::json($data);
		}
		$tpl_path = self::getPath($name);
		
		if (file_exists($tpl_path)) {
			(function() use($use_data, $tpl_path){
				extract($use_data); //数组转化为变量
				include($tpl_path);
			})();

			// 模板加载结束
			Listen::hook('viewLoaded', [&$name, &$use_data]);
			return true;
		} else {

			// 模板加载错误
			Listen::hook('viewLoadError', [&$name, &$use_data]);
			return;
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
		$tpl_path = self::getPath($name);
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
		Listen::hook('viewDataUpdate', [&$name, &$value]);
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
}
