<?php
namespace App\Helpers;

class MyHelper
{
    static function mt_($num)
    {
        return bcdiv($num / 10000000, 2);
    }
    static function nice_number2($n)
    {
        return round($n / 10000000, 2);
    }
    static function nice_number($n)
    {
        // first strip any formatting;
        $n = (0 + str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) {
            return false;
        }

        // now filter it;
        if ($n > 1000000000000) {
            return round(($n / 1000000000000), 2) . 'T';
        } elseif ($n > 1000000000) {
            return round(($n / 1000000000), 2) . 'B';
        } elseif ($n > 1000000) {
            return round(($n / 1000000), 2) . 'M';
        } elseif ($n > 1000) {
            return round(($n / 1000), 2) . 'K';
        }

        return number_format($n);
    }
    static function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    
        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);
        
        return $englishNumbersOnly;
    }

}
