<?php


//Вторник, Ноември 6, 2018
if (!function_exists('format_current_date_for_index')) {
    function format_current_date_for_index($date)
    {
        $month = mb_ucfirst($date->locale('bg')->monthName);
        $day = mb_ucfirst($date->locale('bg')->dayName);
        $day_number = $date->day;
        $year = $date->year;

        $response = $day . ', ' . $month . ' ' . $day_number . ', ' . $year;

        return $response;
    }
}

//OKT. 12, 2018
if (!function_exists('format_current_date_for_last_blog')) {
    function format_current_date_for_last_blog($date)
    {
        $month = mb_strtoupper($date->locale('bg')->monthName);
        $day_number = $date->day;
        $year = $date->year;
        if (strlen($month) > 3) {
            $month = mb_substr($month, 0,3);
        }

        $response = $month . '. ' . $day_number . ', ' . $year;

        return $response;
    }
}

//OKT. 29
if (!function_exists('simple_uppercase_format')) {
    function simple_uppercase_format($date)
    {
        $month = mb_strtoupper($date->locale('bg')->monthName);
        $day_number = $date->day;
        $year = $date->year;
        $hour = $date->hour;
        $minutes = $date->minute;

        if ($minutes < 10) {
            $minutes = '0' . $minutes;
        }

        if ($hour < 10) {
            $hour = '0' . $hour;
        }

        if (strlen($month) > 3) {
            $month = mb_substr($month, 0,3);
        }

        $response = $month . '. ' . $day_number . ', ' . $year . ' ' . $hour . ':' . $minutes;

        return $response;
    }
}

if (!function_exists('simple_date_format')) {
    function simple_date_format($date)
    {
        $month = $date->locale('bg')->monthName;
        $day_number = $date->day;
        if (strlen($month) > 3) {
            $month = mb_substr($month, 0,3);
        }

        $response = $day_number . ' ' . $month . '.';

        return $response;
    }
}

if (!function_exists('date_with_hour')) {
    function date_with_hour($date)
    {
        $month = $date->locale('bg')->month;
        $year = $date->locale('bg')->year;
        $day_number = $date->day;

        if ($month < 10) {
            $month = '0' . $month;
        }
        $hour = $date->hour;
        $min = $date->minute;



        if (strlen($month) > 3) {
            $month = mb_substr($month, 0,3);
        }


        $response = $hour . ':' . $min . ':00 '. $day_number . '-' . $month . '-' . $year;

        return $response;
    }
}

if (!function_exists('strip_description')) {
    function strip_description($string, $max_chars)
    {
        $string = trim(strip_tags($string));
        $string = mb_substr($string, 0, $max_chars, "utf-8");

        if (strlen($string) >= $max_chars) {
            $string = mb_substr($string, 0, $max_chars, "utf-8");
            $string .= '...';
        }

        return $string;
    }
}

//covert first character to uppercase
if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst($str, $encoding = "UTF-8", $lower_str_end = false)
    {
        $first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
        if ($lower_str_end) {
            $str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
        } else {
            $str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
        }
        $str = $first_letter . $str_end;
        return $str;
    }
}

//format_number
if (!function_exists('format_number')) {
    function format_number($number)
    {
        return number_format((float) $number, 2, '.', '');
    }
}

//format_number
if (!function_exists('beatify_number')) {
    function beatify_number($number)
    {
        $decimal_numbers = ($number > 1) ? 3 : 7;
        $number = rtrim(number_format($number, $decimal_numbers), "0");

        $locale_info = localeconv();
        $number = rtrim($number, $locale_info['decimal_point']);

        return $number;
    }
}

//get percentage
if (!function_exists('get_percentage')) {
    function get_percentage($total, $number)
    {
        if ($total > 0) {
            return round($number / ($total / 100), 2);
        } else {
            return 0;
        }
    }
}

if (!function_exists('get_percentage_difference')) {
    function get_percentage_difference($total, $number)
    {
        $difference = $total - $number;
        if ($total > 0) {
            return round($difference / ($total / 100), 2);
        } else {
            return 0;
        }
    }
}

if (!function_exists('convert_to_cyrillic')) {
    function convert_to_cyrillic($string) {
        $cyr = array(
            'ж',  'ч',  'щ',   'ш',  'ю',  'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ъ', 'ь', 'я',
            'Ж',  'Ч',  'Щ',   'Ш',  'Ю',  'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ь', 'Я');
        $lat = array(
            'zh', 'ch', 'sht', 'sh', 'yu', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'y', 'x', 'q',
            'Zh', 'Ch', 'Sht', 'Sh', 'Yu', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'c', 'Y', 'X', 'Q');

        return str_replace($lat, $cyr, $string);
    }
}

if (!function_exists('optimize_meta_description')) {
    function optimize_meta_description($string)
    {
        return strip_tags(preg_replace('/(<[^>]+) style=".*?"/i', '$1', $string));
    }
}