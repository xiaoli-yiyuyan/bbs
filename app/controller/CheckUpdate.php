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
        $res = [
            'id' => '1',
            'version' => '1.2.1',
            'update' => ['update_1.2.1.zip']
        ];
        unzip($res['update'], '/');
    }
}
