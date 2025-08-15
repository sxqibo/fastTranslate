<?php

require __DIR__ . '/../vendor/autoload.php';

use Sxqibo\FastTranslate\TranslateFactory;

// +----------------------------------------------------------------------
// | 二：谷歌翻译V2 (使用 API Key)
// +----------------------------------------------------------------------

print '----------------------' . PHP_EOL;

// 注意：Google V2 需要 API Key，请替换为你的实际 API Key
$config = [
    'api_key' => 'YOUR_GOOGLE_API_KEY_HERE', // 请替换为你的 Google API Key
];

$type = 'googleV2';

try {
    $obj = TranslateFactory::getTranslateObject($type, $config);
    
    // 检测源语言
    print "正在检测语言..." . PHP_EOL;
    $detectResult = $obj->detectLanguage('Hello world');
    print '2-1.谷歌V2检测源语言' . json_encode($detectResult, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    
    // 翻译文本
    print "正在翻译文本..." . PHP_EOL;
    $translateResult = $obj->getTranslation('Hello world', 'zh-CN');
    print '2-2.谷歌V2翻译结果' . json_encode($translateResult, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    
} catch (Exception $e) {
    print "错误：" . $e->getMessage() . PHP_EOL;
    
    if (strpos($e->getMessage(), 'YOUR_GOOGLE_API_KEY_HERE') !== false) {
        print "请配置正确的 Google API Key" . PHP_EOL;
        print "获取 API Key 的步骤：" . PHP_EOL;
        print "1. 访问 https://console.cloud.google.com/" . PHP_EOL;
        print "2. 启用 Cloud Translation API" . PHP_EOL;
        print "3. 创建凭据 > API Key" . PHP_EOL;
        print "4. 将 API Key 替换到代码中" . PHP_EOL;
    }
}
