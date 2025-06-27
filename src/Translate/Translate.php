<?php

namespace Sxqibo\FastTranslate\Translate;

use Sxqibo\FastTranslate\TranslateInterface;
use Google\Cloud\Translate\V2\TranslateClient;
use Google\Cloud\Translate\V3\TranslationServiceClient;
use Sxqibo\FastTranslate\Util\Common;

/**
 * 获取 IP 地址的基类
 */
abstract class Translate implements TranslateInterface
{
    /**
     * @var string 地址
     */
    public string $host = '';

    /**
     * @var string api 的 uri
     */
    public string $uri = '';



    /**
     * @var array 配置
     */
    public array $config = [];

    /**
     * 构造一般用于接收 http 请求时的参数
     * 比如 请求百度翻译接口时需要带 APP_ID 和 SEC_KEY
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * 帮子类调用 http 请求
     * @param string $word
     * @param string $from
     * @param string $to
     * @return mixed
     */
    public function getTranslate(string $word, string $from, string $to, $type = 'baidu')
    {
        $ret = [];
        $common = new Common();

        /**
         * 百度翻译
         */
        if ($type == 'baidu') {
            if (!$this->config['app_id']) {
                return '请配置 app_id';
            }

            if (!$this->config['sec_key']) {
                return '请配置 sec_key';
            }

            $args         = array(
                'q'     => $word,
                'appid' => $this->config['app_id'],
                'salt'  => rand(10000, 99999),
                'from'  => $from,
                'to'    => $to,

            );


            $args['sign'] = $common->buildSign($word, $this->config['app_id'], $args['salt'], $this->config['sec_key']);
            $ret          = $common->call($this->host . $this->uri, $args, $options); // 添加 $options 参数
            $ret          = json_decode($ret, true);

        }

        /**
         * 谷歌翻译
         */
        if ($type == 'googleV2') {
            if (!$this->config['api_key']) {
                return false;
            }

            $translate = new TranslateClient([
                'key' => $this->config['api_key'],
            ]);

            $result = $translate->translate($word, [
                'target' => $to,
            ]);

            $ret = $result['text'] ?? '';
        }

        /**
         * 谷歌翻译
         */
        if ($type == 'googleV3') {
            if (!$this->config['project_id']) {
                throw new \Exception('请配置 project_id');
            }

            // 这里只翻译一个
            $content[0] = $word;

            $translationClient = new TranslationServiceClient();
            $response = $translationClient->translateText(
                $content,
                $to,
                TranslationServiceClient::locationName($this->config['project_id'], 'global')
            );

            $result = [];
            foreach ($response->getTranslations() as $key => $translation) {
                array_push($result, $translation->getTranslatedText());
            }

            $ret = $result[0];

        }

        return $ret;

    }
}
