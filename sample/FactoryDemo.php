<?php

require __DIR__ . '/../vendor/autoload.php';

use Sxqibo\FastTranslate\TranslateFactory;

// 百度参数
$appcode = 'bbfde90143774b919e00c13ea8a52efe';
$config  = [
    'app_id'  => '',
    'sec_key' => ''

];

$query = '你好';
$from = 'auto';
$to = 'en';

print '----------------------' . PHP_EOL;
$obj  = TranslateFactory::getTranslateObject('baidu', $config);
$addr = $obj->getTranslate($query, $from, $to);
print '1.百度翻译结果' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;