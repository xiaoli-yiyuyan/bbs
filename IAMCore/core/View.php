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
	public static function getPath($name, $ext = true)
	{
		
		$path = ROOT_PATH . self::$config['DIR'] . DS . self::$config['PATH'] . DS . $name;
		if ($ext) {
			$path .= self::$config['EXT'];
		}
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
	private static $mime = array (
		//applications
		'doc'  => 'application/vnd.ms-word',
		'xls'  => 'application/vnd.ms-excel',
		'ppt'  => 'application/vnd.ms-powerpoint',
		'pps'  => 'application/vnd.ms-powerpoint',
		'pdf'  => 'application/pdf',
		'xml'  => 'application/xml',
		'odt'  => 'application/vnd.oasis.opendocument.text',
		'swf'  => 'application/x-shockwave-flash',
		// archives
		'gz'  => 'application/x-gzip',
		'tgz'  => 'application/x-gzip',
		'bz'  => 'application/x-bzip2',
		'bz2'  => 'application/x-bzip2',
		'tbz'  => 'application/x-bzip2',
		'zip'  => 'application/zip',
		'rar'  => 'application/x-rar',
		'tar'  => 'application/x-tar',
		'7z'  => 'application/x-7z-compressed',
		// texts
		'txt'  => 'text/plain',
		'html' => 'text/html',
		'htm'  => 'text/html',
		'js'  => 'text/javascript',
		'css'  => 'text/css',
		'bmp'  => 'image/x-ms-bmp',
		'jpg'  => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'gif'  => 'image/gif',
		'png'  => 'image/png',
		'svg' => 'image/svg+xml'
		);
	private static function _getMimeDetect() {
	  if (class_exists('finfo')) {
		return 'finfo';
	  } else if (function_exists('mime_content_type')) {
		return 'mime_content_type';
	  } else if ( function_exists('exec')) {
		$result = exec('file -ib '.escapeshellarg(__FILE__));
		if ( 0 === strpos($result, 'text/x-php') OR 0 === strpos($result, 'text/x-c++')) {
		  return 'linux';
		}
		$result = exec('file -Ib '.escapeshellarg(__FILE__));
		if ( 0 === strpos($result, 'text/x-php') OR 0 === strpos($result, 'text/x-c++')) {
		  return 'bsd';
		}
	  }
	  return 'internal';
	}
	private static function _getMimeType($path) {
	  $mime = self::$mime;
	  $fmime = self::_getMimeDetect();
	  switch($fmime) {
		case 'finfo':
		  $finfo = finfo_open(FILEINFO_MIME);
		  if ($finfo) 
			$type = @finfo_file($finfo, $path);
		  break;
		case 'mime_content_type':
		  $type = mime_content_type($path);
		  break;
		case 'linux':
		  $type = exec('file -ib '.escapeshellarg($path));
		  break;
		case 'bsd':
		  $type = exec('file -Ib '.escapeshellarg($path));
		  break;
		default:
		  $pinfo = pathinfo($path);
		  $ext = isset($pinfo['extension']) ? strtolower($pinfo['extension']) : '';
		  $type = isset($mime[$ext]) ? $mime[$ext] : 'unkown';
		  break;
	  }
	  $type = explode(';', $type);
	  //需要加上这段，因为如果使用mime_content_type函数来获取一个不存在的$path时会返回'application/octet-stream'
	  if ($fmime != 'internal' AND $type[0] == 'application/octet-stream') {
		$pinfo = pathinfo($path); 
		$ext = isset($pinfo['extension']) ? strtolower($pinfo['extension']) : '';
		if (!empty($ext) AND !empty($mime[$ext])) {
		  $type[0] = $mime[$ext];
		}
	  }
	  return $type[0];
	}
	
	/**
	 * 加载静态文件
	 */
	public static function loadStatic($name)
	{
		$name = preg_replace('/^(.+?\/)/', '', $name);
		$path = self::getPath($name, false);
		$mime = self::_getMimeType($path);
		header( 'Content-type: ' . $mime);
		readfile ($path);
		return true;
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
