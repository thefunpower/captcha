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



## 阿里云验证码（弃用） 

需要的逻辑是： 先JS前端自己验证，什么时候发送到服务端验证由业务确定。

截止2024年6月，无法通过JS自行验证，每次都需要发送到接口判断，无论用户是正确还是错误的都会计算次数。

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
 
  
 
