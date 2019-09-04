<?php
function request()
{
	return new \Iam\Request;
}

/**
 * 数据源获取
 */
function source($cmd, $query = [], &$class = null)
{
	// source('api/list?user_name=1&b=2c=3');
	// $param = func_get_args();
	// 要调用的方法

	$data = cmdParse($cmd);

	$appClass = $data['action'];
	
	$query = array_merge($data['query'], $query);
	
	if (count($appClass) == 1) {
		// 先检查函数存在不
		$appFunction = $appClass[0];
		if (function_exists($appFunction)) {
			$method = new ReflectionFunction($appFunction);
			$params = $method->getParameters();

			$args = [];
			// 设置参数
			foreach ($params as $param) {
				$paramName = $param->getName();
				if (isset($query[$paramName])) {
					$args[] = $query[$paramName];
				} elseif ($param->isDefaultValueAvailable()) {
					$args[] = $param->getDefaultValue();
				}
			}

			// 执行方法
			if (count($args) == $method->getNumberOfParameters()) {
				return $method->invokeArgs($args);
			} else {
				throw new \Exception('参数错误，缺少参数');
			}
		}
	} else {
		// 检查类和对应方法
		$appAction = end($appClass);
		array_pop($appClass);
		$appClass = implode('\\', $appClass);
		if (!class_exists($appClass, $appAction)) {
			throw new \Exception('对应类或者方法未找到');
		}

		// 执行带参数的方法
		$runClass = new $appClass;
		$method = new \ReflectionMethod($runClass, $appAction);

		$params = $method->getParameters();
		$args = [];
		// 设置参数
		foreach ($params as $param) {
			$paramName = $param->getName();
			if (isset($query[$paramName])) {
				$args[] = $query[$paramName];
			} elseif ($param->isDefaultValueAvailable()) {
				$args[] = $param->getDefaultValue();
			}
		}

		// 执行方法
		if (count($args) == $method->getNumberOfParameters()) {
			$class = $runClass;
			return $method->invokeArgs($method->isStatic() ? null : $runClass, $args);
		} else {
			throw new \Exception('参数错误，缺少参数');
		}

	}

	// return parse_url($cmd);
}

/**
 * 指令解析数据
 */
function cmdParse($cmd)
{
	if (!$url = parse_url($cmd)) {
		return;
	}

	if (!isset($url['path'])) {
		return;
	}

	// 参数解析
	$query = [];
	if (isset($url['query'])) {
		parse_str($url['query'], $query);
	}

	$action = explode('/', trim($url['path'], '/'));

	return [
		'action' => $action,
		'query' => $query
	];
}

/**
 * 加载自定义组件
 * @param string $cmd 	指令
 * @param array $query 	附加参数
 */
function component($cmd, $query = [])
{
	$component_mark = \Iam\Config::get('theme');
	$data = cmdParse($cmd);
	$action = implode('/', $data['action']);
	$component = new Iam\Component([
		'model' => $component_mark,
		'template_path' => 'theme/'
	]);
	if (!empty($query)) {
		$data['query'] = array_merge($data['query'], $query);
	}
	$component->load($action, $data['query']);
}

/**
 * 加载自定义组件(新版函数)
 * @param string $cmd 	指令
 * @param array $query 	附加参数
 */
function useComp($cmd, $query = [])
{
	$component_mark = \Iam\Config::get('theme');
	$data = cmdParse($cmd);
	$action = implode('/', $data['action']);
	$component = new Iam\Component([
		'model' => $component_mark,
		'template_path' => 'theme/'
	]);
	if (!empty($query)) {
		$data['query'] = array_merge($data['query'], $query);
	}
	$component->use($action, $data['query']);
}

function isMobile() { 
	// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
	if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
	  return true;
	} 
	// 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
	if (isset($_SERVER['HTTP_VIA'])) { 
	  // 找不到为flase,否则为true
	  return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
	} 
	// 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
	  $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger'); 
	  // 从HTTP_USER_AGENT中查找手机浏览器的关键字
	  if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
		return true;
	  } 
	} 
	// 协议法，因为有可能不准确，放到最后判断
	if (isset ($_SERVER['HTTP_ACCEPT'])) { 
	  // 如果只支持wml并且不支持html那一定是移动设备
	  // 如果支持wml和html但是wml在html之前则是移动设备
	  if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
		return true;
	  } 
	} 
	return false;
  }
  