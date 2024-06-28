<?php 
namespace captcha; 

use AlibabaCloud\SDK\Captcha\V20230305\Captcha;
use \Exception;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils; 
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Captcha\V20230305\Models\VerifyCaptchaRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions; 
class Aliyun { 
    public static $form = 'form'; 
    /**
     * 使用AK&SK初始化账号Client
     * @return Captcha Client
     */
    public static function init(){
        // 工程代码泄露可能会导致 AccessKey 泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考。
        // 建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html。
        $config = new Config([
            // 必填，请确保代码运行环境设置了环境变量 ALIBABA_CLOUD_ACCESS_KEY_ID。
            "accessKeyId" => get_config("alibaba_cloud_access_key_id"),
            // 必填，请确保代码运行环境设置了环境变量 ALIBABA_CLOUD_ACCESS_KEY_SECRET。
            "accessKeySecret" => get_config("alibaba_cloud_access_key_secret")
        ]);
        // Endpoint 请参考 https://api.aliyun.com/product/captcha
        $config->endpoint = get_config("alibaba_cloud_endpoint")?:"captcha.cn-shanghai.aliyuncs.com";
        return new Captcha($config);
    }
 
    public function check($ignore_expire = false){
        $client = self::init();
        $your_value = $_POST['aliyun_cap'];  
        $verifyCaptchaRequest = new VerifyCaptchaRequest([
            "captchaVerifyParam" => $your_value
        ]); 
        try {
            // 复制代码运行请自行打印 API 的返回值
            $resp = $client->verifyCaptchaWithOptions($verifyCaptchaRequest, new RuntimeOptions([]));
            $captchaVerifyResult = $resp->body->result->verifyResult;
            // 原因code
            $captchaVerifyCode = $resp->body->result->verifyCode; 
            if($captchaVerifyResult){
                return;
            }else{
                return json_error(['msg'=>'验证失败']);
            }
        }
        catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            return json_error(['msg'=>$error->message]);
        }
    }

    public function get(){
        return [
            'button'=>$this->button(),
            'js_file'=>$this->js_file(),
            'js_code'=>$this->js_code(),
        ];
    }

    public function button($str = ''){
        return '<div id="t_captcha_input"  style="display:none;" >登录</div>';
    }

    public function js_file(){
        return '<script src="https://o.alicdn.com/captcha-frontend/aliyunCaptcha/AliyunCaptcha.js"></script>';
    }

    public function js_code(){
        $form = self::$form;
        $captcha_app_id = get_config('alibaba_cloud_access_key_id');
        if(!$captcha_app_id){
            echo "alibaba_cloud_access_key_id 未配置";
            exit;
        }
        echo $this->js_file(); 
        ?>
        <script>  
              let captcha;
              // 弹出式
              initAliyunCaptcha({
                SceneId: '<?=get_config('alibaba_cloud_captcha_scene_id')?>', // 场景ID。根据步骤二新建验证场景后，您可以在验证码场景列表，获取该场景的场景ID
                prefix: '<?=get_config('alibaba_cloud_captcha_prefix')?>', // 身份标。开通阿里云验证码2.0后，您可以在控制台概览页面的实例基本信息卡片区域，获取身份标
                mode: 'popup', // 验证码模式。popup表示要集成的验证码模式为弹出式。无需修改
                element: '#captcha-element', //页面上预留的渲染验证码的元素，与原代码中预留的页面元素保持一致。
                button: '#t_captcha_input', // 触发验证码弹窗的元素。button表示单击登录按钮后，触发captchaVerifyCallback函数。您可以根据实际使用的元素修改element的值
                captchaVerifyCallback: captchaVerifyCallback, // 业务请求(带验证码校验)回调函数，无需修改
                onBizResultCallback: onBizResultCallback, // 业务请求结果回调函数，无需修改
                getInstance: getInstance, // 绑定验证码实例函数，无需修改
                slideStyle: {
                  width: 360,
                  height: 40,
                }, // 滑块验证码样式，支持自定义宽度和高度，单位为px。其中，width最小值为320 px
                language: 'cn', // 验证码语言类型，支持简体中文（cn）、繁体中文（tw）、英文（en）
                region: 'cn' //验证码示例所属地区，支持中国内地（cn）、新加坡（sgp）
              });

              // 绑定验证码实例函数。该函数为固定写法，无需修改
              function getInstance(instance) {
                captcha = instance;
              }

              // 业务请求(带验证码校验)回调函数
              /**
               * @name captchaVerifyCallback
               * @function
               * 请求参数：由验证码脚本回调的验证参数，不需要做任何处理，直接传给服务端即可
               * @params {string} captchaVerifyParam
               * 返回参数：字段名固定，captchaResult为必选；如无业务验证场景时，bizResult为可选
               * @returns {{captchaResult: boolean, bizResult?: boolean|undefined}} 
               */
              async function captchaVerifyCallback(captchaVerifyParam) {  
                let flag = false;
                app.form.aliyun_cap = captchaVerifyParam;
                app.after_captcha(); 
                const verifyResult = {
                  captchaResult: flag, // 验证码验证是否通过，boolean类型，必选
                  bizResult: '', // 业务验证是否通过，boolean类型，可选；若为无业务验证结果的场景，bizResult可以为空
                };
                if(flag){
                    app.form.aliyun_cap = captchaVerifyParam;
                    
                }
                return verifyResult;
              }

              // 业务请求验证结果回调函数
              function onBizResultCallback(bizResult) {
                 
              } 
      </script>
      <?php 
    }

} 

