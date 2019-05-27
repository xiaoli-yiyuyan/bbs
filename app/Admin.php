<?php
namespace app;

use Iam\Db;
use Iam\Url;
use Iam\View;
use Iam\Page;
use Iam\Cache;
use Iam\Request;
use Iam\Response;
use Iam\Config;
use Iam\Component;
use Model\CategoryGroup;
use Model\Code;
use Model\Category;
use comm\Setting;
use comm\core\DatabaseTool;
use comm\core\CheckUpdate;
use Model\Forum;
use Model\User;
use Model\Theme;

class Admin extends \comm\core\Home
{
    public function __construct()
    {
        parent::__construct();
        if ($this->user['id'] != 1) {
            Page::error('仅限管理员访问');
            exit();
        }
        View::setConfig([
            'PATH' => 'system'
        ]);
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
        $component_mark = Config::get('component');
        $component = new Component([
            'model' => $component_mark
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
        if (!$info = Category::info($id)) {
            return ['err' => 1, 'msg' => '你要查看的栏目不存在！'];
        }
        $info['is_admin'] = $this->isAdmin($this->user['id'], $info['id']);
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
        $list = $user->getList([
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
    public function editUser($id = '')
    {
        $info = User::get($id);
        // $this->getErr($info);
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
        $setting = Setting::get(['is_register','webname', 'webdomain', 'weblogo']);
        View::load('admin/system_set', $setting);
    }

    public function  saveSystem()
    {
        $post = Request::post();
        if(isset($post['webname'])){
            $post['webname'] = htmlspecialchars($post['webname']);
        }
        if(isset($post['weblogo'])){
            $post['weblogo'] = htmlspecialchars($post['weblogo']);
        }
        if(isset($post['webdomain'])){
            $post['webdomain'] = htmlspecialchars($post['webdomain']);
        }
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

    //上传LOGO
    public function uoploadLogoPhoto($base64)
    {
        if ($path = base64Upload($base64, 'upload/logo/', 'logo').'?t=' . time()) {
            return Response::json(['err' => 0, 'msg' => $path]);
        }
        return Response::json(['err' => 1, 'msg' => "上传失败"]);
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
            ]
        ];
        return Response::json($source);
    }

    // public function templateTest()
    // {
    //     $template = new \Iam\Template;
    //     $template->test();
    // }

    // public function img()
    // {
    //     $photo = Request::get('photo');
    //     print_r($photo);
    //     downloadImage($photo, uniqid(), 'static/novels/');
    // }

    /**
     * 测试专用，用于生成主题json文件
     */
    public function themeJson()
    {
        $list = (new Theme)->select()->toarray();//显示实验
        $list = json_encode($list);
        $file = fopen('./themejson.txt', "w+");
        fwrite($file, $list);
        fclose($file);
    }

    public $themeHost = 'http://theme.ianmi.com';

    /**
     * 主题管理
     */
    public function tpl()
    {
        $url = $this->themeHost . '/theme/getJson';
        $list = $this->curlWay($url);
        if(isset($list['err'])){
            return Response::json($list);
        }
        $list = json_decode($list, true);
        View::load('admin/tpl', ['list' => $list]);
    }

    /**
     * 我的主题管理
     */
    public function myTpl()
    {
        $setting = Setting::get(['theme', 'component']);
        $list = (new Theme)->paginate(10);
        View::load('admin/my_tpl', ['setting' =>$setting, 'list' => $list]);
    }
    
    /**
     * 主题切换（这里的主题切换选择，影响到上方的我的主题管理，若选择@1上述需修改）
     */
    public function themeUse()
    {
        $data = Request::post();
        if(!isset($data['id'])){
            return  Response::json(['err' => 1, 'msg' => '参数错误']);
        }
        /**@1保存theme表中的status完成主题切换，在@1和@2中任选一个 */
        // $res = Theme::setStatus(intval($data['id']));
        /****************@1***************/
        
        /**@2使用setting表中的主题标识完成主题切换，在@1和@2中任选一个 */
        $info = Theme::get(intval($data['id']));
        Setting::set(['theme' => $info->name]); //, 'component'=>$info->name
        $res = ['err' => 0];
        /*****************@2***********/

        return  Response::json($res);
    }

    /**
     * 主题修改名称
     */
    public function tplTitle()
    {
        $data = Request::post();
        if(!isset($data['id']) || !isset($data['title'])){
            return  Response::json(['err' => 1, 'msg' => '参数错误']);
        }
        $info = Theme::get(intval($data['id']));
        if($info){
            $info->title = $data['title'];
            $res = $info->save();
            if($res){
                return  Response::json(['err' => 0, 'msg' => '修改成功']);
            }
        }
        return  Response::json(['err' => 2, 'msg' => '数据不存在']);

    }

   /**
    * 克隆主题
   */
   public function cloneTheme($old_name = '', $name = '', $title = '', $version = '', $url = '')
   {
       /**查看标识是否唯一  1不能和默认名一致 2 不能和数据库中存在的关键字一样*/
       $name = trim($name);
       if($name == 'default' || $name == 'system'){
            return Response::json(['err' => 1, 'msg' => '该标识为关键字，请重新设置']);
       }

       $res = Theme::get(['name' => $name]);
       if($res){
           return Response::json(['err' => 1, 'msg' => '该标识已存在，请重新设置']);
       }
       $url = $this->themeHost . '/' . $url;
       $field = $this->curlWay($url);
       if(isset($field['err'])){
           return Response::json($field);
       }
       $file_url = "./theme/" . $name . ".zip";
       $resource = fopen($file_url, "w+");
       fwrite($resource, $field);
       fclose($resource);
       $result = unzip($file_url, './theme/'.$name);
       if($result){
           unlink($file_url);
           $theme = new Theme;
           $theme->name = $name;
           $theme->title = $title;
           $theme->version = $version;
           $theme->save();
           return Response::json(['err' => 0, 'msg' => '解压成功']);
       }
       return Response::json(['err' => 2, 'msg' => '解压失败']);
   }

   /**
    * 删除主题
    *@param int $id 主题id
    *@param string $name 主题标识
    */

    public function deleteTheme($id, $name)
    {
        $id = intval($id); 
        $name = trim($name);
        if($name == 'default' || $name == 'system'){
            return Response::json(['err' => 5, 'msg' => '该主题为默认主题不能删除']);
        }
        $info = Theme::get(['id' => $id, 'name' => $name]);
        if(!$info){
           return Response::json(['err' => 1, 'msg' => '删除错误，请确认删除主题']);
        }
        $res = $info->delete();
        if(!$res){
           return Response::json(['err' => 2, 'msg' => '删除错误，请重试']);
        }
        /**删除文件夹 */
        $dir = './theme/'.$name;
        $fileExists = file_exists($dir);
        if($fileExists){
            $this->deleteDir($dir);
        }
        return Response::json(['err' => 0, 'msg' => '删除成功']);
    }

    private function deleteDir($dir)
    {
        $handle = opendir($dir);
        if(!$handle){
            return false;
        }
        
        while (false !== ($file = readdir($handle))) {
            if ($file !== "." && $file !== "..") {       //排除当前目录与父级目录
                $file_url = $dir."/".$file;
                if (is_dir($file_url)) {
                    $this->deleteDir($file_url);
                } else {
                    unlink($file_url);
                }
            }
        }
        closedir( $handle );
        rmdir($dir);
    }
   /**
    * 抓取远程信息
    * @param string $url 抓取地址
    */
   private function curlWay($url)
   {
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,$url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_HEADER, 0);
       $data = curl_exec($ch);
       $res = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       curl_close($ch);
       if($res == '404'){
           return ['err' => 3, 'msg' => '源文件出错'];
       }
       return $data;
   }

    /**
    * 插件管理
    */
    public function plugin()
    {
        View::load('admin/plugin');
    }
}
