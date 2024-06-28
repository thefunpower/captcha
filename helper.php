<?php 

function get_captcha_drive(){
	$title = get_config('send_phone_code_type');
	if(!$title || $title == 'think'){ 
		$title = get_config('captcha_drive')?:'Tencent';
	} 
	return ucfirst(strtolower($title));
}

function get_captcha_check($ignore_expire = false)
{
	$title = get_captcha_drive();
	$cls = "\captcha\\".$title;
	if(!class_exists($cls)){
		return;
	}
	$obj = new $cls;
	return $obj->check($ignore_expire);
}

function get_captcha_init($output = true)
{
	$title = get_captcha_drive();
	$cls = "\captcha\\".$title;
	if(!class_exists($cls)){
		return;
	}
	$obj = new $cls;
	$res = $obj->get();
	if($output){
		foreach($res as $v){
			echo $v;
		}
		return;
	}
	return $res;
}