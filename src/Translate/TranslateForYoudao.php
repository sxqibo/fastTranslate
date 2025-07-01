<?php
namespace Sxqibo\FastTranslate\Translate;

use Sxqibo\FastTranslate\TranslateInterface;

/**
 * 友道翻译
 */
final class TranslateForYoudao extends Translate implements TranslateInterface
{

    const TYPE = 'youdao';

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * 获取翻译
     * @param string $query 翻译的文本
     * @param string $to 翻译的目标语言
     * @return array|false|mixed|string
     * @throws \Exception
     */
    public function getTranslation(string $query, string $to)
    {
        return parent::getTranslate($query, $to, self::TYPE);
    }

    /**
     * 获取语言
     * @param string $query
     * @return mixed
     * @throws \Exception
     */
    public function detectLanguage(string $query)
    {
        return parent::detect($query, self::TYPE);
    }
}
