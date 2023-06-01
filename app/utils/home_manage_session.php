<?php
require_once(MODEL . 'database.php');
use Database as DB;

if(isset($_SESSION['booking_info'])){
    unset($_SESSION['booking_info']);
}
if(isset($_SESSION['errors'])){
    unset($_SESSION['errors']);
}

/**
 * System determines if a user has booked a room before
 * by checking if there have been any reservations made
 * in their name (ID).
 */
if(isset($_SESSION['id'])){
    if(!isset($_SESSION['booked']) || $_SESSION['booked'] == false){
        $conn = DB\Connect::db_connect();
        $resvs = DB\Reservation::get_user_resvs($conn, $_SESSION['id']);
        if(empty($resvs)){
            $_SESSION['booked'] = false;
            echo $_SESSION['booked'];
        }
        else{
            $_SESSION['booked'] = true;
        }
    }
}
    