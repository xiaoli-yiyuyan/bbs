<?php
namespace Iam;

class Page
{
	public $count;
	public $pagesize;

	private $options = [
		// 总数
		'count' => 0,
		// 当前页
		'page' => 1,
		'page_name' => 'p',
		// 每页条数
		'pagesize' => 10,
		// 跳转路径
		'path' => '',
		// 跳转参数
		'query' => [],
	];

	public function __construct($options)
	{
		$this->options = array_merge($this->options, $options);
	}

	public function parse()
	{
		$p = $this->options['page'];
		$page_count = ceil($this->options['count'] / $this->options['pagesize']);
		if ($page_count == 0) {
			$page_count = 1;
		}
		$page = $p >= $page_count ? $page_count : ($p > 0 ? $p : 1);
		$href = ['#', '#', '#', '#'];
		$query = array_merge($this->options['query'], ['page' => $p]);
		if ($page > 1) {
			$href[0] = $this->parsePath(1);
			$href[1] = $this->parsePath($page - 1);
		}

		if ($page < $page_count) {
			$href[2] = $this->parsePath($page + 1);
			$href[3] = $this->parsePath($page_count);
		}
		
		return [
			'page_count' => $page_count,
			'pagesize' => $this->options['pagesize'],
			'page' => $page,
			'count' => $this->options['count'],
			'href' => $href
		];
	}

	private function parsePath($p)
	{
		$query = array_merge($this->options['query'], [$this->options['page_name'] => $p]);
		$q = [];
		foreach ($query as $key => $value) {
			$q[] = $key . '=' . $value;
		}
		return $this->options['path'] . '?' . implode('&', $q); 
	}

	public static function init()
	{
		return new self();
	}

	public static function error($msg, $url = '')
	{
		View::load('error', ['err' => 1, 'msg' => $msg], true);
	}

	public static function success($msg, $url = '')
	{
		View::load('success', ['msg' => $msg, 'url' => $url], true);
	}

	public static function countPage($p, $allnum, $pagesize = 10){
		$page_count = ceil($allnum/$pagesize);
		$page = $p >= $page_count ? $page_count : $p > 0 ? $p : 0;
		$href = [];
		return [
			'page_count' => $page_count,
			'pagesize' => $pagesize,
			'page' => $page,
			'count' => $allnum
		];
	}
}
