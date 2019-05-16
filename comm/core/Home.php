<?php
namespace comm\core;

use Iam\View;
use comm\Setting;

class Home extends CommonPublic
{
    public function __construct()
    {
        $theme = Setting::get('theme');
        View::setConfig([
            'PATH' => $theme.'/template'
        ]);
        parent::__construct();
    }
}
