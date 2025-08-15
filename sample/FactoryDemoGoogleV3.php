<?php

require __DIR__ . '/../vendor/autoload.php';

use Sxqibo\FastTranslate\TranslateFactory;

// +----------------------------------------------------------------------
// | 三：谷歌翻译V3
// +----------------------------------------------------------------------

print '----------------------' . PHP_EOL;

// 设置 Google Cloud 认证凭据文件的绝对路径
$credentialsPath = __DIR__ . '/translate2025-464112-daa7d0598c52.json';
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $credentialsPath);

// 检查凭据文件是否存在
if (!file_exists($credentialsPath)) {
    die("错误：凭据文件不存在: {$credentialsPath}" . PHP_EOL);
}

$config = [
    'project_id' => 'translate2025-464112',
    // 可选：添加 HTTP 配置以处理网络问题
    'http_options' => [
        'timeout' => 30, // 30秒超时
        'connect_timeout' => 10, // 10秒连接超时
        // 如果需要代理，可以取消注释下面的行
        // 'proxy' => 'http://your-proxy:port',
    ]
];

$type = 'googleV3';

try {
    $obj = TranslateFactory::getTranslateObject($type, $config);
    
    // 源语言自动识别，翻译为英文
    // $addr = $obj->getTranslation('你好', 'en');
    // print '3-1.谷歌V3翻译结果' . json_encode($addr, JSON_UNESCAPED_UNICODE) . PHP_EOL;

    // 检测源语言
    print "正在检测语言..." . PHP_EOL;
    $detectResult = $obj->detectLanguage('Hola mundo');
    print '3-2.谷歌V3检测源语言' . json_encode($detectResult, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    
} catch (Exception $e) {
    print "错误：" . $e->getMessage() . PHP_EOL;
    
    if (strpos($e->getMessage(), 'Failed to connect') !== false) {
        print "网络连接失败。可能的原因：" . PHP_EOL;
        print "1. 网络连接问题" . PHP_EOL;
        print "2. 需要配置代理" . PHP_EOL;
        print "3. 防火墙阻止了连接" . PHP_EOL;
        print "4. Google Cloud 服务暂时不可用" . PHP_EOL;
    }
}



