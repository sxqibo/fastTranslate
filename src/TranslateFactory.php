<?php

namespace Sxqibo\FastTranslate;

/**
 * 工厂类
 */
class TranslateFactory
{
    /**
     * 类的命名空间
     */
    const CLASS_PREFIX = '\\Sxqibo\\FastTranslate\\Translate\\TranslateFor';

    /**
     * 所在的目录
     */
    const DIR = __DIR__ . '/Translate/';

    /**
     * 获取具体翻译的类实例
     * 如果没有找到传入的类，则默认返回Baidu
     *
     * @param string $objectName 默认百度翻译
     * @param array $config 配置
     * @return \|mixed|null
     */
    public static function getTranslateObject(string $objectName = 'baidu', array $config = [])
    {
        // 首字母变大写
        $objectName = ucfirst($objectName);

        // 拼接完整的类文件
        $fileName = 'TranslateFor' . $objectName . '.php';

        // 拼接类路径
        $dir = self::DIR;

        // 保存类的完全限定名
        $class = '';

        $handle = dir($dir);

        // 便利具体实现类的目录，查找是否有对应的类
        while(false !== ($entry = $handle->read())) {
            if($entry != '.' && $entry != '..') {
                if(!is_dir($dir . $entry) && $entry == $fileName) {
                    // 拼接类的完全限定名
                    $class = self::CLASS_PREFIX . $objectName;
                    break;
                }
            }
        }

        $handle->close();

        // 找到则实例化请求的类
        if ($class != '') {
            return new $class($config);
        }

        // 没有找到则实现一个默认的类
        // 默认的类使用的是百度的类
        $class = self::CLASS_PREFIX . 'Baidu';

        return new $class($config);
    }
}
