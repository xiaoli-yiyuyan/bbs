<?php
namespace Model;

use Iam\Db;
use Iam\Page;
use think\Model;

class File extends Model
{
    public static function isUserFile($user_id, $file_id)
    {
        return Db::table('file')->where(['user_id' => $user_id, 'id' => $file_id])->find();
    }

    public static function setUserFile($user_id, $file_id)
    {
        $where = ['user_id' => $user_id, 'id' => $file_id, 'status' => 0];

        if (!$file = Db::table('file')->where($where)->find()) {
            return;
        }
        return Db::table('file')->where(['id' => $file_id])->update(['status' => 1]);
    }

    public static function removeFile($file_id)
    {
        return self::where(['id' => $file_id])->update(['status' => 0]);
    }
}
