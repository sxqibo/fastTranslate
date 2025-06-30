<?php

namespace Sxqibo\FastTranslate\Translate;

use Sxqibo\FastTranslate\TranslateInterface;

/**
 * 谷歌翻译
 */
final class TranslateForGoogleV2 extends Translate implements TranslateInterface
{
    const TYPE = 'googleV2';

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
     */
    public function getTranslation(string $query, string $to): ?array
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
