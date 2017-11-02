<?php
namespace Iam;
/**
*自动加载类
**/
class Loader
{
	protected static $namespaceAlias = [];
	protected static $map = [];

	public static function autoload($class)
	{
		if (!empty(self::$namespaceAlias)) {
            $namespace = dirname($class);
            if (isset(self::$namespaceAlias[$namespace])) {
                $original = self::$namespaceAlias[$namespace] . '\\' . basename($class);
                if (class_exists($original)) {
                    return class_alias($original, $class, false);
                }
            }
        }

        if ($file = self::findFile($class)) {
            // Win环境严格区分大小写
            // if (IS_WIN && pathinfo($file, PATHINFO_FILENAME) != pathinfo(realpath($file), PATHINFO_FILENAME)) {
            //     return false;
            // }

            include($file);
            return true;
        }

		// if (isset(self::$namespaceAlias[$className])) {

		// }
		// include($className.'.php');
	}

	public static function findFile($class)
	{
		if (!empty(self::$map[$class])) {
            // 类库映射
            return self::$map[$class];
        }
		$namespace = dirname($class);
		if (!empty(self::$map[$namespace])) {
			$original = self::$map[$namespace] . DS . basename($class) . EXT;
		} else {
			$original = ROOT_PATH . $class . EXT;
		}
		if (is_file($original)) {
			return $original;
		}
		return self::$map[$class] = false;
	}

    public static function addClassMap($class, $map = '')
    {
        if (is_array($class)) {
            self::$map = array_merge(self::$map, $class);
        } else {
            self::$map[$class] = $map;
        }
    }

	// public static function addNamespaceAlias($namespace, $path = '')
	// {
	// 	self::$namespaceAlias = array_merge(self::$namespaceAlias, $namespace);
	// }

	public static function addNamespaceAlias($namespace, $original = '')
    {
        if (is_array($namespace)) {
            self::$namespaceAlias = array_merge(self::$namespaceAlias, $namespace);
        } else {
            self::$namespaceAlias[$namespace] = $original;
        }
    }

	public static function register()
	{
		spl_autoload_register(['Iam\\Loader','autoload']);
		self::addClassMap([
			'Iam' => CORE_PATH
		]);
	}
}
