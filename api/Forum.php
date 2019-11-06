<?php
namespace api;

use Model\Forum as ForumModel;
use Model\ForumBuy;
use Model\ForumMark;
use Model\ForumReply;
use Model\ForumMarkBody;
use Model\User;
use Model\Category;
use comm\core\Ubb;
use Model\File;
use comm\Setting;
use Iam\Image;
use think\Db;

class Forum extends \api\Api
{
    private $addForumCoin = 0;
    private $addReplyCoin = 0;
    /**
     * 获取文章类表
     * @param int $sort 0 默认。ID倒序，1 ID顺序，2 动态顺序
     */
    public function list($class_id = '', $user_id = '', $page = 1, $pagesize = 10, $sort = 1, $order = 1, $type = '' /**1,2,3 */)
    {
        $forum = ForumModel::where('status', 0);

        // 栏目类表
        $class_id = parseParam($class_id);
        if (!empty($class_id)) {
            $forum->where('class_id', 'IN', $class_id);
        }

        // 用户
        $user_id = parseParam($user_id);
        if (!empty($user_id)) {
            $forum->where('user_id', 'IN', $user_id);
        }

        /**
         * 类型处理
         */
        $type = parseParam($type);
        // 纯文章
        if (in_array(1, $type)) {
            $forum->where('img_data', '');
            $forum->where('file_data', '');
        }

        // 带标签
        if (in_array(2, $type)) {
            $forum->where('id', 'IN', function($query) {
                $query->table('forum_mark_body')->field('forum_id');
            });
        }

        // 带图片
        if (in_array(3, $type)) {
            $forum->where('img_data', '<>', '');
        }

        // 带文件
        if (in_array(4, $type)) {
            $forum->where('file_data', '<>', '');
        }

        $orderSort = [];
        /**
         * 排序
         */
        if ($order == 1) {
            // 动态
            $orderSort[] = 'active_time';
        } else {
            // 顺序
            $orderSort[] = 'id';
        }

        if ($sort == 1) {
            $orderSort[] = 'DESC';
        } else {
            $orderSort[] = 'ASC';
        }
        
        $forum->order(['is_top' =>  'DESC']);
        $forum->order($orderSort[0], $orderSort[1]);
        $list = $forum->paginate($pagesize, false, ['page' => $page]);
        $list->append(['author', 'mini_context', 'img_list', 'file_list']);
        return $this->data($list);
    }

    /**
     * 内容
     */
    public function view($id)
    {
        if (!$forum = ForumModel::get($id)) {
            $this->error(1, '要查看的内容不存在！');
            return;
        }

        if (!$forum_user = $forum->author) {
            $this->error(2, '楼主信息异常，暂时无法查看该帖子！');
            return;
        }

        if (!$class_info = $forum->class_info) {
            $this->error(3, '帖子发表栏目不存在，暂时无法查看该帖子！');
            return;
        }

        $user_id = ($user = source('/api/User/info')) ? $user['id'] : 0;
        $forum['is_admin'] = $class_info->isBm($user_id);
        if ($forum->status == 9999 && !$forum['is_admin']) {
            $this->error(4, '要查看的内容不存在！');
            return;
        }
        
        $forum['img_list'] = $this->setViewFiles($forum['img_data']);
        $forum['file_list'] = $this->setViewFiles($forum['file_data']);

        
        // 启用HTML过滤
        if ($class_info->is_html) {
            $forum['title'] = htmlspecialchars($forum['title']);
            $forum['context'] = htmlspecialchars($forum['context']);
            $forum['context'] = str_replace(chr(13).chr(10), '<br>', $forum['context']);
            $forum['context'] = str_replace(chr(32), '&nbsp;', $forum['context']);
        }

        // 启用UBB语法
        if ($class_info->is_ubb) {
            $forum['context'] = $this->rule($forum['context'], $forum['id'], $forum['user_id']);
            $forum['context'] = Ubb::face($forum['context']);
            $forum['context'] = $forum->setViewImages($forum['context']);
        }
        // $forum['strip_tags_context'] = str_replace('&nbsp;', chr(32), $forum['context']);
        // $forum['strip_tags_context'] = strip_tags($forum['strip_tags_context']);
        // $forum['strip_tags_context'] = preg_replace('/\s+/', ' ', $forum['strip_tags_context']);
        // $forum['keywords'] = getKeywords($forum['title'], $forum['strip_tags_context']);

        // 阅读量+1
        ForumModel::where('id', $forum->id)->setInc('read_count');

        $forum = $forum->append(['mark_body', 'author', 'class_info']);

        return $this->data($forum);
    }

