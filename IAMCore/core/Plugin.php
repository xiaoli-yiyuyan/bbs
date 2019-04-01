<?php
namespace Iam;

class Plugin
{
	/**
	 * 开始加载插件
	 */
	public static function load()
	{
		$dir = Config::get('PLUGIN_DIR');
		if (!is_dir($dir)) {
			return false;
		}
		// 获取所有插件目录
		$files = array_diff(scandir($dir), array('.', '..'));
		if (is_array($files)) {
			foreach($files as $key => $value){
				// 加载入口文件
				$runClass = '\\' . $dir . '\\' . $value . '\\Index';
				if (!class_exists($runClass)) {
					return;
				}
				// 运行插件
				$pluginClass = new $runClass;
				if (!method_exists($pluginClass, 'init')) {
					return;
				}
				$pluginClass->init();
			}
		}
	}
}
