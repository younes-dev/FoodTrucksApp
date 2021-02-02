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
            $date =  !is_string($date) ? $date->format('Y-m-d') : $date;
            $weekDay = date('D', strtotime($date));
            return ($weekDay === "Sat" || $weekDay === "Sun");
        }

        static function isFriday($date)
        {
            $date =  !is_string($date) ? $date->format('Y-m-d') : $date;
            $weekDay = date('D', strtotime($date));
            return ($weekDay === "Fri");
        }

//    static function getListDateOftheWorkWeek($date)
//    {
//        $date =  !is_string($date) ? $date->format('Y-m-d') : $date;
//        $weekDay = date('D', strtotime($date));
//        return ($weekDay !== "Sat" || $weekDay !== "Sun");
//    }

    static function getWorkWeek($date)
    {
        $date = is_string($date) ? new \DateTime($date) : $date;
        $pos = $date->format('N');
        $liste = [];
        $date = self::getNextDay($date);
        if ($pos > 0) {
            foreach (range($pos, 1) as $number) {

                $liste [] = $date->format('Y-m-d');
                $date = self::getPrevDay($date);
            }
        }

        $date->modify("+ " . $pos . "days");

        if ($pos < 5) {
            foreach (range($pos, 4) as $number) {

                $date = self::getNextDay($date);
                $liste[] = $date->format('Y-m-d');
            }
        }
        return $liste;
    }

    public static function getNextDay($date)
    {
        return $date->modify("+ 1 days");
    }

    public static function getPrevDay($date)
    {
        return $date->modify("- 1 days");
    }
}