    /**
     * 论坛UBB
     */
    private function rule($content, $id, $user_id)
    {
        $user = source('/api/User/info');
        $content = preg_replace_callback('/\[read_login\](.*?)\[\/read_login\]/', function($matches) use($user) {
            if ($user) {
                return $matches[1];
            }
            return Ubb::getTips('此内容<span class="_sys_ubb_login">登录</span>可见', 'read_login');
        }, $content);
        
        $content = preg_replace_callback('/\[read_reply\](.*?)\[\/read_reply\]/', function($matches) use($user, $user_id, $id) {
            $reply = ForumReply::get([
                'user_id' => $user['id'],
                'forum_id' => $id
            ]);
            if ($user && $user_id == $user['id'] || $reply) {
                return $matches[1];
            }
            return Ubb::getTips('此内容 <span class="_sys_ubb_reply" data-id="' . $id . '">评论</span> 可见', 'read_reply');
        }, $content);

        $content = preg_replace_callback('/\[read_buy_(\d+)\](.*?)\[\/read_buy_\1\]/', function($matches) use($user, $id, $user_id) {
            if ($user && $user_id == $user['id'] || $this->isBuy($id)) {
                return $matches[2];
            }
            return Ubb::getTips('此内容需要花费 <span>' . $matches[1] . '</span> 金币 <span class="_sys_ubb_buy" data-id="' . $id . '">购买</span>', 'read_buy');
        }, $content);

        $content = preg_replace_callback('/\[read_vip_([12345])\](.*?)\[\/read_vip_\1\]/', function($matches) use($user, $id, $user_id) {
            if ($user) {
                $dateTime = new \DateTime($user['vip_time']);
                if ($matches[1] <= $user['vip_level'] && $dateTime->format('U') >= time()) {
                    return $matches[2];
                }
            }
            return Ubb::getTips('此内容仅限 <span class="_sys_ubb_vip">VIP ' . $matches[1] . '</span> 才可查看', 'read_vip');
        }, $content);
        return $content;
    }

    /**
     * 购买内容
     */
    public function forumBuy($id)
    {
        if (!$user = source('/api/User/info')) {
            $this->error(1, '会员未登录');
            return;
        }

        if (!$forum = ForumModel::get($id)) {
            $this->error(1, '购买失败！');
            return;
        }
        $content = $forum['context'];
        $content = preg_match('/\[read_buy_(\d+)\](.*?)\[\/read_buy_\1\]/', $content, $matches);
        if (empty($matches)) {
            $this->error(1, '购买失败！');
            return;
        }
        if ($matches <= 0) {
            $this->error(2, '购买失败！');
            return;
        }
        if ($buy = ForumBuy::get(['forum_id' => $id, 'user_id' => $user['id']])) {
            $this->error(3, '购买失败！');
            return;
        }

        if (!User::changeCoin($user['id'], -$matches[1])) {
            $this->error(4, '购买失败！余额不足');
            return;
        }

        ForumBuy::create([
            'forum_id' => $id,
            'user_id' => $user['id'],
            'coin' => $matches[1]
        ]);
        
        $this->message('购买成功！');
        return $id;
    }

