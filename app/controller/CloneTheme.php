<?php
namespace App;

use Iam\Response;
use app\model\CloneTheme as AClone;

class CloneTheme
{
    public function index()
    {
        $list = (new AClone)->paginate(10);
        echo  Response::json($list);
        return true;
    }
}