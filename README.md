# fastTranslate

说明： 集成 百度翻译、谷歌翻译 的包管理！

## 百度翻译

网址： https://api.fanyi.baidu.com/doc/21  
优点：百度翻译可以翻译  
缺点：识别源语言的接口特别有限  

示例：

```php
$config  = [
    'app_id'  => '',
    'sec_key' => ''
];
$type = 'baidu';
$obj  = TranslateFactory::getTranslateObject($type, $config);
$addr = $obj->getTranslate('你好', 'auto', 'en', $type); 
```


## 谷歌翻译V2示例

网址：https://console.cloud.google.com/  
文档：https://cloud.google.com/translate/docs/
优点： 谷歌翻译可以翻译，但识别源语言的接口特别多   
缺点： 谷歌翻译V2需要api_key，本地测试需要翻墙， 需要信用卡配额, 网址：https://console.cloud.google.com/billing  
说明： 谷歌翻译配置比较麻烦，需要创建项目，绑定支付账号， 申请api_key
示例：

```php
$config  = [
    'api_key'  => ''
];

$type = 'googleV2';
$obj  = TranslateFactory::getTranslateObject($type, $config);
$addr = $obj->getTranslate('你好', '', 'en', $type);
```
返回
```json
{
  "source" : "zh-CN",
  "input" : "你好",
  "text" : "Hello",
  "model" : ""
}
```

说明： 谷歌翻译原生curl请求  
```curl
curl -X POST "https://translation.googleapis.com/language/translate/v2?key=API_KEY" \
       -H "Content-Type: application/json" \
       -d '{
             "q": "你好",
             "target": "en"
           }'
```
原生返回：  
```json

{
  "data": {
    "translations": [
      {
        "translatedText": "Hello",
        "detectedSourceLanguage": "zh-CN"
      }
    ]
  }
}

```


## 谷歌翻译V3示例

文档：https://cloud.google.com/php/docs/reference/cloud-translate/latest 

创建服务账号并下载 JSON 凭据：

打开 Google Cloud 控制台：https://console.cloud.google.com/iam-admin/serviceaccounts

创建一个服务账号，并授予所需的权限（如翻译 API 权限）。

创建密钥，选择 JSON 格式并下载。