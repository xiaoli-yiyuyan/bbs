<?php
namespace App;

use app\common\IamVersion;

class CheckUpdate extends Common
{
    private $ianmi = 'http://update.ianmi.com';

    public function getVersion()
    {
        //IamVersion::$version;
    }

    public function checkVersion()
    {
        $res = http($this->ianmi . '/new?version=' . IamVersion::$version, 'POST');
        $res = json_decode($res);
        return $res;
    }

    public function update()
    {
        $res = http($this->ianmi . '/update?version=' . IamVersion::$version, 'POST');
        $res = json_decode($res);
        $res = [
            [
                'id' => '8',
                'version' => '1.2.1',
                'update' => ['update_1.2.1.zip']
            ],
            [
                'id' => '7',
                'version' => '1.2.1',
                'update' => ['update_1.2.1.zip']
            ],
            [
                'id' => '6',
                'version' => '1.2.1',
                'update' => ['update_1.2.1.zip']
            ],
            [
                'id' => '5',
                'version' => '1.2.1',
                'update' => ['update_1.2.1.zip']
            ]
        ];
        $update = end($res);
        $file = downloadFile($this->ianmi . '/download/update_1.2.1.zip', $update['version'], './update');
        unzip($file, './');
        return ['msg' => '已升级至版本 v' . $update['version']];
    }
}
