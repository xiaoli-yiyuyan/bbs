<?php
namespace App;

use Iam\Db;
use Iam\View;
use Iam\Page;
use Iam\Response;

class Vue extends Common
{
    public function index()
    {
        View::load('vue/index');
    }
}
