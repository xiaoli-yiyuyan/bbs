<?php
namespace app\admin;

use Iam\View;
use Iam\Page;
use Iam\Response;
use Model\Forum as ForumModel;
use comm\Setting;

class Forum extends \comm\core\Home
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

    /**
     * 待审核
     */
    public function auto($status = 1)
    {
        $list = source('/Model/Forum/getList', ['status' => $status]);

        View::load('admin/forum_auto', [
            'list' => $list
        ]);
    }

    /**
     * 恢复帖子
     */
    public function pass($id, $status)
    {
        if (!ForumModel::where(['id' => $id])->update(['status' => $status])) {
            return Response::json(['err' => 1, 'msg' => '操作失败', 'sql' => ForumModel::getLastSql()]);
        }
        return Response::json(['id' => $id, 'msg' => '操作成功']);
    }
}
