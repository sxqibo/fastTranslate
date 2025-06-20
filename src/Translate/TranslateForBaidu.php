<?php

namespace Sxqibo\FastTranslate\Translate;

use Sxqibo\FastTranslate\TranslateInterface;

/**
 * 百度接口的实现类
 * https://qifu-api.baidubce.com/ip/geo/v1/district?ip=39.144.96.133
 */
final class TranslateForBaidu extends Translate implements TranslateInterface
{
    /**
     * @var string ip地址 或 主机地址
     */
    const HOST = 'http://api.fanyi.baidu.com';

    /**
     * @var string api 的 uri
     */
    const URI = '/api/trans/vip/translate';

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->host = self::HOST;
        $this->uri = self::URI;
    }

    /**
     * 获取翻译
     * @param string $query 查询
     * @param string $from 翻译源
     * @param string $to 翻译目标
     * @return null
     */
    public function getTranslate(string $query, string $from, string $to)
    {
        $result = parent::getTranslate($query,  $from, $to);

        return $this->standardResult($result);
    }

    /**
     * 对请求结果的处理
     * @param string $result 请求结果
     * @return void
     */
    private function standardResult(array $result)
    {
        return [
            'language_from' => $result['from'],
            'language_to' => $result['to'],
            'result_src' => $result['trans_result'][0]['src'],
            'result_dst' => $result['trans_result'][0]['dst'],
        ];

    }
}
