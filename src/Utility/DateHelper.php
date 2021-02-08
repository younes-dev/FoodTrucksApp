<?php


namespace App\Utility;


class DateHelper
{
    /**
     * @param $date
     * @return bool
     * https://gist.github.com/nothnk/1736495
     */
    static function isWeekend($date)
    {
        $date =  !is_string($date) ? $date->format('Y-m-d') : $date; // todo in function
        $weekDay = date('D', strtotime($date));
        return ($weekDay === "Sat" || $weekDay === "Sun");
    }

    static function isFriday($date)
    {
        $date =  !is_string($date) ? $date->format('Y-m-d') : $date;
        $weekDay = date('D', strtotime($date));
        return ($weekDay === "Fri");
    }

    public static function getWorkWeek($date): array
    {
        $list = [];
        $date = is_string($date) ? new \DateTime($date) : $date;
        $pos = $date->format('N');
        $date = self::getNextDay($date);
        if ($pos > 0) {
            foreach (range($pos, 1) as $number) {
                $list [] = $date->format('Y-m-d');
                $date = self::getPrevDay($date);
            }
        }

        $date->modify("+ " . $pos . "days");

        if ($pos < 5) {
            foreach (range($pos, 4) as $number) {

                $date =self::getNextDay($date);
                $list[] = $date->format('Y-m-d');
            }
        }

        return ($list);
    }

    public static function getNextDay($date)
    {
        return $date->modify("+ 1 days");
    }

    public static function getPrevDay($date)
    {
        return $date->modify("- 1 days");
    }


    public static function convertDateStringToObject($dateStrings): array
    {
        $dates=[];
        foreach($dateStrings as $dateString){
            $dates[] = \DateTime::createFromFormat('Y-m-d', $dateString);
        }
        return $dates;
    }

    public function compareByTimeStamp($time1, $time2): int
    {
        if (strtotime($time1) < strtotime($time2)) { return 1;}
        if (strtotime($time1) > strtotime($time2)){
            return -1;
        }
        return 0;
    }

    public static function getMyWorkWeek($date): array
    {
        $date =  !is_string($date) ? $date->format('Y-m-d') : $date;
        $timestamp = strtotime('monday this week');
        for ($i = 0; $i < 5; $i++) {
            $workDays[] = strftime('%A', $timestamp);
            $timestamp = strtotime('+1 day', $timestamp);
        }

        $list =[];
        foreach($workDays as $day){
            $list[]= date("Y-m-d", strtotime($day." this week", strtotime($date)));
        }

       return $list;

    }
}