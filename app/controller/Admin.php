<?php
namespace App;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Page;
use Iam\Cache;
use Iam\Request;
use Iam\Response;
use Iam\Component;
use Model\CategoryGroup;
use Model\Code;
use Model\Category;
use app\Setting;
use app\common\DatabaseTool;
use app\common\CheckUpdate;
use Model\Forum;

class Admin extends Common
{
    public function __construct()
    {
        parent::__construct();
        if ($this->user['id'] != 1) {
            Page::error('仅限管理员访问');
            exit();
        }
    }

    public function index()
    {
        $count = Db::query('SELECT COUNT(*) as num FROM `user`')[0]['num'];
        $today_count = Db::query('SELECT COUNT(*) as num FROM `user` WHERE `create_time` > CURDATE()')[0]['num'];
        $online_count = Db::query('SELECT COUNT(*) as num FROM `user` WHERE TIMESTAMPDIFF(MINUTE, last_time, NOW()) < 20')[0]['num'];
        $forum_count = Db::query('SELECT COUNT(*) as num FROM `forum`')[0]['num'];
        $forum_today_count = Db::query('SELECT COUNT(*) as num FROM `forum` WHERE `create_time` > CURDATE()')[0]['num'];
        $forum_reply_today_count = Db::query('SELECT COUNT(*) as num FROM `forum_reply` WHERE `create_time` > CURDATE()')[0]['num'];

        $new_version_res = CheckUpdate::checkVersion();
        $new_version = 'v-.-.-';
        if (!empty($new_version_res)) {
            $new_version = $new_version_res['version'];
        }

        View::load('admin/index', [
            'count'=> $count,
            'today_count'=> $today_count,
            'online_count'=> $online_count,
            'forum_count'=> $forum_count,
            'forum_today_count'=> $forum_today_count,
            'forum_reply_today_count'=> $forum_reply_today_count,
            'new_version' => $new_version
        ]);
    }

    public function sysUpdate()
    {
        return Response::json(CheckUpdate::update());
    }

    private function initComponent()
    {
        $component = new Component([
            'model' => 'default'
        ]);
        return $component;
    }

    public function page()
    {
        $namespace = Request::get('namespace', '/');
        $component = $this->initComponent();
        $namespace_list = $component->namespace($namespace);
        $component_list = $component->list($namespace);


        View::load('admin/page', [
            'namespace' => $namespace_list,
            'component' => $component_list,
            'namespace_parent' => $namespace,
            'namespace_index' => $component->namespaceIndex
        ]);
    }

    private function getTemplateTree($path = 'template', $module = 'default', $name = '.')
    {
        $tree = [
            'dir' => [],
            'file' => []
        ];
        // if(!$this->checkPathName($name)){
        //     return $tree;
        // }
        $template_root = ROOT_PATH . $path . DS . $module . DS .$name;
        if(!is_dir($template_root) || !is_readable($template_root)) {
            return $tree;
        }
        $_tree = scandir($template_root);
        foreach ($_tree as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if(is_dir($template_root . DS. $item)) {
                $tree['dir'][] = $item;
            }else {
                $tree['file'][] = $item;
            }
        }
        return $tree;
    }

    private function getFileTree($path = '.')
    {
        $tree = [
            'dir' => [],
            'file' => []
        ];
        $template_root = ROOT_PATH . $path;
        if(!is_dir($template_root) || !is_readable($template_root)) {
            return $tree;
        }
        $_tree = scandir($template_root);
        foreach ($_tree as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if(is_dir($template_root . DS. $item)) {
                $tree['dir'][] = $item;
            }else {
                $tree['file'][] = $item;
            }
        }
        return $tree;
    }

    private function checkPathName($name)
    {
        return preg_match('/^[0-9a-zA-Z\_]+$/', $name);
    }