    /**
     * 判断是否已经购买
     */
    private function isBuy($id)
    {
        $user = source('/api/User/info');
        return ForumBuy::get(['forum_id' => $id, 'user_id' => $user['id']]);
    }

    /**
     * 设置图片
     */
    private function setViewImages($context, $img_data)
    {
        if (!empty($img_data)) {
            $img_arr = explode(',', $img_data);
            foreach ($img_arr as $key => $value) {
                $file = File::get($value);
                $context = str_replace("[img_{$value}]", "<img src=\"{$file['path']}\" alt=\"{$file['name']}\">",$context);
            }
        }
        return $context;
    }

    /**
     * 设置文件
     */
    private function setViewFiles($file_data)
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

    /**
     * 发布帖子
     */
    public function add($class_id = '', $title = '', $context = '', $img_data = '', $file_data = '', $mark_body = '')
    {

        if (!$this->user = source('/api/User/info')) {
            $this->error(1, '会员未登录');
            return;
        }

        if (!$class_info = Category::get($class_id)) {
            $this->error(2, '帖子发表栏目不存在！');
            return;
        }

        if (!$class_info['user_add'] && !$class_info->isBm($user['id'])) {
            $this->error(3, '该栏目禁止发帖');
            return;
        }

        if (!empty($title) && mb_strlen($title) < 6) {
            $this->error(4, '帖子标题不能小于6个字！');
            return;
        }

        if (empty($context)) {
            $this->error(5, '帖子内容不能为空！');
            return;

        }

        if (!empty($img_data)) {
            $img_arr = explode(',', $img_data);
            foreach ($img_arr as $item) {
                if (!File::setUserFile($this->user['id'], $item)) {
                    $this->error(6, '上传的图片不存在，或者已经被发布。');
                    return;
                }
                
                if (Setting::get('forum_water_mark_status') == '1' && $file = File::get($item)) {
                    $image = new Image;
                    $image->imageMark($file['path'], Setting::get('forum_water_mark_path'));
                }

            }
        }

        if (!empty($file_data)) {
            $file_arr = explode(',', $file_data);
            foreach ($file_arr as $item) {
                if (!File::setUserFile($this->user['id'], $item)) {
                    $this->error(7, '上传的文件不存在，或者已经被发布。');
                    return;
                }
            }
        }

        
        $data = [
            'title' => $title,
            'context' => $context,
            'user_id' => $this->user['id'],
            'class_id' => $class_id,
            'img_data' => $img_data,
            'file_data' => $file_data,
            'update_time' => now(),
            'active_time' => now(),
        ];

        if ($class_info['is_auto'] == 1) {
            $data['status'] = 1;
        }

        if (!$id = ForumModel::create($data)) {
            $this->error(8, '发布失败');
            return;
        }
        

        if (!empty($mark_body)) {
            $mark_arr = explode(',', $mark_body);
            foreach ($mark_arr as $item) {
                if (ForumMark::get($item)) {
                    ForumMarkBody::create([
                        'forum_id' => $id->id,
                        'mark_id' => $item
                    ]);
                }
            }
        }

        User::changeCoin($this->user['id'], $this->addForumCoin);
        $this->message('发布成功');
        return $this->data(['id' => $id->id, 'reward_coin' => $this->addForumCoin]);
    }

