<?php

namespace Sxqibo\FastTranslate\Translate;

use Sxqibo\FastTranslate\TranslateInterface;

/**
 * 百度接口的实现类
 * @doc https://api.fanyi.baidu.com/doc/21
 */
final class TranslateForBaidu extends Translate implements TranslateInterface
{
    const TYPE = 'baidu';

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * 获取翻译
     * @param string $query 查询
     * @param string $to 翻译目标
     * @return array|null
     * @throws \Exception
     */
    public function getTranslation(string $query, string $to): ?array
    {
        $result = parent::getTranslate($query, $to, self::TYPE);

        return  [
            'language_from' => $result['from'],
            'language_to'   => $result['to'],
            'result_src'    => $result['trans_result'][0]['src'],
            'result_dst'    => $result['trans_result'][0]['dst'],
        ];

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
