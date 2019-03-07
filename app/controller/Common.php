<?php
namespace App;

use Iam\View;
use app\common\CommonPublic;
use app\Setting;

class Common extends CommonPublic
{
    
    public function __construct()
    {
        $theme = Setting::get('theme');
        View::setConfig([
            'PATH' => $theme
        ]);
        parent::__construct();
    }
}
