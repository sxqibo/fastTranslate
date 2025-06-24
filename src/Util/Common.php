<?php

namespace Sxqibo\FastTranslate\Util;

class Common
{
    /**
     * @var int curl 超时时间
     */
    public int $curlTimeout = 10;

    /**
     * 加密
     * @param $query
     * @param $appID
     * @param $salt
     * @param $secKey
     * @return string
     */
    public function buildSign($query, $appID, $salt, $secKey): string
    {
        $str = $appID . $query . $salt . $secKey;
        $ret = md5($str);
        return $ret;
    }

    /**
     * 发起请求
     * @param $url
     * @param array $postData
     * @param array $options
     * @return mixed
     */
    public function call($url, $postData = [], $options = [])
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'form_params' => $postData,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            // 合并自定义选项，如代理设置
            ...$options
        ]);

        return $response->getBody()->getContents();
    }

    public function callOnce($url, $args = null, $method = "post", $withCookie = false, $headers = array())
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