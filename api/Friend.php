<?php
namespace api;

use Model\Friend as FriendModel;

class Friend extends \api\Api
{
    
    /**
     * 获取粉丝列表
     */
    public function list($user_id = '', $type = 'fans' /** fans|care */, $page = 1, $pagesize = '')
    {
        $friend = FriendModel::getList($user_id, $type /** fans|care */, $page, $pagesize);
        // $this->message('');
        return $this->data($friend);
    }

    /**
     * 关注数
     */
    public function careCount($user_id = '')
    {
        $count = FriendModel::getCareCount($user_id);
        return $this->data($count);
    }

    /**
     * 粉丝数
     */
    public function fansCount($user_id = '')
    {
        $count = FriendModel::getFansCount($user_id);
        return $this->data($count);
    }

    /**
     * A是否关注B
     */
    public function isCare($user_id = '', $care_user_id = '')
    {
        $isCare = FriendModel::isCare($user_id, $care_user_id);
        return $this->data($isCare);
    }
}
