<?php
namespace App\Helper;

trait Time
{
    public function secondsToTime($seconds)
    {
        $hours = null;
        $minutes = null;
        $days = null;

        while(($seconds - 3600) >= 0) {
            $seconds -= 3600;
            $hours++;
        }

        while(($seconds - 60) >= 0) {
            $seconds -= 60;
            $minutes++;
        }

        while(($hours - 24) >= 0) {
            $hours -= 24;
            $days++;
        }

        if($minutes < 10) $minutes = "0".$minutes; if($minutes == 0) $minutes = "00";
        if($hours < 10) $hours = "0".$hours; if($hours == 0) $hours = "00";
        if($seconds < 10) $seconds = "0".$seconds;
        if($days > 0) $days = "$days days ";

        return "$days$hours:$minutes:$seconds";
    }

    public function toSeconds($time)
    {
        $time = explode(':', $time);

        $time[2] += $time[0] * 3600;
        $time[2] += $time[1] * 60;

        return $time[2];
    }

    public function toTime($minutes)
    {
        $hours = null;

        while(($minutes - 60) >= 0)
        {
            $minutes = $minutes - 60;
            $hours++;
        }

        if($minutes < 10) $minutes = "0".$minutes;
        if($hours < 10) $hours = "0".$hours;

        return "$hours:$minutes:00";
    }

    public function toMinutes($time)
    {
        $time = explode(':', $time);
        $minutes = 0;
        $minutes += $time[0] * 60;

        while($i = ($time[2] - 60) > 0)
        {
            $minutes++;
        }

        return $minutes + $time[1];
    }
}
