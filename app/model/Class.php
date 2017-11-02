<?php
namespace Model;

use Iam\Db;

class Class extends Common
{
    public function info($classid)
    {
        return Db::table('class')->find($classid);
    }
}
