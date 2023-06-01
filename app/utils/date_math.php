<?php
class DateMath{
    /**
     * This method returns the result of
     * date1 - date2 in terms of days.
     */
    static function days_diff($date_1, $date_2){
        $days = abs(strtotime($date_1) - strtotime($date_2));
        return $days /= 86400;
    }

    /**
     * Converts a string date into a proper date value
     * for database storage.
     */
    static function vali_date($strdate){
        $time = strtotime($strdate);
        $new_date = date('Y-m-d', $time);
        return $new_date;
    }
}