<?php
namespace Model;

use Iam\Db;

class Category extends Common
{
    public function info($classid)
    {
        return Db::table('category')->find($classid);
    }
}
