<?php
namespace App;

use Iam\Db;
use Iam\FileUpload;

class File extends Common
{
    private $options = [
        'upload' => [
            'is_save_db' => 1
        ]
    ];
    public function upload($user_id = '', $path = '', $size = 20480000, $allow_type = 'jpeg,jpg,gif,png,rar,zip', $file_name = '', $is_rand_name = true, $input_name = '', $is_save_db = 1)
    {
        $options = [
            'user_id' => $user_id,
            'path' => $path,
            'size' => $size,
            'allow_type' => $allow_type,
            'file_name' => $file_name,
            'is_rand_name' => $is_rand_name,
            'input_name' => $input_name,
            'is_save_db' => $is_save_db
        ];
        $path = $options['path'];
        $up = new FileUpload();
        //设置属性（上传的位置、大小、类型、设置文件名是否要随机生成）
        $up->set("path", ROOT_PATH . $options['path']);
        $up->set("maxsize", $options['size']); //kb
        //可以是"doc"、"docx"、"xls"、"xlsx"、"csv"和"txt"等文件，注意设置其文件大小
        $up->set("allowtype", explode(',', $options['allow_type']));
        $up->set("israndname", $options['is_rand_name']);//true:由系统命名；false：保留原文件名
        if (empty($options['user_id'])) {
            $options['user_id'] = $this->user['id'];
        }
        //使用对象中的upload方法，上传文件，方法需要传一个上传表单的名字name：pic
        //如果成功返回true，失败返回false

        if (!isset($_FILES[$options['input_name']])) {
            return ['err' => 1, 'msg' => '文件上传失败[1]' . $options['input_name']];
        }

        if($up->upload($options['input_name'])) {
            //获取上传成功后文件名字
            $file_name = $up->getFileName();
            $file_path = $path . '/' . $file_name;
            $file = $_FILES[$options['input_name']];
            $size = $file['size'];
            $mine = $file['type'];
            $id = 0;
            if (!empty($options['is_save_db'])) {
                $id = Db::table('file')->add([
                    'user_id' => $options['user_id'],
                    'name' => !empty($options['file_name']) ? $options['file_name'] : $file['name'],
                    'memo' => !empty($options['file_memo']) ? $options['file_memo'] : '',
                    'path' => $file_path,
                    'size' => $size,
                    'mine' => $mine
                ]);
            }
            $name = explode('.', $file_name);
            $ext = end($name);
            return ['id' => $id, 'ext' => $ext, 'mine' => $mine, 'size' => $size, 'path' => $file_path];
        } else {
            return ['err' => 1, 'msg' => $up->getErrorMsg()];
        }
    }
}
