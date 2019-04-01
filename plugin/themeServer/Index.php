<?php
namespace plugin\themeServer;

use Iam\Listen;
use plugin\themeServer\controller\Test;

class Index {
    public function init()
    {
        Listen::on('appBeforeCreate', [$this, 'appInit']);
    }

    public function appInit(&$class, &$action)
    {
        // $appContrillerClass = 'plugin\themeServer\appController\Test';
        // if (is_callable(array($appContrillerClass , $action))) {
        //     $class = new $appContrillerClass;
        // }
    }
}