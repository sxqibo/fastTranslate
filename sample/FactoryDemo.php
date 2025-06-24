<?php

require __DIR__ . '/../vendor/autoload.php';

use Sxqibo\FastTranslate\TranslateFactory;


// +----------------------------------------------------------------------
// | 一：百度翻译
// +----------------------------------------------------------------------

print '----------------------' . PHP_EOL;
$config  = [
    'app_id'  => '',
    'sec_key' => ''
];
$type = 'baidu';
$obj  = TranslateFactory::getTranslateObject($type, $config);
$addr = $obj->getTranslate('你好', 'auto', 'en', $type); // 源语言自动识别，翻译为英文
print '1.百度翻译结果' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;


// +----------------------------------------------------------------------
// | 二：谷歌翻译V2
// +----------------------------------------------------------------------

print '----------------------' . PHP_EOL;
$config  = [
    'api_key'  => ''
];

$type = 'googleV2';
$obj  = TranslateFactory::getTranslateObject($type, $config);
$addr = $obj->getTranslate('你好', 'auto', 'en', $type); // 源语言自动识别，翻译为英文
print '2.谷歌翻译结果' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;
