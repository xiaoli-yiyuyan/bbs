<?php
namespace app\admin;

use Iam\View;
use Iam\Page;
use Model\ForumMark as MForumMark;
use comm\Setting;

class ForumMark extends \comm\core\Home
{
    public function __construct()
    {
        parent::__construct();
        if ($this->user['id'] != 1) {
            Page::error('仅限管理员访问');
            exit();
        }
        View::setConfig([
            'PATH' => 'system'
        ]);
    }

    public function index() {

        $list = MForumMark::paginate(Setting::get('pagesize'), false);
        View::load('/admin/forum_mark/index', [
            'list' => $list
        ]);
    }

    public function passList() {

        $list = MForumMark::where('status', '<>', 1)->paginate(Setting::get('pagesize'), false);
        View::load('/admin/forum_mark/pass_list', [
            'list' => $list
        ]);
    }
}
