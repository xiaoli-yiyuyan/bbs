<?php
function now()
{
    return date('Y-m-d H:i:s');
}

function getRandChar($length)
{
	$str = null;
	$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	$max = strlen($strPol)-1;

	for($i=0;$i<$length;$i++){
		$str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
	}

	return $str;
}

function longPolling($callback){
    session_write_close();
    // ignore_user_abort(false);
    set_time_limit(0);

    for($i=0;$i<25;$i++){
        echo str_repeat(' ',4000);
        ob_flush();
        flush();
        if ($callback()) {
            return;
        }
        sleep(1);
    }
    ob_end_flush();
	echo "[]";
}

/**
 * 封装base64位图片上传
 */
function base64Upload($base64, $path='uploads/images/', $filename='')
{
    $filename = $filename ? $filename : uniqid();//文件名
    $base64_image = str_replace(' ', '+', $base64);
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)){
        if($result[2] == 'jpeg'){
            $image_name = $filename.'.jpg';
        }else{
            $image_name = $filename.'.'.$result[2];
        }
        $image_file = $path.$image_name;
        if (file_put_contents($image_file, base64_decode(str_replace($result[1], '', $base64_image)))){
            return '/'.$path.$image_name;
        }else{
            return '';
        }
    }else{
        return '';
    }
}


function getUserLevel($exp, $upExp)
{
    $level = floor(($upExp + sqrt(pow($upExp, 2) + 4 * $upExp * $exp )) / ($upExp * 2)); //计算当前等级
    $next_count_exp = ($level + 1) * $level * $upExp; // 下一级需要的总经验
    $next_exp = $next_count_exp - $level * ($level - 1) * $upExp;
    $now_exp = $next_exp - $next_count_exp + $exp; // 计算离下一级还差多少经验
    return ['level' => $level, 'next_exp' => $next_exp, 'now_exp' => $now_exp];
}


function downloadImage($url, $filename = '', $path = 'images/')
{
    $mime_to_ext = [
        'image/x-ms-bmp' => '.bmp',
        'image/jpeg' => '.jpg',
        'image/gif' => '.gif',
        'image/png' => '.png'
    ];
    $header = [];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $file = curl_exec($ch);
    curl_close($ch);

    if (!$img = @getimagesizefromstring($file)) {
        return;
    }
    if (!isset($mime_to_ext[$img['mime']])) {
        return;
    }

    $filename .= $mime_to_ext[$img['mime']];
    $resource = fopen($path . $filename, 'a');
    fwrite($resource, $file);
    fclose($resource);
    return $path . $filename;
} 
function redirect($url, $params = [])
{
    \Iam\Url::redirect($url, $params);
    exit();
}

function byteFormat($size, $dec=2){
    $a = array("B", "KB", "MB", "GB", "TB", "PB");
    $pos = 0;
    while ($size >= 1024) {
         $size /= 1024;
           $pos++;
    }
    return round($size,$dec)." ".$a[$pos];
 }
 
function strNPos($str, $find, $n){
    $pos_val = 0;
    $len = mb_strlen($find);
    for ($i = 1; $i <= $n; $i++){
        $pos = mb_strpos($str, $find);
        $str = mb_substr($str, $pos + $len);
        $pos_val = $pos + $pos_val + $len;
    }
    return $pos_val - $len;
}