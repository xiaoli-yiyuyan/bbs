<?php
namespace App;

use Iam\View;
use app\Setting;

class Sign extends Common
{
    public function index()
    {
    	View::load('sign/index');
    }
}
