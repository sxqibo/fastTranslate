<?php

require __DIR__ . '/../vendor/autoload.php';

use Sxqibo\FastTranslate\TranslateFactory;


// +----------------------------------------------------------------------
// | 三：谷歌翻译V2
// +----------------------------------------------------------------------

print '----------------------' . PHP_EOL;

putenv('GOOGLE_APPLICATION_CREDENTIALS=./translate2025-464112-dfb3d1d06960.json');


$config  = [
    'project_id'  => 'translate2025-464112'
];

$type = 'googleV3';
$obj  = TranslateFactory::getTranslateObject($type, $config);
$addr = $obj->getTranslate('你好', '', 'en', $type); // 源语言自动识别，翻译为英文
print '3.谷歌V3翻译结果' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;
