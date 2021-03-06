<?php
namespace app;

use think\Db;
use Iam\Url;
use Iam\View;
use Iam\Listen;
use Iam\Router;

class Index extends \comm\core\Home
{
    public function index()
    {
        // $mark = Db::table('novel_mark')->select();
        // $new_list = Db::table('novel')->order('`id` DESC')->select(0,10);
        // foreach ($new_list as &$item) {
        //     $item['mark'] = $this->getMarkTitle($item['id']);
        //  }
        // Url::redirect('/chat/room/?id=2');
        View::load('index');
    }

    public function getMarkTitle($novelid)
    {
    //    print_r($novelid);
        $mark = Db::query('SELECT * FROM `novel_mark` WHERE `id` IN(SELECT `markid` FROM `novel_mark_body` WHERE `novelid`=?)', [$novelid]);
        return $mark;
    }

    public function tes($param = '',$s) {
        print_r($param);
        $ref = new \ReflectionClass('App\Index');
        print_r((new \ReflectionMethod('App\Index', 'tes'))->getParameters());
        $methods = $ref->getMethods();
    }
    
    public function getTheme()
    {
        echo Setting::get('theme');
    }
}
