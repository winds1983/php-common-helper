<?php

namespace Hive\Helper;

class ArrayHelper
{
    /**
     * Save array to php file and var_export() with square brackets and indented 4 spaces.
     * @param array $expression
     * @return mixed|string
     */
    public static function varExport(array $expression)
    {
        $export = var_export($expression, true);
        $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
        $array = preg_split("/\r\n|\n|\r/", $export);
        $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [null, ']$1', ' => ['], $array);
        $export = join(PHP_EOL, array_filter(["["] + $array));

        return $export;
    }
}
