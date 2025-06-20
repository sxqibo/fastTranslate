<?php

namespace Sxqibo\FastTranslate\Translate;

use Sxqibo\FastTranslate\TranslateInterface;

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
     * @var int curl 超时时间
     */
    public int $curlTimeout = 10;

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
     * @param string $query
     * @param string $from
     * @param string $to
     * @return mixed
     */
    public function getTranslate(string $query, string $from, string $to)
    {
        $args         = array(
            'q'     => $query,
            'appid' => $this->config['app_id'],
            'salt'  => rand(10000, 99999),
            'from'  => $from,
            'to'    => $to,

        );
        $args['sign'] = $this->buildSign($query, $this->config['app_id'], $args['salt'], $this->config['sec_key']);
        $ret          = $this->call($this->host . $this->uri, $args);
        $ret          = json_decode($ret, true);
        return $ret;
    }

    /**
     * 加密
     * @param $query
     * @param $appID
     * @param $salt
     * @param $secKey
     * @return string
     */
    private function buildSign($query, $appID, $salt, $secKey): string
    {
        $str = $appID . $query . $salt . $secKey;
        $ret = md5($str);
        return $ret;
    }

    /**
     * 发起网络请求
     * @param $url
     * @param $args
     * @param $method
     * @param $testflag
     * @param $timeout
     * @param $headers
     * @return false|mixed
     */
    private function call($url, $args = null, $method = "post", $testflag = 0, $headers = array())
    {
        $ret = false;
        $i   = 0;
        while ($ret === false) {
            if ($i > 1)
                break;
            if ($i > 0) {
                sleep(1);
            }
            $ret = $this->callOnce($url, $args, $method, false, $headers);
            $i++;
        }
        return $ret;
    }

    private function callOnce($url, $args = null, $method = "post", $withCookie = false, $headers = array())
    {/*{{{*/
        $ch = curl_init();
        if ($method == "post") {
            $data = $this->convert($args);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_POST, 1);
        } else {
            $data = $this->convert($args);
            if ($data) {
                if (stripos($url, "?") > 0) {
                    $url .= "&$data";
                } else {
                    $url .= "?$data";
                }
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->curlTimeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if ($withCookie) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $_COOKIE);
        }
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }


    /**
     * 参数转换
     * @param $args
     * @return string
     */
    private function convert(&$args): string
    {
        $data = '';
        if (is_array($args)) {
            foreach ($args as $key => $val) {
                if (is_array($val)) {
                    foreach ($val as $k => $v) {
                        $data .= $key . '[' . $k . ']=' . rawurlencode($v) . '&';
                    }
                } else {
                    $data .= "$key=" . rawurlencode($val) . "&";
                }
            }
            return trim($data, "&");
        }
        return $args;
    }
}
