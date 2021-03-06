<?php

namespace Hive\Helper;

/**
 * @link https://blog.csdn.net/m0_50593634/article/details/124451681
 */
class StringHelper
{
    /**
     * Replace non-alphanumeric and non-numeric characters
     * @param string $str
     * @return string
     */
    public static function formatAlias(string $str): string
    {
        if (preg_match('/\W+/', $str)) {
            $str = preg_replace('/\W+/', '-', $str);
        }
        return $str;
    }

    /**
     * Generate random password
     *
     * @param integer $charsMin
     * @param integer $charsMax
     * @param boolean $useUppercase
     * @param boolean $includeNumbers
     * @param boolean $includeSpecialChars
     * @return string
     */
    public static function generateRandomPassword(int $charsMin = 6, int $charsMax = 8, bool $useUppercase = false, bool $includeNumbers = false, bool $includeSpecialChars = false): string
    {
        $length = rand($charsMin, $charsMax);
        $selection = 'abcdefghijklmnopqrstuvwxyz';

        if ($includeNumbers) {
            $selection .= '1234567890';
        }

        if ($includeSpecialChars) {
            $selection .= "!@\"#$%&[]{}?|";
        }

        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $current_letter = $useUppercase ? (rand(0, 1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
            $password .= $current_letter;
        }

        return $password;
    }

    /**
     * Get first line
     *
     * https://stackoverflow.com/questions/9097682/obtain-first-line-of-a-string-in-php
     *
     * @param string $input
     *
     * @return string
     */
    public static function getFirstLine($input)
    {
        return strtok($input, "\n");
    }

    /**
     * Slugify text
     *
     * @param string $text
     *
     * @return string
     */
    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * ?????????????????????????????????**
     *
     * @param string $str ?????????????????????
     * @param int $startLen ???????????? ??????4
     * @param int $endLen ???????????? ??????3
     *
     * @return string
     */
    public static function replaceNumberToAsterisk($str, $startLen = 2, $endLen = 2)
    {
        $repStr = "";
        if (strlen($str) < ($startLen + $endLen + 1)) {
            return $str;
        }
        $count = strlen($str) - $startLen - $endLen;
        for ($i = 0; $i < $count; $i++) {
            $repStr .= "*";
        }
        return preg_replace('/(\d{' . $startLen . '})\d+(\d{' . $endLen . '})/', '${1}' . $repStr . '${2}', $str);
    }

    /**
     * ????????????* ??????????????????* ??????????????????????????? ??????????????????
     *
     * @param string $str ?????????
     * @param string $start ???????????????????????????
     * @param string $len ?????????????????????
     * @param string $symbol ???????????????  ??????*???#???
     *
     * @return string
     */
    public static function replaceStringToAsterisk($str, $start, $len, $symbol = '*')
    {
        $end = $start + $len;
        // ????????????????????????
        $str1 = mb_substr($str, 0, $start);
        // ????????????????????????
        $str2 = mb_substr($str, $end);

        //  ????????????????????????
        $symbol_num = '';
        for ($i = 0; $i < $len; $i++) {
            $symbol_num .= $symbol;
        }
        return $str1 . $symbol_num . $str2;
    }

    /**
     * Replace string params
     *
     * @param string $str
     * @param array $params
     *
     * @return string
     */
    public static function replaceStringParameters($str, $params)
    {
        if ($params) {
            foreach ($params as $key => $value) {
                $str = str_replace('{' . $key . '}', $value, $str);
            }
        }

        return $str;
    }

    /**
     * Release special characters
     * https://blog.csdn.net/get_current_user/article/details/51077015
     * @param string $str
     * @param string $delimiter
     * @return string
     */
    public static function replaceSpecialCharacters($str, $delimiter = '_')
    {
        return preg_replace("/[^\x{4e00}-\x{9fa5}^0-9^A-Z^a-z]+/u", $delimiter, $str);
    }

    /**
     * Get string length
     * @param string $str
     * @return false|int
     */
    public static function getStringLength($str)
    {
        return mb_strlen($str, "utf-8");
    }

    /**
     * Check if it is valid email address
     * @param string $email
     * @return bool
     */
    public static function isValidEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * ???????????????????????????
     * @return  boolean
     */
    public static function isMobile()
    {

        $sp_is_mobile = false;

        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            $sp_is_mobile = false;
        } elseif (
            strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false
        ) {
            $sp_is_mobile = true;
        } else {
            $sp_is_mobile = false;
        }

        return $sp_is_mobile;
    }

    /**
     * ???????????????????????????
     * @return boolean
     */
    public static function isWeiXin()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        }
        return false;
    }


    /**
     * ????????????????????????
     * @param $mobile ????????????
     */
    public static function isValidMobile($mobile)
    {
        if (preg_match('/1[0123456789]\d{9}$/', $mobile)) {
            return true;
        }
        return false;
    }


    /**
     * ??????????????????
     * @param $mobile
     * @return bool
     */
    public static function isValidTelephone($mobile)
    {
        if (preg_match('/^([0-9]{3,4}-)?[0-9]{7,8}$/', $mobile)) {
            return true;
        }
        return false;
    }

    /**
     * ?????????????????????https
     * @return bool
     */
    public static function isHttps()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off';
    }
}
