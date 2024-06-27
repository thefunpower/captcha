## 验证码
 

### 安装  

~~~
composer require thefunpower/captcha
~~~
 


## 阿里云验证码

### 配置

~~~
captcha_drive = Aliyun
alibaba_cloud_access_key_id = 
alibaba_cloud_access_key_secret = 
# 可不配置此项
alibaba_cloud_endpoint = captcha.cn-shanghai.aliyuncs.com
~~~


## 腾讯云验证码

### 配置

~~~
captcha_drive = Tencent
tencent_secret_id = 
tencent_secret_key = 
tencent_captcha_app_id  = 
tencent_captcha_app_key = 
~~~

### 前端调用 

~~~
<?php 
get_captcha_init();
?>
~~~

触发验证码

~~~
$('#t_captcha_input').trigger('click'); 
~~~

点击验证码后执行JS

~~~
$vue->method("after_captcha()","
	let f = {}; 
	//或
	f.captcha = {
		appid:this.form.appid,
		ticket:this.form.ticket,
		randstr:this.form.randstr, 
	};
");
~~~


### 服务端验证

验证是POST中的captcha数组 `appid` `ticket` `randstr`

~~~
get_captcha_check();
~~~


### 腾讯云验证码

tencent_captcha_app_id  tencent_captcha_app_key 来源

https://console.cloud.tencent.com/captcha/graphical

tencent_secret_id tencent_secret_key 来源

https://console.cloud.tencent.com/cam/capi


 
 

### 开源协议 

[LICENSE](LICENSE)
 
  
 