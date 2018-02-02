<?php
namespace Iam;

class Request
{
	public static $method;
	public static function method($method = false)
	{
		self::$method = $_SERVER['REQUEST_METHOD'];
		return self::$method;
	}

	public static function isGet($method = false)
	{
		return self::method() == 'GET';
	}

	public static function isPost($method = false)
	{
		return self::method() == 'POST';
	}

	public static function isAjax($method = false)
	{
		$result = isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest";
		return $result;
	}

	public static function post($data = null){
		//获取post数据
		return self::sustain("POST",$data);
	}

	public static function get($data = null){
		//获取get数据
		return self::sustain("GET",$data);
	}

	public static function cookie($data = null){
		//获取cookie
		return self::sustain("COOKIE",$data);
	}

	private static function sustain($way, $data = null)
	{
		if(!isset($data)){
			$wayTo = array(
				"GET"=>$_GET,
				"POST"=>$_POST,
				"COOKIE"=>$_COOKIE
			);
			$array = $wayTo[$way];
		}elseif(is_array($data)){
			$array = array();
			foreach ($data as $key => $value) {
				$setData = self::sustain_set_data($value,$way);
				$array[$value] = $setData;
			}
		}else{
			$setData = self::sustain_set_data($data,$way);
			$array = $setData;
		}
		return $array;
	}

	private static function sustain_set_data($val,$way)
	{
        /*
            设置POST,GET,COOKIE数据
        */
		if(!isset($val) || ($way!="GET" && $way!="POST" && $way!="COOKIE"))
			return;
		if($way == "GET"){
			return (!isset($_GET[$val])) ? null : $_GET[$val];
        }elseif($way == "POST"){
            return (!isset($_POST[$val])) ? null : $_POST[$val];
		}elseif($way == "COOKIE"){
			return (!isset($_COOKIE[$val])) ? null : $_COOKIE[$val];
		}
	}

	public static function ip($type = 0, $adv = false)
    {
        $type      = $type ? 1 : 0;
        static $ip = null;
        if (null !== $ip) {
            return $ip[$type];
        }

        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) {
                    unset($arr[$pos]);
                }
                $ip = trim(current($arr));
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}
