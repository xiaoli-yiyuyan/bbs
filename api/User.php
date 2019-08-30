<?php
namespace api;

use \Model\User as UserModel;

class User extends \api\Api
{
    /**
     * 获取用户信息
     */
    public function info($id = '')
    {
        // 获取自己的信息
        if (empty($id)) {
            if (!$user = UserModel::get(['uuid' => token()])) {
                $this->error(1, '当前用户身份获取失败');
                return;
            }
        } else {
            if (!$user = UserModel::get($id)) {
                $this->error(1, '用户身份获取失败');
                return;
            }
            
        }
        $user = $user->hidden(['password'])->toArray();
        $this->message('身份获取成功');
        return $user;
    }

    /**
     * 获取用户列表
     */
    public function list($page = 1, $pagesize = 10, $sort = 1, $order = 1)
    {
        $user = UserModel::where(1, 1);

        $orderSort = [];
        /**
         * 排序
         */
        if ($order == 1) {
            // 动态
            $orderSort[] = 'last_time';
        } else {
            // 顺序
            $orderSort[] = 'id';
        }

        if ($sort == 1) {
            $orderSort[] = 'DESC';
        } else {
            $orderSort[] = 'ASC';
        }
        $user->order($orderSort[0], $orderSort[1]);

        $list = $user->paginate($pagesize, true, ['page' => $page]);
        $list->append(['lv', 'is_online']);
        $list->hidden(['password', 'uuid', 'email', 'create_ip', 'username', 'vip_time', 'lock_time']);
        return $list->toArray();
    }
}
