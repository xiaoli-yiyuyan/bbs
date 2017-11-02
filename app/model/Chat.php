<?php
namespace Model;

use Iam\Db;

class Chat extends Common
{
    public function add($userid, $touserid, $classid, $content)
    {
        $touserid = isset($touserid) ? $touserid : 0;
        $classid = isset($classid) ? $classid : 0;
        $content = htmlentities(trim($content));

        if (strlen($content) == 0) {
            return false;
        }
        if ($classid !=0 && !$calss = Db::table('category')->field('1')->find($classid)) {
            return false;
        }

        if ($touserid !=0 && !$calss = Db::table('user')->field('1')->find($touserid)) {
            return false;
        }

        return Db::table('chat')->add([
            'userid' => $userid,
            'touserid' => $touserid,
            'classid' => $classid,
            'content' => $content
        ]);
    }

    public function list()
    {
        return Db::table('user')->select();
    }

    public function listIdDesc($classid, $limit = [0, 20])
    {
        return Db::table('chat')->field(['id', 'userid', 'touserid', 'content', 'addtime'])->where(['classid' => $classid])->order('`id` DESC')->select($limit[0],$limit[1]);
    }

    public function listIdNew($classid, $lastid)
    {
        return Db::query('SELECT `id`,`userid`,`touserid`,`content`,`addtime` FROM `chat` WHERE `classid`=? AND `id`>? ORDER BY `id` DESC LIMIT 0,1',[$classid, $lastid]);
    }
}
