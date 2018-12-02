<?php
/**
 * 数据源获取
 */
function source($cmd)
{
	// source('api/list?user_name=1&b=2c=3');
	// $param = func_get_args();
	// 要调用的方法
	// $action = $param[0];
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

	$appClass = explode('/', trim($url['path'], '/'));
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
			return;
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
			return $method->invokeArgs($method->isStatic() ? null : $appClass, $args);
		} else {
			throw new \Exception('参数错误，缺少参数');
		}

	}

	// return parse_url($cmd);
}