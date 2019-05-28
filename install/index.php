<?php
define('DS', DIRECTORY_SEPARATOR);

define('APP_PATH', dirname(__DIR__));
define('IAM_PATH', dirname(__DIR__) . DS . 'IAMCore');
define('EXT', '.php');
define('CORE_PATH', IAM_PATH . DS . 'core' . DS);
define('ROOT_PATH', dirname(__DIR__) . DS);
require ROOT_PATH . 'vendor/autoload.php';

use Iam\View;
use Iam\Mysql;
use Iam\Cache;
use Iam\Config;
use Iam\Request;
use Iam\Response;
use comm\core\DatabaseTool;

Config::set(['TEMPLATE' => [
    'DIR' => 'install',
    'PATH' => 'tpl',
    'EXT' => '.php'
]]);
View::setConfig();
/**
 * 系统环境检测
 * @return array 系统环境数据
 */
function check_env()
{
    $items = array(
        'os'     => array('操作系统', '不限制', '类Unix', PHP_OS, 'success'),
        'php'    => array('PHP版本', '7.0', '7.0+', PHP_VERSION, 'success'),
        'upload' => array('附件上传', '不限制', '2M+', '未知', 'success'),
        'gd'     => array('GD库', '2.0', '2.0+', '未知', 'success'),
        'disk'   => array('磁盘空间', '5M', '不限制', '未知', 'success'),
    );

    //PHP环境检测
    if ($items['php'][3] < $items['php'][1]) {
        $items['php'][4] = 'error';
    }

    //附件上传检测
    if (@ini_get('file_uploads')) {
        $items['upload'][3] = ini_get('upload_max_filesize');
    }

    //GD库检测
    $tmp = function_exists('gd_info') ? gd_info() : array();
    if (empty($tmp['GD Version'])) {
        $items['gd'][3] = '未安装';
        $items['gd'][4] = 'error';
    } else {
        $items['gd'][3] = $tmp['GD Version'];
    }
    unset($tmp);

    //磁盘空间检测
    if (function_exists('disk_free_space')) {
        $items['disk'][3] = floor(disk_free_space(ROOT_PATH) / (1024 * 1024)) . 'M';
    }

    return $items;
}


/**
 * 函数检测
 * @return array 检测数据
 */
function check_func()
{
    $items = [
        ['pdo', '支持', 'success', '类'],
        ['pdo_mysql', '支持', 'success', '模块'],
        ['file_get_contents', '支持', 'success', '函数'],
        ['mb_strlen', '支持', 'success', '函数'],
    ];

    foreach ($items as &$val) {
        if (('类' == $val[3] && !class_exists($val[0]))
            || ('模块' == $val[3] && !extension_loaded($val[0]))
            || ('函数' == $val[3] && !function_exists($val[0]))
        ) {
            $val[1] = '不支持';
            $val[2] = 'error';
            session('error', true);
        }
    }

    return $items;
}

/**
 * 目录，文件读写检测
 * @return array 检测数据
 */
function check_dirfile()
{
    $items = [
        ['dir', '可写', 'success', 'theme'],
        ['dir', '可写', 'success', 'upload']
    ];

    foreach ($items as &$val) {
        $item = ROOT_PATH . $val[3];
        if ('dir' == $val[0]) {
            if (!is_writable($item)) {
                if (is_dir($item)) {
                    $val[1] = '可读';
                    $val[2] = 'error';
                } else {
                    $val[1] = '不存在';
                    $val[2] = 'error';
                }
            }
        } else {
            if (file_exists($item)) {
                if (!is_writable($item)) {
                    $val[1] = '不可写';
                    $val[2] = 'error';
                }
            } else {
                if (!is_writable(dirname($item))) {
                    $val[1] = '不存在';
                    $val[2] = 'error';
                }
            }
        }
    }

    return $items;
}

$step = Request::get('step');

if ($step == 2) {
    $env = check_env();
    $func = check_func();
    $dirfile = check_dirfile();

    // 安装环境监测
    View::load('step_2', [
        'version' => comm\core\IamVersion::$version,
        'datetime' => comm\core\IamVersion::$datetime,
        'env' => $env,
        'func' => $func,
        'dirfile' => $dirfile
    ]);
} elseif ($step == 3) {
    // 开始安装数据库
    
    View::load('step_3');
} elseif ($step == 4) {
    // 安装完成，删除安装程序
    $data = Request::post(['host', 'dbname', 'user', 'pass', 'port']);
    $err = 0;
    $msg = '';
    foreach ($data as $k => $v) {
        if ($k == 'pass') {
            break;
        }
        if (empty($v)) {
            $err = 1;
            $msg = '安装错误，请检查配置信息';
        }
    }
    if (!$err) {

        $mysql = new Mysql([
            'host' => $data['host'],
            'user' => $data['user'],
            'pass' => $data['pass'],
            'port' => $data['port'],
            'dbname' => ''
    
        ]);
        if ($mysql->exec("CREATE DATABASE IF NOT EXISTS `{$data['dbname']}` DEFAULT CHARACTER SET UTF8")) {
            $cache = new Cache('../comm/', 'datebase');
            $cache->save($data);
            $backup_dir = '..' . DS . 'install';
            $database = new DatabaseTool([
                'target' => $backup_dir . DS . 'ianmi.sql'
            ]);
            if (!$database->restore()) {
                $err = 2;
                $msg = '安装错误，还原数据库失败';
            }
        }
    
    }
    View::load('step_4', [
        'err' => $err,
        'msg' => $msg
    ]);
} else {
    // 阅读协议，确认安装程序
    
    View::load('step_1', [
        'version' => comm\core\IamVersion::$version
    ]);
}