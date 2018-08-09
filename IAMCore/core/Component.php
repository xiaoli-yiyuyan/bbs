<?php
namespace Iam;

use Iam\Db;
use Iam\Cache;
use Iam\Request;

class Component
{   
	protected $config = [
		'db' => false,
		'template_path' => 'template',
		'model' => 'default',
		'namespace_name' => 'namespace',
		'components_name' => 'components'
	];

	private $dir;

	public $namespace = [];
	public $components = [];
	public $namespaceIndex = [];

	public function __construct(array $config = [])
	{
        $this->config = array_merge($this->config, $config);
        $this->dir = $this->config['template_path'] . DS . $this->config['model'];
		$this->namespace = new Cache($this->dir, $this->config['namespace_name']);
		$this->components = new Cache($this->dir, $this->config['components_name']);
	}

	public function dbComponent($namespaceName, $componentName = '', $value = '')
	{
		$namespaceName = $this->ds . trim($namespaceName, $this->ds);
		if (!empty($value)) {
			if ($namespaceName == $this->ds && ($componentName == 'namespace' || $componentName == 'components')) {
				return;
			}
			if (!$this->checkName($componentName)) {
				return;
			}
			if (isset($value['code'])) {
				$template_root = ROOT_PATH . $this->dir;
				$path = $template_root . $namespaceName . DS . $componentName . '.php';
				$dirname = dirname($path);
				if (! file_exists($dirname)) {
					mkdir ($dirname, 0777, true);
				}
				file_put_contents($path, $value['code']);
				unset($value['code']);
				$value['template'] = $this->dir . $namespaceName . DS . $componentName . '.php';
			}
			Db::query('SELECT * FROM `component` WHERE `namespace`=? AND `component`=?', [$namespaceName, $componentName]);
		}
	}

	/**
	 * 获取/添加命名空间
	 * @param string $parent 父命名空间
	 * @param string $name 要添加的命名空间
	 * @return array
	 */
	public function namespace($parent = '/', $name = '')
	{
		$parent = trim($parent, $this->ds);
		$tree = $this->namespace->get();
		// 扁平化命名空间数组，方便下面操作
		$namespace = [&$tree];
		$i = 0;
		if ($parent != '') {
			$namespace_array = explode($this->ds, $parent);
			$this->namespaceIndex = $namespace_array;
			foreach ($namespace_array as $item) {
				if (isset($namespace[$i][$item])) {
					$namespace[] = &$namespace[$i][$item];
					$i ++;
				} else {
					break;
				}
			}
			
			if ($name === null) {
				$last_key = end($namespace_array);
				unset($namespace[$i - 1][$last_key]);
				$this->namespace->save($tree);
			}
		}

		if (!empty($name)) {
			if (!$this->checkName($name)) {
				return;
			}
			if (isset($namespace[$i][$name])) {
				return;
			}
			$namespace[$i][$name] = [];
			$this->namespace->save($tree);
		}

		$_namespace = $namespace[$i];
		return $namespace = $_namespace;
	}

	// public function namespaceIndex($parent = DS)
	// {
    //     $namespace_index = [];
    //     $parent = trim($namespace, DS);
    //     if ($parent != '') {
    //         $namespace_index = explode(DS, $parent);
    //     }
	// }

	private $ds = '/';

