<?php

namespace Hive\Helper;

class StringHelper
{
    /**
     * replace non-alphanumeric and non-numeric characters
     *
     * @param string $str
     *
     * @return string
     */
    public static function formatAlias($str)
    {
        if (preg_match('/\W+/', $str)) {
            $str = preg_replace('/\W+/', '-', $str);
        }
        return $str;
    }

    /**
     * generate random password
     *
     * @param integer $chars_min
     * @param integer $chars_max
     * @param boolean $use_upper_case
     * @param boolean $include_numbers
     * @param boolean $include_special_chars
     * @return string
     */
    public static function generateRandomPassword($chars_min = 6, $chars_max = 8, $use_upper_case = false, $include_numbers = false, $include_special_chars = false)
    {
        $length = rand($chars_min, $chars_max);
        $selection = 'abcdefghijklmnopqrstuvwxyz';

        if ($include_numbers) {
            $selection .= '1234567890';
        }

        if ($include_special_chars) {
            $selection .= "!@\"#$%&[]{}?|";
        }

        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $current_letter = $use_upper_case ? (rand(0, 1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
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
     * 替换银行卡、手机号码为**
     *
     * @param string $str 要替换的字符串
     * @param int $startLen 开始长度 默认4
     * @param int $endLen 结束长度 默认3
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
     * 名字替换* 电话号码替换* 可以自定义替换符号 通用替换方法
     *
     * @param string $str 字符串
     * @param string $start 替换字符的开始文字
     * @param string $len 替换字符的长度
     * @param string $symbol 替换的字符  例如*、#等
     *
     * @return string
     */
    public static function replaceStringToAsterisk($str, $start, $len, $symbol = '*')
    {
        $end = $start + $len;
        // 截取头保留的字符
        $str1 = mb_substr($str, 0, $start);
        // 截取尾保留的字符
        $str2 = mb_substr($str, $end);

        //  生产要替换的字符
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
}
