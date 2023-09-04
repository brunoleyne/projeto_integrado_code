<?php

namespace App\Helpers;

use Carbon\Carbon;

class Util
{
    public static function convertDatePtBr($date)
    {
        return implode("/", array_reverse(explode("-", $date)));
    }

    public static function convertDateTimePtBr($date)
    {
        $data = new Carbon($date);
        return $data->format('d/m/Y');
    }

    public static function convertDateMySql($date)
    {
        if ($date == null) {
            return null;
        }
        return implode("-", array_reverse(explode("/", $date)));
    }

    public static function convertNumeroDecimal($value)
    {
        $value = str_replace(".", "", $value);
        return str_replace(",", ".", $value);
    }

    public static function convertDinheiro($value)
    {
        return number_format($value, 2, ',', '.');
    }

}