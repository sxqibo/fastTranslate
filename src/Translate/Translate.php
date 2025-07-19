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
     * @var array 配置
     */
    public array $config = [];

    /**
     * 语言代码映射表
     * @doc https://cloud.google.com/translate/docs/languages?hl=zh-cn#adaptive_translation
     * @var array
     */
    private array $languageMap = [
        'ar' => '阿拉伯语',
        'bn' => '孟加拉语',
        'bg' => '保加利亚语',
        'ca' => '加泰罗尼亚语',
        'zh-CN' => '简体中文',
        'hr' => '克罗地亚语',
        'cs' => '捷克语',
        'da' => '丹麦语',
        'nl' => '荷兰语',
        'en' => '英语',
        'et' => '爱沙尼亚语',
        'fi' => '芬兰语',
        'fr' => '法语',
        'de' => '德语',
        'el' => '希腊语',
        'gu' => '古吉拉特语',
        'he' => '希伯来语',
        'hi' => '印地语',
        'hu' => '匈牙利语',
        'is' => '冰岛语',
        'id' => '印度尼西亚语',
        'it' => '意大利语',
        'ja' => '日语',
        'kn' => '卡纳达语',
        'ko' => '韩语',
        'lv' => '拉脱维亚语',
        'lt' => '立陶宛语',
        'ml' => '马拉雅拉姆语',
        'mr' => '马拉地语',
        'no' => '挪威语',
        'fa' => '波斯语',
        'pl' => '波兰语',
        'pt' => '葡萄牙语',
        'pa' => '旁遮普语',
        'ro' => '罗马尼亚语',
        'ru' => '俄语',
        'sk' => '斯洛伐克语',
        'sl' => '斯洛文尼亚语',
        'es' => '西班牙语',
        'sw' => '斯瓦希里语',
        'sv' => '瑞典语',
        'ta' => '泰米尔语',
        'te' => '泰卢固语',
        'th' => '泰语',
        'tr' => '土耳其语',
        'uk' => '乌克兰语',
        'ur' => '乌尔都语',
        'vi' => '越南语',
        'zu' => '祖鲁语'
    ];

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
     * @param string $to
     * @return mixed
     */
    public function getTranslate(string $word, string $to, $type = 'baidu')
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
                'from'  => 'auto',
                'to'    => $to,

            );

            $args['sign'] = $common->buildSign($word, $this->config['app_id'], $args['salt'], $this->config['sec_key']);
            $ret          = $common->call('http://api.fanyi.baidu.com/api/trans/vip/translate', $args); // 通用翻译

            // 结果为N个数组的合并
            $resource = '';
            $result = '';
            $ret = json_decode($ret, JSON_UNESCAPED_UNICODE);
            if (isset($ret['trans_result']) && is_array($ret['trans_result']) ) {
                foreach ($ret['trans_result'] as $k => $v) {
                    $result .= $v['dst'];
                    $resource .= $v['src'];
                }
            }
            $ret['trans_result_all'] = $result;
            $ret['trans_resource_all'] = $resource;
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

            $ret = $translate->translate($word, [
                'target' => $to,
            ]);
        }

        /**
         * 谷歌翻译
         */
        if ($type == 'googleV3') {
            if (!$this->config['project_id']) {
                throw new \Exception('请配置 project_id');
            }

            // 支持多文本翻译
            $content = is_array($word) ? $word : [$word];

            // 配置请求头和客户端选项
            $clientConfig = [];
            if (isset($this->config['http_options'])) {
                $clientConfig = $this->config['http_options'];
            }
                
            // 添加 Referer 请求头（如果未设置）
            if (!isset($clientConfig['headers']['Referer'])) {
                $clientConfig['headers']['Referer'] = $this->config['referer'] ?? 'https://example.com';
            }

            $translationClient = new TranslationServiceClient($clientConfig);
            $response = $translationClient->translateText(
                $content,
                $to,
                TranslationServiceClient::locationName($this->config['project_id'], 'global')
            );

            $result = [];
            foreach ($response->getTranslations() as $key => $translation) {
                $result[] = $translation->getTranslatedText();
            }
            $ret['text'] = $result[0];
        }

        return $ret;
    }


    /**
     * 获取语言
     * @param string $word
     * @return mixed
     */
    public function detect(string $word, $type = 'baidu')
    {
        /**
         * 百度翻译
         */
        if ($type == 'baidu') {
            $ret = 'baidu none';
        }

        /**
         * 谷歌翻译V2
         */
        if ($type == 'googleV2') {
            $ret = 'googleV2 none';

        }

        /**
         * 谷歌翻译V3
         */
        if ($type == 'googleV3') {
            if (!$this->config['project_id']) {
                throw new \Exception('请配置 project_id');
            }

            $translate = new TranslateClient();
            $ret = $translate->detectLanguage($word);

            $ret['language_ch'] = $this->getLanguageName($ret['languageCode']);
        }

        return $ret;
    }

    /**
     * 根据语言代码获取语言名称
     * @param string $code
     * @return string|null
     */
    public function getLanguageName(string $code): ?string
    {
        return $this->languageMap[$code] ?? null;
    }

    /**
     * 根据语言名称获取语言代码
     * @param string $name
     * @return string|null
     */
    public function getLanguageCode(string $name): ?string
    {
        foreach ($this->languageMap as $code => $language) {
            if ($language === $name) {
                return $code;
            }
        }
        return null;
    }
}
