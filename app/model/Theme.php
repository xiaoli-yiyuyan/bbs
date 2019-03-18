<?php
namespace Model;

use think\Db;
use think\Model;
use app\Setting as ASetting;

class Theme extends Model
{
    /**
     * 修改主题状态
     * @param int $id 设置为使用的主题id
     * return array;
     */
    public static function setStatus($id)
    {

        $res = slef::where('id', 'neq', $id)->setField('status', 0);
        if(!$res){
            return ['err' => 1, 'msg' => '数据修改失败'];
        }
        $result = slef::where(['id' => $id])->setField('status', 1);
        if(!$result){
            return ['err' => 1, 'msg' => '设置失败'];
        }
        
        $field = slef::get($id);
        $themeName = $field->getData('name');
        ASetting::set(['theme' => $themeName, 'component'=>$themeName]);
        return ['err' => 0 , 'msg' => '设置成功'];
 
    }
}