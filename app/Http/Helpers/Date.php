<?php

namespace App\Http\Helpers;

use Carbon\Carbon;

class Date
{
    public static function timestampToDate(string|int $timestamp): string
    {
        if ($timestamp && is_numeric($timestamp) || is_int($timestamp)) {
            $timestamp = Carbon::createFromTimestamp($timestamp);
        }

        return $timestamp;
    }
}