    /**
     * 帖子编辑逻辑
     */
    public function save($id = '', $class_id = '', $title = '', $context = '', $img_data = '', $file_data = '', $mark_body = '')
    {
        
        if (!$this->user = source('/api/User/info')) {
            $this->error(1, '会员未登录');
            return;
        }

        if (!$forum = ForumModel::get($id)) {
            $this->error(2, '抱歉，你要操作的帖子不存在！');
            return;
        }
        
        if (!empty($class_id) && !$class_info = Category::get($class_id)) {
            $this->error(3, '帖子发表栏目不存在！');
            return;
        }
        
        $isAdmin = $class_info->isBm($this->user['id']);

        if(!$class_info['user_add'] && !$isAdmin){
            $this->error(4, '移动到的栏目仅VIP方能操作');
            return;
        }

        if ($forum['user_id'] != $this->user['id'] && !$isAdmin) {
            $this->error(5, '你无权进行此操作！');
            return;
        }

        if (!empty($title) && mb_strlen($title) < 6) {
            $this->error(6, '帖子标题不能小于6个字！');
            return;
        }

        if (empty($context)) {
            $this->error(7, '帖子内容不能为空！');
            return;
        }

        // 检索图片
        $info_img = [];
        $img_arr = [];
        if (!empty($forum['img_data'])) {
            $info_img = explode(',', $forum['img_data']);
        }
        if (!empty($img_data)) {
            $img_arr = explode(',', $img_data);
        }
        $remove_img = array_diff($info_img, $img_arr);
        $add_img = array_diff($img_arr, $info_img);

        // 检索文件
        $info_file = [];
        $file_arr = [];
        if (!empty($forum['file_data'])) {
            $info_file = explode(',', $forum['file_data']);
        }
        if (!empty($file_data)) {
            $file_arr = explode(',', $file_data);
        }
        $remove_file = array_diff($info_file, $file_arr);
        $add_file = array_diff($file_arr, $info_file);

        Db::startTrans();
        if (!empty($remove_img)) {
            foreach ($remove_img as $item) {
                File::removeFile($item);
            }
        }
        if (!empty($add_img)) {
            foreach ($add_img as $item) {
                if (!File::setUserFile($this->user['id'], $item)) {
                    Db::rollback();
                    $this->error(8, '上传的图片不存在，或者已经被发布。');
                    return;
                }
                
                if (Setting::get('forum_water_mark_status') == '1' && $file = File::get($item)) {
                    $image = new Image;
                    $image->imageMark($file['path'], Setting::get('forum_water_mark_path'));
                }

            }
        }

        if (!empty($remove_file)) {
            foreach ($remove_file as $item) {
                File::removeFile($item);
            }
        }
        if (!empty($add_file)) {
            foreach ($add_file as $item) {
                if (!File::setUserFile($this->user['id'], $item)) {
                    Db::rollback();
                    $this->error(9, '上传的文件不存在，或者已经被发布。');
                    return;
                }
            }
        }

        $data = [
            'title' => $title,
            'context' => $context,
            'class_id' => $class_id,
            'img_data' => $img_data,
            'file_data' => $file_data,
            'log' => $forum['log'] . '<br>' .$this->user['id'] . ' 修改于: ' . now(),
            'update_time' => now()
        ];
        // print_r($data);
        // die();

        if ($class_info['is_auto'] == 1) {
            $data['status'] = 1;
        }
        
        if (!$result = ForumModel::where(['id' => $forum['id']])->update($data)) {
            Db::rollback();
            $this->error(10, '修改失败');
            return;
        }
        
        Db::commit();
        $this->message('修改成功');
        return $this->data(['id' => $id]);
    }

    // 回收状态码
    private $rec_code = 9999;

    /**
     * 放进回收站
     */
    public function remove($id = '')
    {
        if (!$user = source('/api/User/info')) {
            $this->error(1, '会员未登录');
            return;
        }

        if (!$info = ForumModel::get($id)) {
            $this->error(2, '抱歉，你要操作的帖子不存在！');
            return;
        }
        
        $isAdmin = false;
        if ($category = Category::get($info->class_id)) {
            $isAdmin = $category->isBm($user['id']);
        }

        if ($user['id'] != $info->user_id || !$isAdmin) {
            $this->error(3, '权限不足');
            return;
        }

        $info->status = $this->rec_code;
        $info->save();
        ForumReply::where('forum_id', $id)->update(['status' => $this->rec_code]);
        $this->message('操作成功');
        return ['class_id' => $info->class_id];
    }

}
