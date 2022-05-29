<?php

namespace App\Helpers;

class Helper
{
    public static function convertHoursToMinutes($time, $format = '%02dh %02dmin')
    {
        if ($time < 60)
        {
            return $time . 'min';
        }
        else if ($time == 60)
        {
            return '1h';
        }

        $hours = floor($time / 60);
        $minutes = ($time % 60);

        return sprintf($format, $hours, $minutes);
    }

    public static function formatDate($date, $format = 'd.m.Y')
    {
        return date($format, strtotime($date));
    }

    public static function formatTime($time, $format = 'H:i')
    {
        return date($format, strtotime($time));
    }
}
