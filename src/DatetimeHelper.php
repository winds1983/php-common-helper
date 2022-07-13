<?php

namespace Hive\Helper;

class DatetimeHelper
{
    /**
     * @link https://github.com/anerg2046/helper/blob/master/src/Time.php
     * @param string $time
     * @return false|string
     */
    public static function pretty($time)
    {
        $return = '';
        if (!is_numeric($time)) {
            $time = strtotime($time);
        }
        $htime = date('H:i', $time);
        $dif   = abs(time() - $time);
        if ($dif < 10) {
            $return = '刚刚';
        } else if ($dif < 3600) {
            $return = floor($dif / 60) . '分钟前';
        } else if ($dif < 10800) {
            $return = floor($dif / 3600) . '小时前';
        } else if (date('Y-m-d', $time) == date('Y-m-d')) {
            $return = '今天 ' . $htime;
        } else if (date('Y-m-d', $time) == date('Y-m-d', strtotime('-1 day'))) {
            $return = '昨天 ' . $htime;
        } else if (date('Y-m-d', $time) == date('Y-m-d', strtotime('-2 day'))) {
            $return = '前天 ' . $htime;
        } else if (date('Y', $time) == date('Y')) {
            $return = date('m-d H:i', $time);
        } else {
            $return = date('Y-m-d H:i', $time);
        }
        return $return;
    }

    /**
     * Please provider the number unit as second not millisecond
     * @param int $num
     * @return string
     */
    public static function formatTime(int $num)
    {
        $format = '%dh %dm';

        $hours = (int)($num / 3600);
        $minutes = (int)($num % 3600 / 60);

        if ($hours && $minutes) {
            return sprintf($format, $hours, $minutes);
        }

        if ($hours) {
            return sprintf(preg_replace('/(^%[^%]+).*/', '$1', $format), $hours);
        }

        if ($minutes) {
            return sprintf(preg_replace('/.+(%.*)$/', '$1', $format), $minutes);
        }

        return 0;
    }

    public static function formatHours($seconds, $withUnit = true)
    {
        $hours = (float)($seconds / 3600);

        if ($withUnit) {
            return round($hours, 2) . 'h';
        } else {
            return round($hours, 2);
        }
    }

