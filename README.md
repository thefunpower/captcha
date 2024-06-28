## 验证码
 

### 安装  

~~~
composer require thefunpower/captcha
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



## 阿里云验证码

暂不支持

正确的逻辑是：需要先JS前端自己验证，再发送到服务端验证。

### 配置

~~~
captcha_drive = Aliyun
# 阿里云验证码  
alibaba_cloud_access_key_id = 
alibaba_cloud_access_key_secret = 
# 场景名称 ID
alibaba_cloud_captcha_scene_id = 
# 身份标
alibaba_cloud_captcha_prefix = 
# 可不配置此项
alibaba_cloud_endpoint = captcha.cn-shanghai.aliyuncs.com
~~~

### 验证

~~~
Route::post('/captcha/aliyun', function () {   
	$flag = get_captcha_check(); 
	if(!$flag){
		return  json_success(['data'=>1]);
	}
});
~~~
 

### 开源协议 

[LICENSE](LICENSE)
 
  
 