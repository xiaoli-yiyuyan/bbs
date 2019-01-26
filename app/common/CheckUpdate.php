<?php
namespace app\common;

use app\common\IamVersion;
use Iam\Response;

class CheckUpdate
{
    public static $ianmi = 'http://127.0.0.1:819';

    public function getVersion()
    {
        //IamVersion::$version;
    }

    public static function checkVersion()
    {
        $res = http(self::$ianmi . '/update.php', ['version' => IamVersion::$version]);
        $res = json_decode($res, true);
        return $res;
    }

    public static function update()
    {
        $res = http(self::$ianmi . '/update.php', ['action' => 'update', 'version' => IamVersion::$version]);
        $res = json_decode($res, true);
        $file = downloadFile(self::$ianmi . '/' . $res['path'], basename($res['path']), './update');
        unzip($file, './');
        return ['msg' => '已升级至版本 ' . $res['version']];
    }
}
