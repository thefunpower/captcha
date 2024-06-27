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
    /**
     * 使用AK&SK初始化账号Client
     * @return Captcha Client
     */
    public static function createClient(){
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
 
    public static function main($your_value){
        $client = self::createClient();
        $verifyCaptchaRequest = new VerifyCaptchaRequest([
            "captchaVerifyParam" => $your_value
        ]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $res = $client->verifyCaptchaWithOptions($verifyCaptchaRequest, new RuntimeOptions([]));
            pr($res);
        }
        catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            return json_error(['msg'=>$error->message]);
        }
    }
} 