    private function parseTree($module = 'default', $namespace)
    {
        $dir = 'template' . DS . $module;
        $cache = new Cache($dir, 'config');
        
        $tree = [
            'namespace' => [],
            'component' => []
        ];
        $_tree = $cache->get();
        $namespace = $namespace . DS;
        $_namespace = explode(DS, trim($namespace, DS));
        $namespace_index = [];
        foreach ($_namespace as $item) {
            if ($item == '') {
                continue;
            }
            if (isset($_tree[$item])) {
                $namespace_index[] = $item;
            }
            if (isset($_tree[$item]['children'])) {
                $_tree = $_tree[$item]['children'];
            } else {
                $_tree = [];
                break;
            }
        }
        if (!empty($namespace_index)) {
            $namespace = DS . implode(DS, $namespace_index) . DS;
        }
        foreach ($_tree as $key => $value) {
            if($value['type'] == 'namespace') {
                $tree['namespace'][$key] = $value;
            }else {
                $tree['component'][$key] = $value;
            }
        }
        return ['tree' => $tree, 'parent_namespace' => $namespace, 'namespace_index' => $namespace_index];
    }

    public function addNamespace()
    {
        $namespace = Request::get('namespace');
        $component = $this->initComponent();
        $component->namespace($namespace);
    	View::load('admin/add_namespace', [
            'namespace_parent' => $namespace,
            'namespace_index' => $component->namespaceIndex
        ]);
    }

    public function editNamespace()
    {
        $namespace = Request::get('namespace');
        // $name = Request::post('name');
        // $title = Request::post('title');

        // if(!$this->checkPathName($name)){
        //     return Page::error('名称错误，格式必须为数字，英文，下划线任意组合');
        // }

        $dir = 'template' . DS . 'default';
        $cache = new Cache($dir, 'config');
        $config = $cache->get();
        $namespace = $namespace . DS;
        $_namespace = explode(DS, trim($namespace, DS));
        $namespace_index = [];
        $node = $config;
        foreach ($_namespace as $item) {
            if ($item == '') {
                continue;
            }
            if (isset($node[$item])) {
                $namespace_index = $node[$item];
                $namespace_index['name'] = $item;
            }
            if (isset($node[$item]['children'])) {
                $node = $node[$item]['children'];
            } else {
                $node = [];
                break;
            }
        }
        // $node['name'] = $name;
        // $node['title'] = $title;

        // $cache->save($config);
        print_r($namespace_index);
        $tree = $this->parseTree('default', $namespace);
        View::data('node', $namespace_index);
    	View::load('admin/edit_namespace', $tree);
    }

    public function namespaceRemove()
    {
        $namespace = Request::get('namespace');
        $component = $this->initComponent();
        $component->namespace($namespace, null);
        $component->remove($namespace, null);

        // Url::redirect('/admin/page?namespace=' . dirname($namespace) . DS);
    }

    public function namespaceAdd()
    {
        $namespace = Request::get('namespace');
        $name = Request::post('name');

        $component = $this->initComponent();

        if (!$component->namespace($namespace, $name)) {
            return Page::error('名称错误，[名称重复]或[格式必须为数字，英文，下划线任意组合]');
        }
        Url::redirect('/admin/page?namespace=' . $namespace . $name);
    }

    public function addComponent()
    {
        $namespace = Request::get('namespace');
        $component = $this->initComponent();
        $component->namespace($namespace);
    	View::load('admin/add_component', [
            'namespace_parent' => $namespace,
            'namespace_index' => $component->namespaceIndex
        ]);
    }
    
    public function componentAdd()
    {
        $namespace = Request::get('namespace');
        $name = Request::post('name');
        $props = Request::post('props');
        $source = Request::post('source');
        $code = Request::post('code');
        // print_r($source);
        $component = $this->initComponent();
        
        $props = json_decode($props, true);
        $source = json_decode($source, true);
        // $source['name'] = 'app\\' . $source['name'];
        $data = [
            'props' => $props,
            'code' => $code,
            'source' => $source
        ];
        if (!$component->save($namespace, $name, $data)) {
            return Response::json(['err' => 1, 'msg' => '操作失败，可能原因：名称错误，[名称重复]或[格式必须为数字，英文，下划线任意组合]']);
            // return Page::error('名称错误，[名称重复]或[格式必须为数字，英文，下划线任意组合]');
        }
        return Response::json(['err' => 0, 'href' => '/admin/page?namespace=' . $namespace]);

        // Url::redirect('/admin/page?namespace=' . $namespace . $name . DS);
    }
    public function componentRemove()
    {
        $namespace = Request::get('namespace');
        $component_name = Request::get('component');
        $component = $this->initComponent();
        $component->remove($namespace, $component_name);
        Url::redirect('/admin/page?namespace=' . $namespace . DS);
    }

