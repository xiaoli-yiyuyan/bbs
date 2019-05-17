<?php
namespace comm\core;

use Iam\Response;

class CheckUpdate
{
    public static $ianmi = 'http://version.ianmi.com';

    public function getVersion()
    {
        //IamVersion::$version;
    }

    public static function checkVersion()
    {
        self::updateSql();
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

    /**
     * 执行更新sql语句并移除
     */
    public static function updateSql()
    {
        $sql_log_dir = './update_sql_log';
        $sql_log = scan_dir($sql_log_dir);
        if (empty($sql_log)) {
            return true;
        }
        $databaseTool = new DatabaseTool;
        foreach ($sql_log as $item) {
            $sql_file = $sql_log_dir . DS . $item;
            if (!$res = $databaseTool->restore($sql_file)) {
                return false;
            }
            unlink($sql_file);
        }
        return true;
    }
}
