<?php
namespace App;

use Iam\Db;
use Iam\View;
use Iam\Page;
use Iam\Resonse;

class Admin extends Common
{
    public function __construct()
    {
        parent::__construct();
        if ($this->user['id'] != 1) {
            Page::error('不要在我后台乱搞，还没弄好，安全方面没有漏洞的！！！');
            exit();
        }
    }

    public function index()
    {
    	View::load('admin/index');
    }
}
