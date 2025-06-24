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
优点： 谷歌翻译可以翻译，但识别源语言的接口特别多   
缺点： 谷歌翻译V2需要api_key，本地测试需要翻墙， 需要信用卡配额（网址：https://console.cloud.google.com/billing）

示例：

```php
$config  = [
    'api_key'  => ''
];

$type = 'googleV2';
$obj  = TranslateFactory::getTranslateObject($type, $config);
$addr = $obj->getTranslate('你好', 'zh', 'en', $type);
```