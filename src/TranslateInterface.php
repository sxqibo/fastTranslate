<?php

namespace Sxqibo\FastTranslate;

/**
 * 翻译 统一都是用该方法名
 */
interface TranslateInterface
{
    /**
     * 翻译实现
     * @param string $query 翻译的文本
     * @param string $from 源语言
     * @param string $to 目标语言
     * @return mixed
     */
    public function getTranslate(string $query, string $from, string $to);
}
