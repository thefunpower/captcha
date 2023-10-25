<?php 

function get_captcha_drive(){
	$title = get_config('captcha_drive')?:'Tencent';
	return ucfirst(strtolower($title));
}

function get_captcha_check()
{
	$title = get_captcha_drive();
	$cls = "\captcha\\".$title;
	if(!class_exists($cls)){
		return;
	}
	$obj = new $cls;
	return $obj->check();
}

function get_captcha_init()
{
	$title = get_captcha_drive();
	$cls = "\captcha\\".$title;
	if(!class_exists($cls)){
		return;
	}
	$obj = new $cls;
	$res = $obj->get();
	return $res;
}