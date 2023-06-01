<?php
// session_start();
require_once(APP . 'utils/clean_input.php');
require_once(APP . 'utils/date_math.php');
require_once(APP . 'booking/allocate_room.php');
require_once(MODEL . 'database.php');
use Database as DB;

$type = $check_in = $check_out = $pax = $fname = $lname = $contact = '';
$errors = array(
    'type' => '',
    'check-in' => '',
    'check-out' => '',
    'pax' => '',
    'fname' => '',
    'lname' => '',
    'contact' => '',
);

/**
 * Form handling starts here.
 */
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $type = $_POST['type'];
    $check_in = $_POST['check-in'];
    $check_out = $_POST['check-out'];
    $pax = $_POST['pax'];
    $fname = CleanInput::clean_text($_POST['fname']);
    $lname = CleanInput::clean_text($_POST['lname']);
    $contact = $_POST['contact'];
    
    /**
     * The following fields cannot be empty.
     */
    if(empty($check_in)){
        $errors['check-in'] = "This field must be filled.";
    }
    if(empty($check_out)){
        $errors['check-out'] = "This field must be filled.";
    }
    if(empty($pax)){
        $errors['pax'] = "This field must be filled.";
    }
    if(empty($fname)){
        $errors['fname'] = "This field must be filled.";
    }
    if(empty($lname)){
        $errors['lname'] = "This field must be filled.";
    }
    if(empty($contact)){
        $errors['contact'] = "This field must be filled.";
    }

    if(!empty($check_in) && !empty($check_out)){
        /**
         * If the check-in date is past the check-out date, or
         * either date is before the current date, throw error.
         */
        if(strtotime($check_in) > strtotime($check_out)){
            $errors['check-in'] = "Check-in must be before check-out.";
        }

        $current_date = date('Y-m-d');
        if(strtotime($check_in) < strtotime($current_date)){
            $errors['check-in'] = "Check-in date cannot be in the past.";
        }
        if(strtotime($check_out) < strtotime($current_date)){
            $errors['check-out'] = "Check-out date cannot be in the past.";
        }

        /**
         * Check-out must be at least 1 day after check-in,
         * check-out cannot be more than 30 days after check-in, and
         * check-in cannot be more than a year after current date.
         */
        if(strtotime($check_in) == strtotime($check_out)){
            $errors['check-out'] = "Check-out must be at least 1 day after check-in.";
        }

        if(DateMath::days_diff($check_out, $check_in) > 30){
            $errors['check-out'] = "Check-out cannot be more than 30 days after check-in.";
        }

        if(DateMath::days_diff($check_in, $current_date) > 365){
            $errors['check-in'] = "Check-in cannot be more than a year after today.";
        }
    }
      
    /**
     * PAX range for -family rooms is 2-4.
     * PAX range for other types of rooms is 1-2.
     */
    if($type == 'SF' || $type == 'DF'){
        if($pax < 2 || $pax > 4){
            $errors['pax'] = "No. of Pax must range from 1-4.";
        }
    }
    else{
        if($pax < 1 || $pax > 2){
            $errors['pax'] = "*No. of Pax must range from 1-2.";
        }
    }

    /**
     * Inputted first name, last name, and contact number
     * must match the values in the database for a given account.
     */
    $id = $_SESSION['id'];
    $conn = DB\Connect::db_connect();
    $member = DB\Member::get_member($conn, $id);

    if(empty($member)){
        $errors['fname'] = "There are no accounts in the database to compare information with.";
        $errors['lname'] = "";
        $errors['contact'] = "";
    }
    else{
        if($fname != $member['firstname']){
            $errors['fname'] = "Please enter the first name you specified in your account.";
        }
    
        if($lname != $member['lastname']){
            $errors['lname'] = "Please enter the last name you specified in your account.";
        }
    
        if($contact != $member['contact_num']){
            $errors['contact'] = "Please enter the contact number you specified in your account.";
        }
    }
    

    /**
     * If there are no available rooms of the given type, 
     * an error will be returned.
     */
    $room_id = find_room($conn, $type, $check_in, $check_out);
    if(!$room_id){
        $errors['type'] = "No room of the chosen type is available for the given time.";
    }

    if(!array_filter($errors)){
        $_POST['room_id'] = $room_id;
        $_SESSION['booking_info'] = $_POST;
        header('Location: /billing');
    }
}