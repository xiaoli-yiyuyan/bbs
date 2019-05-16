<?php
namespace Model;

use Iam\Db;

class NovelMark extends Common
{
    public static function getTitle($novelid)
    {
        $mark = Db::query('SELECT * FROM `novel_mark` WHERE `id` IN(SELECT `markid` FROM `novel_mark_body` WHERE `novelid`=?)', [$novelid]);
        return $mark;
    }
}
