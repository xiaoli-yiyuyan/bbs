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
    ignore_user_abort(false);
    set_time_limit(0);

    for($i=0;$i<25;$i++){
        echo ' ';
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

function downloadFile($url, $filename = '', $path = '')
{
    $mime_to_ext = [
        'image/x-ms-bmp' => '.bmp',
        'image/jpeg' => '.jpg',
        'image/gif' => '.gif',
        'image/png' => '.png',
        'application/zip' => '.zip'
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

/**
 * 制定字符第N次出现的位置
 */
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
/**
 * 调用自定义代码
 * @param string $name 唯一名称标识
 * @return string
 */
function code($name)
{
    if ($code = Model\Code::get(['name' => $name])) {
        if ($code->status == 1) {
            return $code->content;
        }
    }
}

/** 
 * 关键字提取方法
 * @param $title string  进行分词的标题 
 * @param $content string  进行分词的内容 
 * @return array 得到的关键词数组 
 */
function getKeywords($title = "", $content = "") {  
    if (empty ( $title )) {  
        return array ();  
    }  
    if (empty ( $content )) {  
        return array ();  
    }  
    $data = $title . $title . $title . $content; // 为了增加title的权重，这里连接3次  

    //这个地方写上phpanalysis对应放置路径  
    // require_once './phpanalysis/phpanalysis.class.php';  

    app\ext\phpanalysis\PhpAnalysis::$loadInit = false;  //初始化类时是否直接加载词典，选是载入速度较慢，但解析较快；选否载入较快，但解析较慢
    $pa = new app\ext\phpanalysis\PhpAnalysis ( 'utf-8', 'utf-8', false );  

    $pa->LoadDict ();  //载入词典
    $pa->SetSource ( $data );  //设置源字符串
    $pa->StartAnalysis ( true );  //是否对结果进行优化

    $tags = $pa->GetFinallyKeywords (9); // 获取文章中的五个关键字  

    $tagsArr = explode (",",$tags);  
    return $tagsArr;//返回关键字数组
}
/**
* 图像裁剪
* @param $title string 原图路径
* @param $content string 需要裁剪的宽
* @param $encode string 需要裁剪的高
*/
function imagecropper($source_path, $target_width, $target_height)
{
    $source_info = getimagesize($source_path);
    $source_width = $source_info[0];
    $source_height = $source_info[1];
    $source_mime = $source_info['mime'];
    $source_ratio = $source_height / $source_width;
    $target_ratio = $target_height / $target_width;

    // 源图过高
    if ($source_ratio > $target_ratio)
    {
        $cropped_width = $source_width;
        $cropped_height = $source_width * $target_ratio;
        $source_x = 0;
        $source_y = ($source_height - $cropped_height) / 2;
    }
    // 源图过宽
    elseif ($source_ratio < $target_ratio)
    {
        $cropped_width = $source_height / $target_ratio;
        $cropped_height = $source_height;
        $source_x = ($source_width - $cropped_width) / 2;
        $source_y = 0;
    }
    // 源图适中
    else
    {
        $cropped_width = $source_width;
        $cropped_height = $source_height;
        $source_x = 0;
        $source_y = 0;
    }

    switch ($source_mime)
    {
        case 'image/gif':
        $source_image = imagecreatefromgif($source_path);
        break;

    case 'image/jpeg':
        $source_image = imagecreatefromjpeg($source_path);
        break;

    case 'image/png':
        $source_image = imagecreatefrompng($source_path);
        break;

    default:
        return false;
        break;
    }
    $target_image = imagecreatetruecolor($target_width, $target_height);
    $cropped_image = imagecreatetruecolor($cropped_width, $cropped_height);

    
    // 解决GIF背景透明
    $color = imagecolorallocate($cropped_image, 255, 255, 255);
    imagecolortransparent($cropped_image, $color); 
    imagefill($cropped_image, 0, 0, $color); 


    imagealphablending($target_image,false);
    imagesavealpha($target_image,true);
    imagealphablending($cropped_image,false);
    imagesavealpha($cropped_image,true);
    // 裁剪
    imagecopy($cropped_image, $source_image, 0, 0, $source_x, $source_y, $cropped_width, $cropped_height);
    // 缩放
    imagecopyresampled($target_image, $cropped_image, 0, 0, 0, 0, $target_width, $target_height, $cropped_width, $cropped_height);

    //保存图片到本地(两者选一)
    //$randNumber = mt_rand(00000, 99999). mt_rand(000, 999);
    //$fileName = substr(md5($randNumber), 8, 16) .".png";
    //imagepng($target_image,'./'.$fileName);
    //imagedestroy($target_image);

    //直接在浏览器输出图片(两者选一)
    header('Content-Type: image/jpeg');
    imagepng($target_image);
    imagedestroy($target_image);
    //imagejpeg($target_image);
    imagedestroy($source_image);
    //imagedestroy($target_image);
    imagedestroy($cropped_image);
}

function href($url)
{
    return $url;
}

function http($url, $params = [], $method = 'GET', $header = array(), $multi = false)
{
    $opts = array(
            CURLOPT_TIMEOUT        => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            //CURLOPT_HEADER => TRUE,
            CURLOPT_HTTPHEADER     => $header
    );

    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)){
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $params = http_build_query($params); //$multi ? $params : http_build_query($params);
            //print_r($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    //if($error) throw new Exception('请求发生错误：' . $error);
    return  $data;
}

/**
 * 解压一个ZIP文件
 * @param  [string] $toName   解压到哪个目录下
 * @param  [string] $fromName 被解压的文件名
 * @return [bool]             成功返回TRUE, 失败返回FALSE
 */
function unzip($fromName, $toName)
{
    // print_r($fromName);
    // echo filesize($fromName);
    if(!file_exists($fromName)){
        return FALSE;
    }
    $zipArc = new ZipArchive();
    if(!$zipArc->open($fromName)){
        return FALSE;
    }
    if(!$zipArc->extractTo($toName)){
        $zipArc->close();
        return FALSE;
    }
    return $zipArc->close();
}


/**
 * 友好格式化时间
 * 
 * @param string 时间
 * @return string
 */
function friendlyDateFormat($strtime /* timestamp */)
{
    $timestamp = strtotime($strtime);
    /* 计算出时间差 */
    $seconds = time() - $timestamp;
    $minutes = floor($seconds / 60);
    $hours   = floor($minutes / 60);
    $days    = floor($hours / 24);
    if ($seconds < 60) {
        return '刚刚';
    } elseif ($minutes < 60) {
        return $minutes . '分钟前';
    } elseif ($hours < 24) {
        return $hours . '小时前';
    } elseif ($days < 3) {
        return $days . '天前';
    } else {
        return date('m-d H:i', $timestamp);
    }
}

/**
 * 递归获取文件夹内所有文件
 * 返回一个TREE结构的文件系统
 * @param string $dir
 * @param array $filter
 * @return array $files
 */
function scan_dir($dir, $filter = []){
    if(!is_dir($dir))return false;
    $files = array_diff(scandir($dir), array('.', '..'));

    // 如果是个文件夹
    if(is_array($files)){

        // 遍历下面所有文件
        foreach($files as $key => $value){

            $path = $dir . '/' . $value;

            if(is_dir($path)){
                $files[$value] = scan_dir($path, $filter);
                unset($files[$key]);
                continue;
            }
            $pathinfo = pathinfo($path);
            $extension = array_key_exists('extension', $pathinfo) ? $pathinfo['extension'] : '';
            if(!empty($filter) && !in_array($extension, $filter)){
                unset($files[$key]);
            }
        }
    }
    unset($key, $value);
    return $files;
}

/**
 * 生成一个token
 */
function createToken($id)
{
    $token = md5(uniqid(microtime(true),true) . $id);
    return $token;
}

/**
 * 设置/获取TOKEN
 */
function token($token = '')
{
    static $uuid;
    if ($token !== '') {
        $uuid = $token;
    }

    if (empty($uuid)) {
        $uuid = \Iam\Request::get('token');
    }
    return $uuid;
}


/**
 * 格式化参数
 */
function parseParam($str)
{
    $str = trim($str, ',');
    if ($str === '') {
        return [];
    }
    $str = explode(',', $str);
    return $str;
}
