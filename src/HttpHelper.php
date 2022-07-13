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
}
