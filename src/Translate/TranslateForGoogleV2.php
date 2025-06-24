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
    public function getTranslation(string $query, string $from, string $to): ?array
    {
        $result = parent::getTranslate($query, $from, $to, self::TYPE);

        // TODO 由于目前无法访问，这里的方法暂时不写

        return $result;
    }
}