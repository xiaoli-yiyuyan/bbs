<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Iam\View as CView;
use Iam\Listen;

class View extends Common
{
    public function index()
    {
        CView::load('test/index');
        // View::template('<_head title1="你好" t2="你好"/_><_head title1="你好" t2="你好"/_>');
    }
}
