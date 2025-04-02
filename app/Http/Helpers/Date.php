<?php

namespace App\Http\Helpers;

use Carbon\Carbon;

class Date
{
    public static function timestampToDate(string|int $timestamp): string
    {
        if (is_numeric($timestamp)) {
            $timestamp = Carbon::createFromTimestamp($timestamp);
        }

        return $timestamp;
    }
}
