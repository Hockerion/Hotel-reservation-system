<?php
require_once(MODEL . 'database.php');
use Database as DB;

/**
 * Calculates what room to designate to a guest.
 * Room ID's without reservations are looked for first.
 * The lowest-numbered available ID will be returned.
 */
function find_room($conn, $type, $check_in, $check_out){
    $check_in = strtotime($check_in);
    $check_out = strtotime($check_out);

    /**
     * Looking for rooms without any reservations.
     */
    $room_ids = DB\Room::get_ids_of_type($conn, $type);
    $accomm = NULL;
    $resvd_rooms = [];
    foreach($room_ids as $room_id){
        $resvs = DB\Reservation::get_resv_of_room($conn, $room_id[0]);
        if(!$resvs){
            $accomm = $room_id[0];
            return $accomm;
        }
        array_push($resvd_rooms, $room_id[0]);
    }

    /**
     * Runs if no reservation-less rooms are found.
     * Designates the lowest-numbered available ID.
     */
    if(!$accomm){
        foreach($resvd_rooms as $resv){
            if($check_in >= strtotime($resv['check_in']) && $check_in <= strtotime($resv['check_out'])){
                break;
            }
            elseif($check_out >= strtotime($resv['check_in']) && $check_out <= strtotime($resv['check_out'])){
                break;
            }
            else{
                $accomm = $room_id[0];
            }
        }
    }
    return $accomm;
}