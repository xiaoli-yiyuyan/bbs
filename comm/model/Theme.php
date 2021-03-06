<?php
namespace Model;

use think\Db;
use think\Model;
use comm\Setting as ASetting;

class Theme extends Model
{
    protected $type = [
        'logo_path' => 'array'
    ];

    /**
     * 修改主题状态
     * @param int $id 设置为使用的主题id
     * return array;
     */
    public static function setStatus($id)
    {

        $res = self::where('status', 1)->setField('status', 0);
        // if(!$res){
        //     return ['err' => 1, 'msg' => '数据修改失败'];
        // }
        $result = self::where(['id' => $id])->setField('status', 1);
        if(!$result){
            return ['err' => 1, 'msg' => '设置失败'];
        }
        
        $field = self::get($id);
        $themeName = $field->getData('name');
        ASetting::set(['theme' => $themeName, 'component'=>$themeName]);
        return ['err' => 0 , 'msg' => '设置成功'];
 
    }
}