    public function getComponent()
    {
        $namespace = Request::get('namespace');
        $component_name = Request::get('component');
        $component = $this->initComponent();
        $config = $component->get($namespace, $component_name);
        $config['code'] = file_get_contents($config['template']);
        return Response::json(['err' => 0, 'data' => $config]);

    }

    public function column()
    {
        $list = Category::getList();
        View::load('admin/column', [
            'list' => $list
        ]);
    }

    public function addColumn()
    {
        View::load('admin/add_column');
    }

    public function editColumn()
    {
        $id = Request::get('id');
        $column = new Column;
        $info = $column->info(['id' => $id]);
        $this->getErr($info);
        View::load('admin/edit_column', ['info' => $info]);
    }

    public function saveColumn()
    {
        $post = Request::post();
        $column = new Column;
        $res = $column->add($post);
        return Response::json($res);
    }

    public function updateColumn()
    {
        $post = Request::post();
        // print_r($post);
        $column = new Column;
        $res = $column->save($post);
        return Response::json($res);
    }

    public function uoploadColumnPhoto()
    {
        $file = new File;
        $res = source('/App/File/upload', [
            'path' => '/upload/column',
            'size' => 20480000,
            'allow_type' => 'jpeg,jpg,gif,png',
            'is_rand_name' => 1,
            'input_name' => 'photo'
        ]);
        return Response::json($res);
    }

    public function removeColumn()
    {
        $id = Request::get('id');
        if (!Db::table('category')->where(['id' => $id])->remove()) {
            return Response::json(['err' => 1, 'msg' => '删除失败']);
        }
        return Response::json([1]);
    }

    private function getErr($data)
    {
        if (!empty($data['err'])) {
            View::load('error', $data);
            return;
            exit();
        }
    }

    public function user()
    {
        $user = new User;
        $list = $user->list([
            'order' => 0,
            'sort' => 0,
            'var_page' => 'p'
        ]);
        View::load('admin/user', [
            'list' => $list
        ]);
    }

    public function uoploadUserPhoto()
    {
        $file = new File;
        $res = $file->upload([
            'path' => '/upload/user',
            'size' => 20480000,
            'allow_type' => 'jpeg,jpg,gif,png',
            'is_rand_name' => 1,
            'input_name' => 'photo',
            'is_save_db' => 0
        ]);
        return Response::json($res);
    }
    public function editUser()
    {
        $id = Request::get('id');
        $user = new User;
        $info = $user->info(['id' => $id]);
        $this->getErr($info);
        View::load('admin/edit_user', ['info' => $info]);
    }

    public function updateUser()
    {
        $id = Request::get('id');
        $post = Request::post();
        if (!empty($post['password'])) {
            $post['password'] = md5($post['password']);
        }
        if (!Db::table('user')->where(['id' => $id])->update($post)) {
            return Response::json(['err' => 1, 'msg' => '修改失败']);
        }
        return Response::json(['id' => $id]);
    }
    /**
     * 删除用户
     */
    public function removeUser()
    {
        $id = Request::get('id');
        if (!Db::table('user')->where(['id' => $id])->remove()) {
            return Response::json(['err' => 1, 'msg' => '删除失败']);
        }
        return Response::json(['id' => $id]);
    }

    public function forum()
    {
        $list = source('/Model/Forum/getList', ['status' => 9999]);
        View::load('admin/forum', [
            'list' => $list
        ]);
    }

    public function forumAuto()
    {
        $forum = new Forum;
        $list = source('/Model/Forum/getList', ['status' => 1]);

        View::load('admin/forum_auto', [
            'list' => $list
        ]);
    }

    /**
     * 恢复帖子
     */
    public function backForum()
    {
        $id = Request::get('id');
        if (!Db::table('forum')->where(['id' => $id])->update(['status' => 0])) {
            return Response::json(['err' => 1, 'msg' => '恢复失败']);
        }
        return Response::json(['id' => $id]);
    }

    /**
     * 删除用户
     */
    public function removeForum()
    {
        $id = Request::get('id');
        if (!Db::table('forum')->where(['id' => $id])->remove()) {
            return Response::json(['err' => 1, 'msg' => '删除失败']);
        }
        return Response::json(['id' => $id]);
    }

