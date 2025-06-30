<?php

namespace Sxqibo\FastTranslate;

/**
 * 翻译 统一都是用该方法名
 */
interface TranslateInterface
{/**
     * 翻译实现
     * @param string $query 翻译的文本
     * @param string $to 目标语言
     * @return mixed
     */
    public function getTranslation(string $query, string $to);

    /**
     * 检测语言
     * @param string $query
     * @return mixed
     */
    public function detectLanguage(string $query);
}
