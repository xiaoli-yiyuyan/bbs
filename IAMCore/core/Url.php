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
		$url = explode('?', $url);
		if (count($url) > 1) {
			$params = array_merge(explode('&', $url[1]), $params);
		}
		$url = !empty($params) ? $url[0] .= '?' . http_build_query($params) : $url[0];
		header("Location: $url");
	}
}
