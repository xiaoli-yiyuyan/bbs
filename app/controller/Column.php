<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Model\File;
use Model\Category;

class Column extends Common
{
    public function info($options)
    {
        if (!$info = Category::info($options['id'])) {
            return ['err' => 1, 'msg' => '你要查看的栏目不存在！'];
        }
        $info['is_admin'] = $this->isAdmin($this->user['id'], $info['id']);
        return $info;
    }

    public function list()
    {
        $list = Category::getList();
        return $list;
    }

    public function add($options/*photo, title, ?file_id*/)
    {
        if (empty($options['title'])) {
            return ['err' => 1, 'msg' => '添加失败，标题不能为空'];
        }
        $data = [
            'photo' => $options['photo'],
            'title' => $options['title']
        ];
        if (!empty($options['file_id'])) {
            if (Db::table('file')->where([
                'id' => $options['file_id'],
                'path' => $options['photo']
            ])->update(['status' => 1])) {
                $data['file_id'] = $options['file_id'];
            }
        }
        if (!$id = Db::table('category')->add($data)) {
            return ['err' => 2, 'msg' => '添加失败'];
        }
        return ['id' => $id];
    }

    public function save($options/*id, photo, title, ?file_id*/)
    {
        if (!$info = Db::table('category')->find($options['id'])) {
            return ['err' => 1, 'msg' => '要修改的栏目未找到'];
        }
        if (empty($options['title'])) {
            return ['err' => 2, 'msg' => '修改失败，标题不能为空'];
        }
        
        $data = [
            'photo' => $options['photo'],
            'title' => $options['title'],
            'bm_id' => $options['bm_id'],
            'user_add' => $options['user_add'],
            'is_html' => $options['is_html'],
            'is_ubb' => $options['is_ubb'],
        ];
        if (!empty($options['file_id'])) {
            if (Db::table('file')->where([
                'id' => $options['file_id'],
                'path' => $options['photo']
            ])->update(['status' => 1])) {
                $data['file_id'] = $options['file_id'];
                if (empty($info['file_id']) && $info['file_id'] != $options['file_id']) {
                    File::removeFile($info['file_id']);
                }
            }
        }

        if (!Db::table('category')->where([
            'id' => $options['id']
        ])->update($data)) {
            return ['err' => 3, 'msg' => '修改失败'];
        }
        return ['id' => $options['id']];
    }
}