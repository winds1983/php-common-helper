<?php

namespace Hive\Helper;

class FileHelper
{
    /**
     * Create directory
     * @param string $path
     * @return string
     */
    public static function createDirectory(string $path): string
    {
        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }

        return $path;
    }

    /**
     * Generate random file name
     * @return string
     */
    public static function generateRandomFileName(): string
    {
        return md5(uniqid() . rand(1000, 9999));
    }

    /**
     * Get remote file data
     * @param string $url
     * @return bool|string
     */
    public static function getRemoteFileData(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // If you comment out this line, it would direct output
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
