<?php
namespace Iam;

class Plugin
{
	public $pluginPath;
	public $runClass;

	public $appController = 'appController';
	public $controller = 'controller';

	public static $_ins;

	/**
	 * 单例模式
	 */
	public static function instance()
	{
		if(!self::$_ins) {
			self::$_ins = new self();
		}
		return self::$_ins;
	}

	/**
	 * 开始加载插件
	 */
	public function load()
	{
		$dir = Config::get('PLUGIN_DIR');
		if (!is_dir($dir)) {
			return false;
		}
		// 获取所有插件目录
		$files = array_diff(scandir($dir), array('.', '..'));
		if (is_array($files)) {
			foreach($files as $key => $value){
				$plugin = new self;
				$plugin->pluginPath = '\\' . $dir . '\\' . $value;
				// 加载入口文件
				$runClass = '\\' . $dir . '\\' . $value . '\\Index';
				if (!class_exists($runClass)) {
					continue;
				}

				Listen::on('appBeforeCreateError', [$plugin, 'controller']);
				Listen::on('appBeforeCreate', [$plugin, 'hookController']);
				// 运行插件
				$pluginClass = new $runClass;
				if (method_exists($pluginClass, 'init')) {
					$pluginClass->init();
				}
			}
		}
	}

	/**
	 * 控制器注入
	 */
	public function hookController(&$class, &$action)
	{
		$className = $this->getClassName($class);
		$appContrillerClass = $this->pluginPath . '\\' . $this->appController . '\\' . $className;
        if (is_callable(array($appContrillerClass , $action))) {
            $class = new $appContrillerClass;
		}
		
	}

	/**
	 * 自定义控制器
	 */
	public function controller(&$className)
	{
		$class_name = $this->getClassName($className);
		$class_name = $this->pluginPath . '\\' . $this->controller . '\\' . $class_name;
		if (class_exists($class_name)) {
			$className = $class_name;
		}
	}

	/**
	 * 获取类名（不含命名空间）
	 */
	public function getClassName($class)
	{
		if (is_string($class)) {
			$runClassName = $class;
		} else {
			$runClassName = get_class($class);
		}
		$classArr = explode('\\', $runClassName);
		return end($classArr);
	}
}
