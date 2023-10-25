## 验证码
 

### 安装  

~~~
composer require thefunpower/captcha
~~~

### 前端调用 
~~~
<?php 
$captcha = get_captcha_init();

?>
<?=$captcha['button']?>

~~~
输入JS文件
~~~
<?=$captcha['js_file']?>
~~~
输出JS代码 
~~~
<?=$captcha['js_code']?>
~~~


### 服务端验证
~~~
get_captcha_check();
~~~


### 腾讯云验证码

tencent_captcha_app_id 来源

https://console.cloud.tencent.com/captcha/graphical

tencent_secret_id tencent_secret_key 来源

https://console.cloud.tencent.com/cam/capi

~~~
captcha_drive = Tencent
tencent_secret_id = 
tencent_secret_key = 
tencent_captcha_app_id  = 
tencent_captcha_app_key = 
~~~
 
 

### 开源协议 

[LICENSE](LICENSE)
 
  
 