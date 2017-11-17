<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/17 0017
 * Time: 下午 5:09
 */

namespace App\Handlers;


use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{
    public function translate($text)
    {
        // 获取 api 需要的 appid 和 key
        $appid = config('services.baidu_translate.app_id');
        $key = config('services.baidu_translate.key');

        // 如果没有配置百度翻译，自动使用兼容的拼音方案
        if (empty($appid) || empty($key)) {
            return $this->pinyin($text);
        }

        // 实例化http客户端
        $http = new Client();
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $salt = time();
        // appid+q+salt+密钥 的MD5值 生成 sign
        $sign = md5($appid . $text . $salt . $key);

        // 构造请求参数
        $query = http_build_query([
            "q"     => $text,
            "from"  => 'zh',
            "to"    => 'en',
            "appid" => $appid,
            "salt"  => $salt,
            "sign"  => $sign,
        ]);

        // 发送 get 请求
        $response = $http->get($api . $query);
        $result = json_decode($response->getBody(), true);

        // 尝试获取翻译结果
        if(isset($result['trans_result'][0]['dst'])){
            return str_slug($result['trans_result'][0]['dst']);
        }else{
            // 如果没有结果 使用拼音为后备方案
            return $this->pinyin($text);
        }
    }

    public function pinyin($text)
    {
        return app(Pinyin::class)->permalink($text);
    }
}