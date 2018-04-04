<?php
function getRandChar($length){
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


function getUserLeve($exp, $upExp)
{
    $level = floor(($upExp + sqrt(pow($upExp, 2) + 4 * $upExp * $exp )) / ($upExp * 2)); //计算当前等级
    $next_count_exp = ($level + 1) * $level * $upExp; // 下一级需要的总经验
    $next_exp = $next_count_exp - $level * ($level - 1) * $upExp;
    $now_exp = $next_exp - $next_count_exp + $exp; // 计算离下一级还差多少经验
    return ['level' => $level, 'next_exp' => $next_exp, 'now_exp' => $now_exp];
}