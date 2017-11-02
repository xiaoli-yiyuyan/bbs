<?php
namespace App;

use Iam\Db;
use Iam\View;
use Iam\Listen;

class Index extends Common
{
    public function index()
    {
        $mark = Db::table('novel_mark')->select();
        $new_list = Db::table('novel')->order('`id` DESC')->select(0,10);
        foreach ($new_list as &$item) {
            $item['mark'] = $this->getMarkTitle($item['id']);
         }
        // print_r($new_list);
    	View::load('index',['mark' => $mark, 'new_list' => $new_list]);
    }

    public function getMarkTitle($novelid)
    {
    //    print_r($novelid);
        $mark = Db::query('SELECT * FROM `novel_mark` WHERE `id` IN(SELECT `markid` FROM `novel_mark_body` WHERE `novelid`=?)', [$novelid]);
        return $mark;
    }
}
