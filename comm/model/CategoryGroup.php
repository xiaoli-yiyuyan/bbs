<?php
namespace Model;

use Iam\Db;

class CategoryGroup extends Common
{
    /**
     * 获取组件目录
     */
    public static function getGroup($parent_id = 0)
    {
        if (empty($parent_id)) {
            $parent_id = 0;
        }
        return DB::table('category_group')->where(['parent_id' => $parent_id])->select();
    }
}