	/**
	 * 获取/操作组件内容
	 * @param string $namespace 命名空间
	 * @param string $component 组件名
	 * @param string $value 值
	 * @return array
	 */
	public function value($namespaceName, $componentName = '', $value = '')
	{
		$namespaceName = $this->ds . trim($namespaceName, $this->ds);
		$tree = $this->components->get();
		if (!empty($value)) {
			if ($namespaceName == $this->ds && ($componentName == 'namespace' || $componentName == 'components')) {
				return;
			}
			if (!$this->checkName($componentName)) {
				return;
			}
			if (isset($value['code'])) {
				$template_root = ROOT_PATH . $this->dir;
				$path = $template_root . $namespaceName . DS . $componentName . '.php';
				$dirname = dirname($path);
				if (! file_exists($dirname)) {
					mkdir ($dirname, 0777, true);
				}
				file_put_contents($path, $value['code']);
				unset($value['code']);
				$value['template'] = $this->dir . $namespaceName . DS . $componentName . '.php';
			}
			$tree[$namespaceName][$componentName] = $value;
			$this->components->save($tree);
			return $value;
		}
		if ($value === null) {
			$result = [];
			if ($componentName === null) {
				// 删除命名下级所有组件
				foreach ($tree as $key => $value) {
					$preg = '/^' . $namespaceName . DS . '.+/';
					// if (DS == '\\') {
						$preg = str_replace(DS, DS . DS, $preg);
					// }
					if ($key == $namespaceName || preg_match($preg, $key)) {
						// print_r($key);
						unset($tree[$key]);

					}
				}
				// print_r($tree);
				$this->components->set($tree);
				// $result = $tree[$namespaceName];
			} else {
				// 删除指定有组件
				// $result = $tree[$namespaceName][$componentName];
				unset($tree[$namespaceName][$componentName]);
				$this->components->save($tree);
			}
			return $result;
		}
		if (empty($componentName)) {
			if (!isset($tree[$namespaceName])) {
				return [];
			}
			return $tree[$namespaceName];
		}

		return $tree[$namespaceName][$componentName];
	}


	/**
	 * 获取组件内容
	 * @param string $namespace 命名空间
	 * @param string $component 组件名
	 * @return array
	 */
	public function get($namespaceName, $componentName)
	{
		if (empty($componentName)) {
			return;
		}
		return $this->value($namespaceName, $componentName);
	}

	/**
	 * 保存组件内容
	 * @param string $namespace 命名空间
	 * @param string $component 组件名
	 * @return array
	 */
	public function save($namespaceName, $componentName, $value)
	{
		if (empty($componentName)) {
			return;
		}
		return $this->value($namespaceName, $componentName, $value);
	}
	/**
	 * 删除组件内容
	 * @param string $namespace 命名空间
	 * @param string $component 组件名
	 * @return array
	 */
	public function remove($namespaceName, $componentName = null)
	{
		return $this->value($namespaceName, $componentName, null);
	}

	/**
	 * 获取组件列表
	 * @param string $namespace 命名空间
	 * @return array
	 */
	public function list($namespace = '/')
	{
		return $this->value($namespace);
	}

    private function checkName($name)
    {
        return preg_match('/^[0-9a-zA-Z\_]+$/', $name);
	}
	
	/**
	 * 模板加载
	 * @param string $name 模板路径
	 * @param array $data 变量参数
	 */
	public function load($name, $data = [])
	{
        // $name = str_replace('/', DS, $name);
        $name = $this->ds . trim($name, $this->ds);
        if ($name == $this->ds) {
            $namespace = $this->ds;
            $component_name = 'index';
        } else {
			$name_index = explode($this->ds, $name);
            $component_name = array_pop($name_index);
            $namespace = implode($this->ds, $name_index);
		}

		$config = $this->get($namespace, $component_name);
		
		$source = $config['source'];
		$props_data = [];
		$query = [];
		if (!empty($config['props'])) {
			$props = $config['props'];

			foreach ($props as $key => $value) {
				if ($value['type'] == 'get') {
					$props_data[$key] = Request::get($key, $value['value']);
					$query[$key] = $props_data[$key];
				} elseif ($value['type'] == 'post') {
					$props_data[$key] = Request::post($key, $value['value']);
				} else {
					$props_data[$key] = isset($data[$key]) ? $data[$key] : $value['value'];
				}
			}
		}

		foreach ($source as $item) {
			$runClass = '\\App\\' . $item['name'];

			if (class_exists($runClass)) {
				$appClass = new $runClass;
				$appAction = $item['action'];
				if (method_exists($appClass, $appAction)) {
					$item['options']['page_name'] = 'p';
					foreach ($item['options'] as $key => &$param) {
						if (is_array($param)) {
							if ($key == 'page') {
								$item['options']['page_name'] = $param['prop'];
							}
							$param = $props_data[$param['prop']];
						}
					}
					$item['options']['query'] = $query;
					$res = [
						$item['param'] => $appClass->$appAction($item['options'])
					];
					$data = array_merge($data, $res);
				}
			}
		}
		$data = array_merge($data, $props_data);

		if (file_exists($config['template'])) {
			(function() use($data, $config){
				extract($data); //数组转化为变量
				include($config['template']);
			})();
		} else {
			$tpl = '404';
		}
	}
}