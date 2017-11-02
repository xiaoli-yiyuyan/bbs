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
