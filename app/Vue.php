<?php
namespace App;

use Iam\Db;
use Iam\View;
use Iam\Page;
use Iam\Request;

class Vue extends \comm\core\Home
{
    public function index()
    {
        downloadImage(Request::post('photo'), uniqid(), 'static/novels/');
    }
}
