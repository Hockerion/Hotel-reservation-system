<?php
session_start();
require_once(APP . 'utils/clean_input.php');
require_once(APP . 'utils/date_math.php');
require_once(MODEL . 'database.php');
require_once(APP . 'booking/allocate_room.php');
use Database as DB;

$type = $disc = $start = $end = '';
$errors = array(
    'type' => '',
    'disc' => '',
    'start' => '',
    'end' => '',
);

/**
 * Form handling starts here.
 */
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $type = $_POST['type'];
    $disc = $_POST['disc'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    /**
     * The following fields cannot be empty.
     */
    if(empty($disc)){
        $errors['disc'] = "This field must be filled.";
    }
    if(empty($start)){
        $errors['disc'] = "This field must be filled.";
    }
    if(empty($end)){
        $errors['disc'] = "This field must be filled.";
    }

    /**
     * Range for discounts is 0-100.
     */
    if($disc < 0 || $disc  > 100){
        $errors['disc'] = "Discount factor must range from 0 to 100.";
    }

    if(!empty($start) && !empty($end)){
        /**
         * If the start date is past the end date, or
         * either date is before the current date, or
         * if the discount duration is less than 1 day, throw error.
         */
        if(strtotime($start) > strtotime($end)){
            $errors['start'] = "Start date must be before end date.";
        }
        $current_date = date('Y-m-d');
        if(strtotime($start) < strtotime($current_date)){
            $errors['start'] = "Start date cannot be in the past.";
        }
        if(strtotime($end) < strtotime($current_date)){
            $errors['end'] = "End date cannot be in the past.";
        }
        if(strtotime($start) == strtotime($end)){
            $errors['end'] = "End date must be at least 1 day after start date.";
        }
    }

    /**
     * Start date cannot be in between the start and end dates
     * of another discount. This applies to the end date as well.
     */
    $conflict = '';
    $conn = DB\Connect::db_connect();
    $discounts = DB\Discount::get_discounts($conn, $type);
    $conflict = DB\Discount::find_discount($discounts, $start);
    if($conflict){
        $errors['start'] = "There is already a discount in effect at that time. Try another date.";
    }

    $conflict = DB\Discount::find_discount($discounts, $end);
    if($conflict){
        $errors['end'] = "There is already a discount in effect at that time. Try another date.";
    }

    if(!array_filter($errors)){
        DB\Discount::insert_discount($conn, $disc, $start, $end, $type);
        $_SESSION['message'] = "Discount was successfully added!";
        // header('Location: ../views/empPage.php');
    }
}