<?php
namespace plugin\themeServer\controller;

use Iam\View;
use app\Setting;
use Model\Theme;

class Test {
    public function __construct() {
        echo '__construct';
    }
    public function myTpl() {
        $setting = Setting::get(['theme', 'component']);
        $list = (new Theme)->paginate(10);
        View::load('admin/my_tpl', ['setting' =>$setting, 'list' => $list]);
    }
}