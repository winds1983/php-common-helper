<?php

namespace Hive\Helper;

class HttpHelper
{
    /**
     * Get server protocol
     * @return string http/https
     */
    public static function getServerProtocol()
    {
        $serverProtocol = 'http';

        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)
            || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $serverProtocol = 'https';
        }

        return $serverProtocol;
    }

    /**
     * Get real IP address
     *
     * @link https://stackoverflow.com/questions/13646690/how-to-get-real-ip-from-visitor
     *       http://itman.in/en/how-to-get-client-ip-address-in-php/
     *
     * @return string
     */
    public static function getRealIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * 检查链接中是包含http://或https://
     * @param string $url
     * @return false|int
     */
    public static function isContainsHttp($url)
    {
        $preg = "/^http(s)?:\\/\\/.+/";
        return preg_match($preg, $url);
    }

    /**
     * 说明：判断是否为合法的ip地址
     * 判断是否为合法的ip地址
     * @param string $ip ip地址
     * @return bool|int 不合法则返回false，合法则返回4（IPV4）或6（IPV6）
     */
    public static function isIpAddress(string $ip)
    {
        $ipv4Regex = '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/';

        $ipv6Regex = '/^(((?=.*(::))(?!.*\3.+\3))\3?|([\dA-F]{1,4}(\3|:\b|$)|\2))(?4){5}((?4){2}|(((2[0-4]|1\d|[1-9])?\d|25[0-5])\.?\b){4})$/i';

        if (preg_match($ipv4Regex, $ip)) {
            return 4;
        }

        if (false !== strpos($ip, ':') && preg_match($ipv6Regex, trim($ip, ' []'))) {
            return 6;
        }

        return false;
    }
}
