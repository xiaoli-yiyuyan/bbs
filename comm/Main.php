<?php
namespace app;

use Iam\Db;
use Iam\View;
use Iam\Listen;
use Iam\Component;

class Main
{
    public function index($url = '')
    {
        $component = new Component([
            'model' => 'default'
        ]);
        if (!$component->load($url)) {
            \Iam\App::runTpl();
        }
    }
}