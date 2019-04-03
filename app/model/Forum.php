<?php
namespace Model;

use Iam\Db;
use Iam\Page;
use think\Model;
use app\Setting as ASetting;

class Forum extends Model
{

    public function getMiniContextAttr($val, $data)
    {
        // if (!empty($is_html)) {
        //     $info['title'] = htmlspecialchars($info['title']);
        //     $info['context'] = htmlspecialchars($info['context']);
        //     $info['context'] = str_replace(chr(13).chr(10), '<br>', $info['context']);
        //     $info['context'] = str_replace(chr(32), '&nbsp;', $info['context']);
        // }
        $data['context'] = self::ubbFilter($data['context']);
        $data['strip_tags_context'] = str_replace('&nbsp;', chr(32), $data['context']);
        $data['strip_tags_context'] = strip_tags($data['strip_tags_context']);
        $data['strip_tags_context'] = preg_replace('/\s+/', ' ', $data['strip_tags_context']);
        return mb_substr($data['strip_tags_context'], 0, 100);
    }


    public function getImgListAttr($val, $data)
    {
        return $this->setViewFiles($data['img_data']);
    }

    public function getFileListAttr($val, $data)
    {
        return $this->setViewFiles($data['file_data']);
    }

    public function getMarkBodyAttr($val, $data)
    {
        $mark_body = ForumMarkBody::where('forum_id', $data['id'])->column('mark_id');
        if (!empty($mark_body)) {
            return ForumMark::where('status', 1)->all($mark_body)->toArray();
        }
        return [];
    }

    private static function ubbFilter($text)
    {
        // $text = '[read_login]内容-登录可见[/read_login]
        // [read_reply]内容-回复可见[/read_reply]
        // [read_buy_10]内容-已购买可见够买可见（一篇帖子最多只能有一个内容够买，多个够买以第一个为基准）[/read_buy_10][img_0]';

        $text = preg_replace_callback('/\[(read_login|read_reply|read_buy_(\d+))\](.*?)\[\/(read_login|read_reply|read_buy_(\2))\]/', function($matches) {
            // print_r($matches);
            return $matches[3];
        }, $text);
        $text = preg_replace_callback('/\[img_\d+\]/', function() {
            return;
        }, $text);
        return $text;
    }

    /**
     * 转换地址
     */
    public function setViewImages($context)
    {
        // $context = $this->context;
        if (!empty($this->img_data)) {
            $img_arr = explode(',', $this->img_data);
            foreach ($img_arr as $key => $value) {
                $file = File::get($value);
                $context = str_replace("[img_{$key}]", "<img src=\"{$file['path']}\" alt=\"{$file['name']}\">",$context);
            }
        }
        return $context;
    }

    /**
     * 转换地址
     */
    public function setViewFiles($file_data)
    {
        $file_list = [];
        if (!empty($file_data)) {
            $file_arr = explode(',', $file_data);
            foreach ($file_arr as $key => $value) {
                $file = File::get($value);
                $file['format_size'] = byteFormat($file['size']);
                $file_list[] = $file;
            }
        }
        return $file_list;
    }

    public function getAuthorAttr($val, $data)
    {
        return User::getAuthor($data['user_id']);
    }

    public function getClassInfoAttr($val, $data)
    {
        return Category::field('title')->get($data['class_id']);
    }

    /**
     * 模糊搜索
     * @param string $keyword 要查询的关键词
     */
    public static function search($keyword = '')
    {
        $forum = self::where('1', '1');
        if ($keyword !== '') {
            $forum->where(function($query) use($keyword) {
                $query->whereOr('title', 'like', '%' . $keyword . '%');
                // 需要手动开启正文搜索（很消耗性能）
                if (false) {
                    $query->whereOr('context', 'like', '%' . $keyword . '%');
                }
            });
        }
        $forum->order('id', 'desc');
        return $forum->paginate(ASetting::get('pagesize'), false, [
            'query' => ['keyword' => $keyword]
        ]);
    }

    /**
     * 获取列表数据
     * @param string|array  $class_id 栏目id，字符串用','分隔
     * @param string|array  $user_id 会员id，字符串用','分隔
     * @param string        $type 查询类型，1最新，2动态, 3热度，4精华
     * @param string        $status 0正常 1审核中，9999回收站
     * @param string        $order asc正序 desc倒序
     */
    public static function getList($class_id = '', $user_id = '', $type = 1, $status = 0, $order = 'desc', $toArray = 0, $pagesize = 10)
    {
        $forum = self::where('1', '1');
        if (!empty($class_id)) {
            if (gettype($class_id) == 'string') {
                $class_id = explode(',', $class_id);
            }
            $forum->where('class_id', 'in', $class_id);
        }

        if ($user_id !== '') {
            if (gettype($user_id) == 'string') {
                $user_id = explode(',', $user_id);
            }
            $forum->where('user_id', 'in', $user_id);
        }

        // 排序
        $order = strtolower($order);

        if ($order != 'asc') {
            $order = 'desc';
        }

        if ($status == 9999) {
            $forum->where('status', 9999);
        } elseif ($status == 1) {
            $forum->where('status', 1);
        } else {
            $forum->where('status', 0);
        }

        if ($type == 2) {
            $forum->order('read_count', $order);
        } else {
            $forum->order('id', $order);
        }
        $list = $forum->paginate($pagesize);
        $list->append(['author', 'mini_context', 'img_list', 'file_list']);

        if ($toArray == 1) {
            return $list->toArray();
        }
        return $list;
    }

    /**
     * 置顶/取消置顶
     * @param string|int $value 设置值
     * @return boolean 成功或者失败
     */
    public function setTop($value = '')
    {
        if ($value != '') {
            $this->is_top = $value;
        } else {
            $this->is_top = $this->is_top == 0 ? 1 : 0;
        }
        return $this->save();
    }

    /**
     * 加精/取消加精
     * @param string|int $value 设置值
     * @return boolean 成功或者失败
     */
    public function setCream($value = '')
    {
        if ($value != '') {
            $this->is_cream = $value;
        } else {
            $this->is_cream = $this->is_cream == 0 ? 1 : 0;
        }
        return $this->save();
    }
}
