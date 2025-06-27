<?php

namespace Sxqibo\FastTranslate\Translate;

use Sxqibo\FastTranslate\TranslateInterface;

/**
 * 谷歌翻译
 */
final class TranslateForGoogleV3 extends Translate implements TranslateInterface
{
    const TYPE = 'googleV3';

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * 获取翻译
     * @param string $query 查询
     * @param string $from 翻译源
     * @param string $to 翻译目标
     * @return null
     * @throws \Exception
     */
    public function getTranslation(string $query, string $from, string $to): ?array
    {
        return parent::getTranslate($query, '', $to, self::TYPE);
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
