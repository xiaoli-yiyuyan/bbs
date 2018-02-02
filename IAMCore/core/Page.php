<?php
namespace Iam;

class Page
{
	public $count;
	public $pagesize;

	public function __construct($count, $pagesize = 10)
	{
		$this->$count = $count;
		$this->$pagesize = $pagesize;
	}

	public static function init()
	{
		return new self();
	}

	public static function error($msg, $url = '')
	{
		View::load('error', ['msg' => $msg]);
	}

	public static function success($msg, $url = '')
	{
		View::load('success', ['msg' => $msg, 'url' => $url]);
	}

	public static function countPage($p, $allnum, $pagesize = 10){
		$allPage = ceil($allnum/$pagesize);
		$page = $p >= $allPage ? $allPage : ($p+1);
	}
}
