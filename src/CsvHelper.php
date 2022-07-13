<?php

namespace Hive\Helper;

class CsvHelper
{
    /**
     * Convert CSV data as array
     *
     * @param array $data
     * @param string $delimiter
     * @param string $enclosure
     * @param bool $skipsFirstLine
     *
     * @return array
     */
    public static function convertCsvDataToArray($data, $delimiter = ',', $enclosure = '"', $skipsFirstLine = true)
    {
        $csvHeader = isset($data[0]) ? $data[0] : [];
        $csvData = [];

        $firstLine = $skipsFirstLine ? 1 : 0;

        // This skips the first line of your csv file, since it will probably be a heading. Set $i = 0 to not skip the first line.
        for ($i = $firstLine; $i < count($data); $i++) {
            // $data[$i] is an array with your csv columns as values.
            $_csvData = [];
            for ($j = 0; $j < count($data[$i]); $j++) {
                $_csvData[$csvHeader[$j]] = $data[$i][$j];
            }
            $csvData[] = $_csvData;
        }

        return $csvData;
    }

    public static function exportToCsv($data, $filename, $filePath, $headerLabels)
    {
        // https://www.yiiframework.com/wiki/667/yii-2-list-of-path-aliases-available-with-default-basic-and-advanced-app
        $directory = \Yii::getAlias('@runtime');

        $exportDir = $directory . '/' . $filePath;
        if (!is_dir($exportDir)) {
            @mkdir($exportDir, 0777, true);
        }

        $filePath = $exportDir . '/' . $filename;
        $fileHandle = fopen($filePath, "w") or die("Unable to open file!");

        // Set CSV header
        fputcsv($fileHandle, $headerLabels);

        // Write product data to row
        $index = 1;
        foreach ($data as $item) {
            if ($item) {
                $birthDate = substr($item['id'], 6, 8);
                if ($birthDate >= '19250601' && $birthDate <= '20000630') {
                    $item['no'] = $index;
                    fputcsv($fileHandle, $item);
                    $index++;
                }
            }
        }

        fclose($fileHandle);
    }
}
