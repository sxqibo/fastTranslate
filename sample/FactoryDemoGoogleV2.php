<?php

require __DIR__ . '/../vendor/autoload.php';

use Sxqibo\FastTranslate\TranslateFactory;


// +----------------------------------------------------------------------
// | 二：谷歌翻译V2
// +----------------------------------------------------------------------

print '----------------------' . PHP_EOL;
$config  = [
    'api_key'  => ''
];

$type = 'googleV3';
$obj  = TranslateFactory::getTranslateObject($type, $config);
$addr = $obj->getTranslate('你好', '', 'en', $type); // 源语言自动识别，翻译为英文
print '2.谷歌V2翻译结果' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;
