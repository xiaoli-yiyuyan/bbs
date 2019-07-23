<?php
namespace Model;

use think\Model;
use Iam\Config;

class Base extends Model
{

    /**
     * SAAS设置站点主人
     * 方式一：全局默认设置
     */
    public function initialize()
    {
        $site_id = Config::get('site');
        if (!empty($site_id)) {
            $this->where('site_id', $site_id);
        }
    }

    /**
     * SAAS设置站点主人
     * 方式二：主动设置
     */
    public function site($site_id = 0)
    {
        if (!empty($site_id) || !empty($site_id = Config::get('site'))) {
            return $this->where('site_id', $site_id);
        }
        
        return $this;
    }
}
