<?php
/**
 * 数据源获取
 */
function source()
{
	source('api/list?user_name=1&b=2c=3');
	$param = func_get_args();
	// 要调用的方法
	$action = $param[0];
}