<?php

function print_arr($arr){
	foreach ($arr as $key => $value) {
		if (is_array($value)){
			print_arr($value);
		}else{
			echo '<pre>';
			echo $key . ' => ' . $value;
			echo '</pre>';
		}
	}
}

function redirect($page){
	header('Location:' . ROOTPATH . '/' . $page,true,303);
	exit;
}

function clean_text($str){

	$str = trim($str);
	$str = stripslashes($str);
	$str = htmlspecialchars($str);

	return $str;
}

function check($v,$k = null){

	if (isset($k) && !empty($k)){

		if (isset($k[$v]) && !empty($k[$v])){
			return true;
		}
		
	}else {

		if (isset($v) && !empty($v)){

			return true;
		}
	}

	return false;
}

function getRealIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function readFromFile($file){

	$content = file_get_contents($file);
	$content = explode(';',$content);

	return $content;
}