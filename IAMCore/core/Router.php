<?php
namespace Iam;

class Router
{
	public $index = '/index/index';
	public $defaultAction = 'index';
	public $appRootNampspace = 'app';
	public static $_ins;

	/**
	 * 单例模式
	 */
	public static function instance()
	{
		if(!self::$_ins) {
			self::$_ins = new self();
		}
		return self::$_ins;
	}

	public function parse()
	{
		if (!isset($_SERVER['REQUEST_URI'])) {
			$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],1 );
			if (isset($_SERVER['QUERY_STRING'])) {
				$_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING'];
			}
		}
		$requestUrl = $_SERVER['REQUEST_URI'];
		
		$path = strpos($requestUrl, '?') ? strstr($requestUrl, '?', true) : $requestUrl;
		$path = trim($path, '/');
		if (!$path) {
			$path = $this->index;
		}
		if (strpos($path, '/') === false) {
			$path .= '/' . $this->defaultAction;
		}
		// 拆分
		$url = explode('/', trim($path, '/'));
		$count = count($url);

		// 取出Class
		$class = $url[$count - 2];
		// 取出Action
		$action = $url[$count - 1];
		// 取出路径
		$path = array_splice($url, $count - 2);

		// 组合命名空间
		$namespace = '\\' . $this->appRootNampspace . '\\' . implode('\\', $url);
		// $namespace = '\\' . trim($namespace, '\\') . '\\';
		$namespace = trim($namespace, '\\');
		return [
			'namespace' => $namespace,
			'class' => $this->xiaToTuo($class, true),
			'action' => $this->xiaToTuo($action),
			'params' => $_GET
		];
	}
	
	private  function baseUrl($url)
	{
		return strpos($url, '?') ? strstr($url, '?', true) : $url;
	}
	
	/**
	 * 驼峰转下划线
	 */
	private function toLastState($str)
	{
		$str = lcfirst($str);
		$splitChar = '_';
		$formatStr = preg_replace('/([A-Z])/', $splitChar . '\\1', $str);
		return strtolower($formatStr);
	}

	/**
	 * 下滑线转驼峰
	 * @param string $str
	 * @param bool $first 是否将首字母也转换成大写
	 */
	private function xiaToTuo($str, $first = false)
	{
		$class = explode('_', $str);
		foreach ($class as &$item) {
			$item = ucfirst($item);
		}
		$to = implode('', $class);
		if (!$first) {
			$to = lcfirst($to);
		}
		return $to;
	}
}
