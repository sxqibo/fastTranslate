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


// 源语言自动识别，翻译为英文
$addr = $obj->getTranslate('你好', 'en', $type);
print '3-1.谷歌V3翻译结果' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;


// 检测源语言
$detectResult = $obj->detect('Hola! Necesito saber en qué oficina se encuentra el paquete, ya que hay varias en el lugar donde resido y no se especifica nada en la web. He ido a algunas y no se encuentra ahí ', $type);
print '3-2.谷歌V3检测源语言' . json_encode($detectResult, JSON_UNESCAPED_UNICODE) . PHP_EOL;



