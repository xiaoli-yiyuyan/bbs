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

        $list = MForumMark::where('status', 1)->paginate(Setting::get('pagesize'), false);
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

    /**
     * 删除标签
     */
    public function remove($id) {
        if (!MForumMark::destroy($id)) {
            return Page::error('删除失败');
        }
        Page::success('删除成功');
    }

    /**
     * 操作标签状态
     */
    public function status($id, $status) {
        if (!MForumMark::where('id', $id)->update(['status' => $status])) {
            return Page::error('操作失败');
        }
        Page::success('操作成功');
    }
}