    public function database()
    {
        $list = $this->getFileTree('data');
        rsort($list['file']);
        View::load('admin/database', ['list' => $list]);
    }

    public function databaseBackup()
    {
        $backup_dir = 'data';
        $name = date('YmdHis') . getRandChar(6) . '.sql';
        $database = new DatabaseTool([
            'target' => $backup_dir . DS . $name
        ]);
        $database->backup();
        // return Response::json(['name' => $name]);
        View::load('success', ['msg' => '备份成功', 'url' => '/admin/database']);
    }

    public function databaseRestore()
    {
        $backup_dir = 'data';
        $name = Request::get('name');
        $database = new DatabaseTool([
            'target' => $backup_dir . DS . $name
        ]);
        if (!$database->restore()) {
            return Response::json(['err' => 1, 'msg' => '还原失败']);
        }
        return Response::json(['name' => $name]);
        // View::load('success', ['msg' => '恢复成功', 'url' => '/admin/database']);
    }
    
    public function databaseRemove()
    {
        $backup_dir = 'data';
        $name = Request::get('name');
        unlink($backup_dir . DS . $name);
        return Response::json(['name' => $name]);
        // View::load('success', ['msg' => '删除成功', 'url' => '/admin/database']);
    }

    public function systemSet()
    {
        $setting = Setting::get(['is_register']);
        View::load('admin/system_set', $setting);
    }

    public function  saveSystem()
    {
        $post = Request::post();
        $res = Setting::set($post);
        return Response::json(['err'=> 0]);
    }

    public function reward()
    {
        $setting = Setting::get(['login_reward', 'forum_reward', 'reply_reward']);
        View::load('admin/reward', $setting);
    }

    public function waterMark()
    {
        $setting = Setting::get(['forum_water_mark_path', 'forum_water_mark_status']);
        View::load('admin/water_mark', $setting);
    }
    
    public function saveSetting()
    {
        $data = Request::post();
        // $config = json_decode($data, true);
        $setting = Setting::set($data);
        return Response::json(['err' => 0]);
    }

    public function code()
    {
        $list = Code::order('id', 'DESC')->paginate(10);
        View::load('admin/code', ['list' => $list, 'page' => $list->render()]);
    }

    public function addCode()
    {
        View::load('admin/add_code');
    }

    public function codeAdd()
    {
        $data = Request::post(['name', 'title', 'content']);
        if (Code::get(['name' => $data['name']])) {
            return View::load('error', ['msg' => '添加失败，可能原因：名称重复']);
        }
        if (!Code::create($data)) {
            return View::load('error', ['msg' => '添加失败！']);
        }
        return View::load('success', ['msg' => '添加成功', 'url' => '/admin/code']);
    }

    public function editCode()
    {
        $id = Request::get('id');
        if (!$code = Code::get($id)) {
            return View::load('error', ['msg' => '自定义不存在！']);
        }
        View::load('admin/edit_code', ['code' => $code]);
    }

    public function codeEdit()
    {
        $id = Request::get('id');
        $data = Request::post(['name', 'title', 'content']);
        if ($code = Code::get(['name' => $data['name']])) {
            if ($code->id != $id) {
                return View::load('error', ['msg' => '修改失败，可能原因：名称重复']);
            }     
        }
        if (!Code::where('id', $id)->update($data)) {
            return View::load('error', ['msg' => '修改失败！']);
        }
        return View::load('success', ['msg' => '修改成功', 'url' => '/admin/code']);
    }


    public function removeCode()
    {
        $id = Request::get('id');
        if (!$code = Code::get($id)) {
            return View::load('error', ['msg' => '自定义不存在！']);
        }
        $code->delete();
        return View::load('success', ['msg' => '删除成功', 'url' => '/admin/code']);
    }

