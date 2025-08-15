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
$addr = $obj->getTranslate('Estimado Seller de Amazon:
Este es el equipo del Servicio de atención al cliente de Amazon. Un cliente se puso en contacto con nosotros para hacernos algunas preguntas sobre una compra que te hizo. Esta es la descripción del problema:', 'auto', $type); // 源语言自动识别，翻译为英文
print '1.百度翻译结果' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;
