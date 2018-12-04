<?php
namespace App;

use app\common\IamVersion;

class CheckUpdate extends Common
{
    public function getVersion()
    {
        IamVersion::$version;
    }

    public function checkVersion()
    {
        $res = http('http://ianmi.com/update.php?version=' . IamVersion::$version, 'POST');
        $res = json_decode($res);
    }
}