    /**
     * Get valid months in a date range
     *
     * @param string $startDate e.g: 2018-06-01
     * @param string $delimiter
     *
     * @return array
     */
    public static function getValidMonths($startDate, $delimiter = '-', $monthWithLeadingZero = true)
    {
        $endYear = (int)date('Y');
        $endMonth = (int)date('n');

        $startYear = (int)date('Y', strtotime($startDate));
        $startMonth = (int)date('n', strtotime($startDate));

        $options = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                if ($year == $startYear && $month < $startMonth) {
                    continue;
                }
                if ($year == $endYear && $month > $endMonth) {
                    continue;
                }

                if ($monthWithLeadingZero) {
                    // Format to 2018-08
                    $options[] = $year . $delimiter . str_pad($month,2,'0',STR_PAD_LEFT);
                } else {
                    // Format to 2018-8
                    $options[] = $year . $delimiter . $month;
                }
            }
        }

        return $options;
    }

    public static function getYearOptions($startYear = 2011)
    {
        $currentYear = date('Y');
        $currentMonth = (int)date('m');
        if ($currentMonth >= 12) {
            $currentYear = $currentYear + 1;
        }

        $options = [];
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $options[$i] = $i;
        }

        krsort($options);

        return $options;
    }

    public static function getMonthOptions()
    {
        $options = [];
        for ($i = 1; $i <= 12; $i++) {
            $options[$i] = $i;
        }

        return $options;
    }

    public static function getDayOptions()
    {
        $options = [];
        for ($i = 1; $i <= 31; $i++) {
            $options[$i] = $i;
        }

        return $options;
    }

    /**
     * Get the interval days between two dates
     * https://blog.csdn.net/u014158869/article/details/87885478
     * @param string $startDate
     * @param string $endDate
     * @return false|int
     * @throws \Exception
     */
    public static function getIntervalDays($startDate, $endDate)
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $days = $start->diff($end)->days;

        return $days;
    }

    /**
     * Get the interval weeks between two dates
     * https://stackoverflow.com/questions/3028491/php-weeks-between-2-dates
     * @param $startDate
     * @param $endDate
     * @return false|float
     * @throws \Exception
     */
    public static function getIntervalWeeks($startDate, $endDate)
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $weeks = floor($start->diff($end)->days / 7);

        return $weeks;
    }

    /**
     * Get the interval months between two dates
     * https://stackoverflow.com/questions/13416894/calculate-the-number-of-months-between-two-dates-in-php/25684828
     * @param string $startDate
     * @param string $endDate
     * @return false|int
     * @throws \Exception
     */
    public static function getIntervalMonths($startDate, $endDate)
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $dateDiff = $start->diff($end);

        $months = (($dateDiff->y) * 12) + ($dateDiff->m);

        return $months;
    }

    /**
     * Check if dates are continuous
     * https://stackoverflow.com/questions/41539037/check-if-dates-are-continuous-with-php
     * @param string $currentDate
     * @param string $previousDate
     * @return bool
     * @throws \Exception
     */
    public static function isContinuousDate($currentDate, $previousDate)
    {
        $current = new \DateTime($currentDate);
        $previous = new \DateTime($previousDate);

        $dateDiff = $current->diff($previous);

        // If the difference is exactly 1 day, it's continuous
        if ($dateDiff->days == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get nice duration
     * https://stackoverflow.com/questions/6534490/formatting-duration-time-in-php/33196269
     * @param int $durationInSeconds
     * @param string $format short|long
     * @param bool $showSecond
     * @return string
     */
    public static function getNiceDuration($durationInSeconds, $format = 'short', $showSecond = false)
    {
//        $dt = new \DateTime();
//        $dt->add(new \DateInterval('PT200M'));
//        $interval = $dt->diff(new \DateTime());
//        return $interval->format('%Hh %Im %Ss');

        $labels = [
            'day' => $format == 'short' ? 'd' : ' days',
            'hour' => $format == 'short' ? 'h' : ' hours',
            'minute' => $format == 'short' ? 'm' : ' minutes',
            'second' => $format == 'short' ? 's' : ' seconds',
        ];

        $duration = '';
        $days = floor($durationInSeconds / 86400);
        $durationInSeconds -= $days * 86400;
        $hours = floor($durationInSeconds / 3600);
        $durationInSeconds -= $hours * 3600;
        $minutes = floor($durationInSeconds / 60);
        $seconds = $durationInSeconds - $minutes * 60;

        if ($days > 0) {
            $duration .= $days . $labels['day'] . ' ';
        }
        if ($hours > 0) {
            $duration .= $hours . $labels['hour'] . ' ';
        }
        if ($minutes > 0) {
            $duration .= $minutes . $labels['minute'] . ' ';
        }
        if ($showSecond && $seconds > 0) {
            $duration .= $seconds . $labels['second'];
        }

        return trim($duration);
    }

    /**
     * Get file size
     * @param string $filePath
     * @param bool $prettyFormat
     * @return false|int|string
     */
    public static function getFileSize($filePath, $prettyFormat = false)
    {
        if (is_file($filePath) && file_exists($filePath)) {
            $fileSize = filesize($filePath);
        } else {
            $fileSize = 0;
        }

        if ($prettyFormat) {
            return self::formatFileSize($fileSize);
        } else {
            return $fileSize;
        }
    }

    /**
     * Format file size
     * https://www.jb51.net/article/47893.htm
     * https://www.cnblogs.com/52php/p/5657986.html
     *
     * @param int $fileSize
     * @return string
     */
    public static function formatFileSize($fileSize)
    {
        $size = sprintf("%u", $fileSize);
        if ($size == 0) {
            return ("0 Bytes");
        }
        $units = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
        return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $units[$i];
    }

    /**
     * 获取某年第几周的开始日期和结束日期
     * @param int $year
     * @param int $week 第几周
     * @return array
     */
    public static function getWeekday(int $year, int $week = 1): array
    {
        $year_start = mktime(0, 0, 0, 1, 1, $year);
        $year_end = mktime(0, 0, 0, 12, 31, $year);

        // 判断第一天是否为第一周的开始
        if (intval(date('W', $year_start)) === 1) {
            $lastday = date("Y-m-d", strtotime(date('Y-m-d', $year_start) . " Sunday"));
            $start = strtotime(date("Y-m-d", strtotime($lastday . "-6 days")));
            //$start = $year_start;//把第一天做为第一周的开始
        } else {
            $start = strtotime('+1 monday', $year_start);//把第一个周一作为开始
        }

        // 第几周的开始时间
        if ($week == 1) {
            $weekday['start'] = $start;
        } else {
            $weekday['start'] = strtotime($week . ' monday', $start);
        }

        // 第几周的结束时间
        $weekday['end'] = strtotime('+1 sunday', $weekday['start']);
        if (date('Y', $weekday['end']) != $year) {
            $weekday['end'] = $year_end;
        }
        return $weekday;
    }

    public static function getAllDaysDate($startTime, $endTime)
    {
        $start = strtotime($startTime);
        $end = strtotime($endTime);

        $dates = [];
        while ($start <= $end) {
            $dates[] = date('Y-m-d', $start);
            $start = strtotime('+1 day', $start);
        }

        return $dates;
    }
}