    public function getSource()
    {
        
        $source = [
            [
                'name' => 'Common',
                'title' => '通用',
                'action' => [
                    [
                        'action' => 'isLogin',
                        'name' => 'is_login',
                        'title' => '判断用户是否登录',
                        'options' => []
                    ], [
                        'action' => 'getUrl',
                        'name' => 'get_url',
                        'title' => '获取当前网址',
                        'options' => []
                    ]
                ]
            ], [
                'name' => 'User',
                'title' => '用户',
                'action' => [
                    [
                        'action' => 'base64Upload',
                        'name' => 'user_base64_upload',
                        'title' => 'base64头像接口',
                        'options' => [
                            [
                                'name' => 'path',
                                'title' => '存放路径',
                                'value' => 'static/uploads/photo/',
                                'explain' => '用户头像存放路径'
                            ], [
                                'name' => 'base64',
                                'title' => 'base64数据',
                                'value' => '',
                                'explain' => 'base64头像上传'
                            ]
                        ]
                    ], [
                        'action' => 'info',
                        'name' => 'userinfo',
                        'title' => '用户信息',
                        'options' => [
                            [
                                'name' => 'id',
                                'title' => '用户id',
                                'value' => 0,
                                'explain' => '获取用户信息'
                            ]
                        ]
                    ], [
                        'action' => 'editInfo',
                        'name' => 'user_edit_info',
                        'title' => '修改资料',
                        'options' => [
                            [
                                'name' => 'id',
                                'title' => '用户id',
                                'value' => 0,
                                'explain' => '要修改的用户的ID'
                            ], [
                                'name' => 'nickname',
                                'title' => '昵称',
                                'value' => '',
                                'explain' => '新昵称'
                            ], [
                                'name' => 'explain',
                                'title' => '签名',
                                'value' => '',
                                'explain' => '新签名'
                            ]
                        ]
                    ], [
                        'action' => 'updatePassword',
                        'name' => 'user_edit_pwd',
                        'title' => '修改密码',
                        'options' => [
                            [
                                'name' => 'id',
                                'title' => '用户id',
                                'value' => 0,
                                'explain' => '要修改的用户的ID'
                            ], [
                                'name' => 'password',
                                'title' => '原密码',
                                'value' => '',
                                'explain' => '原始密码'
                            ], [
                                'name' => 'password1',
                                'title' => '新密码',
                                'value' => '',
                                'explain' => '新密码'
                            ], [
                                'name' => 'password2',
                                'title' => '确认密码',
                                'value' => '',
                                'explain' => '确认密码'
                            ]
                        ]
                    ], [
                        'action' => 'quit',
                        'name' => 'user_quit',
                        'title' => '退出登录',
                        'options' => []
                    ], [
                        'action' => 'list',
                        'name' => 'user_list',
                        'title' => '用户列表',
                        'options' => [
                            [
                                'name' => 'var_page',
                                'title' => '翻页参数',
                                'value' => 'page',
                                'explain' => '翻页参数，有多个的时候请更换不一样的'
                            ], [
                                'name' => 'pagesize',
                                'title' => '显示条数',
                                'value' => 10,
                                'explain' => '每页最大显示条数'
                            ], [
                                'name' => 'order',
                                'title' => '排序依据',
                                'value' => 0,
                                'explain' => '0 动态排序，1 最新，2 经验，3 金币'
                            ], [
                                'name' => 'sort',
                                'title' => '排序方式',
                                'value' => 0,
                                'explain' => '0 正序<br>1 倒序'
                            ]
                        ]
                    ], [
                        'action' => 'login',
                        'name' => 'user_login',
                        'title' => '登录接口',
                        'options' => [
                            [
                                'name' => 'username',
                                'title' => '用户名',
                                'value' => '',
                                'explain' => '登录时候的用户名（用户必填）'
                            ], [
                                'name' => 'password',
                                'title' => '登录密码',
                                'value' => '',
                                'explain' => '登录时候的密码（用户必填）'
                            ]
                        ]
                    ], [
                        'action' => 'register',
                        'name' => 'user_reg',
                        'title' => '注册接口',
                        'options' => [
                            [
                                'name' => 'username',
                                'title' => '用户名',
                                'value' => '',
                                'explain' => '登录时候的用户名（用户必填）'
                            ], [
                                'name' => 'password',
                                'title' => '登录密码',
                                'value' => '',
                                'explain' => '登录时候的密码（用户必填）'
                            ], [
                                'name' => 'password2',
                                'title' => '重复密码',
                                'value' => '',
                                'explain' => '效验登录密码（用户必填）'
                            ], [
                                'name' => 'email',
                                'title' => '邮箱',
                                'value' => '',
                                'explain' => '找回密码或通知用到'
                            ]
                        ]
                    ], [
                        'action' => 'careList',
                        'name' => 'care_list',
                        'title' => '关注列表',
                        'options' => [
                            [
                                'name' => 'user_id',
                                'title' => '用户ID',
                                'value' => 0,
                                'explain' => '谁的关注列表'
                            ], [
                                'name' => 'page',
                                'title' => '页数',
                                'value' => 1,
                                'explain' => '读取第N页的数据'
                            ], [
                                'name' => 'pagesize',
                                'title' => '显示条数',
                                'value' => 10,
                                'explain' => '每页最大显示条数'
                            ], [
                                'name' => 'order',
                                'title' => '排序依据',
                                'value' => 0,
                                'explain' => '0 添加时间'
                            ], [
                                'name' => 'sort',
                                'title' => '排序方式',
                                'value' => 0,
                                'explain' => '0 正序<br>1 倒序'
                            ]
                        ]
                    ], [
                        'action' => 'fansList',
                        'name' => 'fans_list',
                        'title' => '粉丝列表',
                        'options' => [
                            [
                                'name' => 'care_user_id',
                                'title' => '用户ID',
                                'value' => 0,
                                'explain' => '谁的粉丝列表'
                            ], [
                                'name' => 'page',
                                'title' => '页数',
                                'value' => 1,
                                'explain' => '读取第N页的数据'
                            ], [
                                'name' => 'pagesize',
                                'title' => '显示条数',
                                'value' => 10,
                                'explain' => '每页最大显示条数'
                            ], [
                                'name' => 'order',
                                'title' => '排序依据',
                                'value' => 0,
                                'explain' => '0 添加时间'
                            ], [
                                'name' => 'sort',
                                'title' => '排序方式',
                                'value' => 0,
                                'explain' => '0 正序<br>1 倒序'
                            ]
                        ]
                    ], [
                        'action' => 'isCare',
                        'name' => 'is_care',
                        'title' => '是否关注',
                        'options' => [
                            [
                                'name' => 'care_user_id',
                                'title' => '对象用户ID',
                                'value' => '',
                                'explain' => '查看用户的id'
                            ]
                        ]
                    ], [
                        'action' => 'setCare',
                        'name' => 'set_care',
                        'title' => '关注/取消',
                        'options' => [
                            [
                                'name' => 'care_user_id',
                                'title' => '对象用户ID',
                                'value' => '',
                                'explain' => '查看用户的id'
                            ]
                        ]
                    ]
                ]
            ], [
                'name' => 'Message',
                'title' => '消息',
                'action' => [
                    [
                        'action' => 'list',
                        'name' => 'message_list',
                        'title' => '列表',
                        'options' => [
                            [
                                'name' => 'user_id',
                                'title' => '发件人id',
                                'value' => 0,
                                'explain' => '0 为系统消息'
                            ], [
                                'name' => 'to_user_id',
                                'title' => '收件人id',
                                'value' => 0,
                                'explain' => '收件人id'
                            ], [
                                'name' => 'page',
                                'title' => '页数',
                                'value' => 1,
                                'explain' => '读取第N页的数据'
                            ], [
                                'name' => 'pagesize',
                                'title' => '显示条数',
                                'value' => 10,
                                'explain' => '每页最大显示条数'
                            ]
                        ]
                    ],
                    [
                        'action' => 'count',
                        'name' => 'message_count',
                        'title' => '数量',
                        'options' => [
                            [
                                'name' => 'status',
                                'title' => '类型',
                                'value' => 0,
                                'explain' => '0 为未读，1 为已读，2 为所有'
                            ]
                        ]
                    ]
                ]
            ], [
                'name' => 'Column',
                'title' => '栏目',
                'action' => [
                    [
                        'action' => 'info',
                        'name' => 'column_info',
                        'title' => '栏目详细',
                        'options' => [
                            [
                                'name' => 'id',
                                'title' => '栏目ID',
                                'value' => 0,
                                'explain' => '后台栏目配置查看ID'
                            ]
                        ]
                    ], [
                        'action' => 'list',
                        'name' => 'column_list',
                        'title' => '列表',
                        'options' => [
                            [
                                'name' => 'type',
                                'title' => '栏目类型',
                                'value' => 0,
                                'explain' => '0 普通，1 论坛'
                            ], [
                                'name' => 'page',
                                'title' => '页数',
                                'value' => 1,
                                'explain' => '读取第N页的数据'
                            ], [
                                'name' => 'pagesize',
                                'title' => '显示条数',
                                'value' => 10,
                                'explain' => '每页最大显示条数'
                            ], [
                                'name' => 'order',
                                'title' => '排序依据',
                                'value' => 0,
                                'explain' => '0 添加顺序，1 后台设置顺序'
                            ], [
                                'name' => 'sort',
                                'title' => '排序方式',
                                'value' => 0,
                                'explain' => '0 正序<br>1 倒序'
                            ]
                        ]
                    ]
                ]
            ], [
                'name' => 'Forum',
                'title' => '论坛',
                'action' => [
                    [
                        'action' => 'add',
                        'name' => 'forum_add',
                        'title' => '发表帖子',
                        'options' => [
                            [
                                'name' => 'class_id',
                                'title' => '栏目ID',
                                'value' => 0,
                                'explain' => '后台栏目配置查看ID'
                            ], [
                                'name' => 'user_id',
                                'title' => '会员ID',
                                'value' => 0,
                                'explain' => '默认为0，此配置只能为0，后台会员管理查看会员ID'
                            ], [
                                'name' => 'title',
                                'title' => '标题',
                                'value' => '',
                                'explain' => '文章标题'
                            ], [
                                'name' => 'context',
                                'title' => '内容',
                                'value' => 10,
                                'explain' => '文章内容'
                            ], [
                                'name' => 'img_data',
                                'title' => '图片ID',
                                'value' => 0,
                                'explain' => '多个用","号分隔，可在后台文件管理查看，通常此参数由会员提供'
                            ], [
                                'name' => 'file_data',
                                'title' => '文件ID',
                                'value' => 0,
                                'explain' => '多个用","号分隔，可在后台文件管理查看，通常此参数由会员提供'
                            ]
                        ]
                    ], [
                        'action' => 'edit',
                        'name' => 'forum_edit',
                        'title' => '修改帖子',
                        'options' => [
                            [
                                'name' => 'id',
                                'title' => '帖子ID',
                                'value' => 0,
                                'explain' => '要修改的帖子的ID'
                            ],[
                                'name' => 'class_id',
                                'title' => '栏目ID',
                                'value' => 0,
                                'explain' => '后台栏目配置查看ID'
                            ], [
                                'name' => 'user_id',
                                'title' => '会员ID',
                                'value' => 0,
                                'explain' => '默认为0，此配置只能为0，后台会员管理查看会员ID'
                            ], [
                                'name' => 'title',
                                'title' => '标题',
                                'value' => '',
                                'explain' => '文章标题'
                            ], [
                                'name' => 'context',
                                'title' => '内容',
                                'value' => 10,
                                'explain' => '文章内容'
                            ], [
                                'name' => 'img_data',
                                'title' => '图片ID',
                                'value' => 0,
                                'explain' => '多个用","号分隔，可在后台文件管理查看，通常此参数由会员提供'
                            ], [
                                'name' => 'file_data',
                                'title' => '文件ID',
                                'value' => 0,
                                'explain' => '多个用","号分隔，可在后台文件管理查看，通常此参数由会员提供'
                            ]
                        ]
                    ], [
                        'action' => 'remove',
                        'name' => 'forum_remove',
                        'title' => '回收帖子',
                        'options' => [
                            [
                                'name' => 'id',
                                'title' => '帖子ID',
                                'value' => 0,
                                'explain' => '要回收的帖子的ID'
                            ]
                        ]
                    ], [
                        'action' => 'list',
                        'name' => 'list',
                        'title' => '列表',
                        'options' => [
                            [
                                'name' => 'class_id',
                                'title' => '栏目ID',
                                'value' => 0,
                                'explain' => '后台栏目配置查看ID'
                            ], [
                                'name' => 'user_id',
                                'title' => '会员ID',
                                'value' => 0,
                                'explain' => '后台会员管理查看会员ID'
                            ], [
                                'name' => 'page',
                                'title' => '页数',
                                'value' => 1,
                                'explain' => '读取第N页的数据'
                            ], [
                                'name' => 'pagesize',
                                'title' => '显示条数',
                                'value' => 10,
                                'explain' => '每页最大显示条数'
                            ], [
                                'name' => 'order',
                                'title' => '排序依据',
                                'value' => 0,
                                'explain' => '0 动态排序，1 最新，2 最热'
                            ], [
                                'name' => 'sort',
                                'title' => '排序方式',
                                'value' => 0,
                                'explain' => '0 正序<br>1 倒序'
                            ]
                        ]
                    ], [
                        'action' => 'view',
                        'name' => 'view',
                        'title' => '帖子详细',
                        'options' => [[
                            'name' => 'id',
                            'title' => '帖子ID',
                            'value' => 0,
                            'explain' => '对应主贴的ID'
                        ], [
                            'name' => 'is_html',
                            'title' => 'HTML过滤',
                            'value' => 1,
                            'explain' => '0 关闭，1 启用（在仅限管理员发布情况下可关闭该功能，主要为了防止会员xss攻击）'
                        ], [
                            'name' => 'is_ubb',
                            'title' => 'UBB语法',
                            'value' => 1,
                            'explain' => '0 关闭，1 启用'
                        ]]
                    ], [
                        'action' => 'replyAdd',
                        'name' => 'reply_add',
                        'title' => '回复主题',
                        'options' => [[
                            'name' => 'forum_id',
                            'title' => '帖子ID',
                            'value' => 0,
                            'explain' => '对应主贴的ID'
                        ], [
                            'name' => 'context',
                            'title' => '内容',
                            'value' => '',
                            'explain' => '回复内容'
                        ]]
                    ], [
                        'action' => 'replyList',
                        'name' => 'reply_list',
                        'title' => '回复列表',
                        'options' => [
                            [
                                'name' => 'forum_id',
                                'title' => '帖子ID',
                                'value' => 0,
                                'explain' => '对应主贴的ID'
                            ], [
                                'name' => 'user_id',
                                'title' => '会员ID',
                                'value' => 0,
                                'explain' => '后台会员管理查看会员ID'
                            ], [
                                'name' => 'page',
                                'title' => '页数',
                                'value' => 1,
                                'explain' => '读取第N页的数据'
                            ], [
                                'name' => 'pagesize',
                                'title' => '显示条数',
                                'value' => 10,
                                'explain' => '每页最大显示条数'
                            ], [
                                'name' => 'order',
                                'title' => '排序依据',
                                'value' => 0,
                                'explain' => '0 最新'
                            ], [
                                'name' => 'sort',
                                'title' => '排序方式',
                                'value' => 0,
                                'explain' => '0 正序，1 倒序'
                            ]
                        ]
                    ]
                ]
            ],[
                'name' => 'File',
                'title' => '文件',
                'action' => [
                    [
                        'action' => 'upload',
                        'name' => 'file_upload',
                        'title' => '文件上传接口',
                        'options' => [
                            [
                                'name' => 'user_id',
                                'title' => '用户ID',
                                'value' => 0,
                                'explain' => '设置文件上传者（用户）ID，0为自动获取。'
                            ], [
                                'name' => 'path',
                                'title' => '保存路径',
                                'value' => '/upload',
                                'explain' => '文件保存路径'
                            ], [
                                'name' => 'size',
                                'title' => '上传大小',
                                'value' => 2048000,
                                'explain' => '最大允许上传文件的大小 单位 kb'
                            ], [
                                'name' => 'file_name',
                                'title' => '文件名',
                                'value' => '',
                                'explain' => '用于展示'
                            ], [
                                'name' => 'file_memo',
                                'title' => '文件说明',
                                'value' => '',
                                'explain' => '用于展示'
                            ], [
                                'name' => 'allow_type',
                                'title' => '允许类型',
                                'value' => 'jpeg,jpg,gif,png',
                                'explain' => '允许上传文件的类型，多个用逗号","分割'
                            ], [
                                'name' => 'is_rand_name',
                                'title' => '系统命名',
                                'value' => 0,
                                'explain' => '使用系统命名，或者保存原文件名（原文件名有可能重复）'
                            ], [
                                'name' => 'input_name',
                                'title' => '表单名',
                                'value' => 'file',
                                'explain' => '文件传入的表单对应的name'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        return Response::json($source);
    }

    public function templateTest()
    {
        $template = new \Iam\Template;
        $template->test();
    }

    public function img()
    {
        $photo = Request::get('photo');
        print_r($photo);
        downloadImage($photo, uniqid(), 'static/novels/');
    }

}
