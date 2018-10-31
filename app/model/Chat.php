<?php
namespace Model;

use Iam\Db;
use think\Model;

class Chat extends Model
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

        return self::create([
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
        return self::field(['id', 'userid', 'touserid', 'content', 'addtime'])->where(['classid' => $classid])->order('id DESC')->limit($limit[0],$limit[1])->select();//Db::table('chat')->field(['id', 'userid', 'touserid', 'content', 'addtime'])->where(['classid' => $classid])->order('`id` DESC')->select($limit[0],$limit[1]);
    }

    public function listIdNew($classid, $lastid)
    {
        return self::field(['id', 'userid', 'touserid', 'content', 'addtime'])->where('classid', $classid)->where('id', '>', $lastid)->order('id DESC')->select()->toArray();
    }
}
