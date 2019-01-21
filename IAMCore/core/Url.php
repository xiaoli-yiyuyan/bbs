<?php
namespace Iam;

class Url
{
	protected $class = 'Index';
	protected $action = 'Index';
	protected $baseUrl;
	protected static $index = 'index.php';
	public static $config = [
		'show_index' => false
	];

	public static function init($config = [])
	{
		if (empty($config)) {
			$config = Config::get('url');
		}

		self::$config = array_merge(self::$config, $config);
	}

	public static function href($baseUrl, $params = []) //class action
	{
		$href = self::$config['show_index'] ? '/' . self::$index . $baseUrl : $baseUrl;
		if (!empty($params)) $href .= '?' . http_build_query($params);
		return $href;
	}

	public static function redirect($url, $params = [])
	{
		$data = cmdParse($url);
		$params = array_merge($data['query'], $params);
		$action = implode('/', $data['action']);
		$url = '/' . $action;
		if (!empty($params)) {
			$url .= '?' . http_build_query($params);
		}
		header("Location: $url");
	}
}
