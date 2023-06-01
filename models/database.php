<?php
namespace Database;

class Connect{
    /**
     * Creates a database connection based using
     * information from config.php.
     */
    static function db_connect(){
        require_once(ROOT . 'config/db.php');

        $conn = mysqli_connect($server, $db_username, $db_password, $db_name);
        if(!$conn){
            die("Connection error!");
        }
        else{
            return $conn;
        }        
    }
}

/**
 * This class' methods interact with the 'member' table
 * of the database.
 */
class Member{
    /**
     * Returns a 'member' row based on a supplied ID.
     */
    static function get_member($conn, $id){
        $sql = "SELECT * from member
                WHERE member_id = '$id'";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($query);
    }

    /**
     * Returns a 'member' row based on a supplied username.
     */
    static function get_member_name($conn, $name){
        $sql = "SELECT * from member
                WHERE username = '$name'";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($query);
    }

    /**
     * Returns a member's name based on a supplied ID.
     */
    static function get_username($conn, $id){
        $sql = "SELECT username from member
                WHERE member_id = '$id'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        return $row['username'];
    }

    /**
     * Inserts a 'member' row based on a supplied information.
     */
    static function insert_member($conn, $username, $password, $fname, $lname, $email, $contact){
        $sql = $conn->prepare("INSERT INTO member VALUES (NULL, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param('ssssss', $username, $password, $fname, $lname, $email, $contact);
        $sql->execute();
        return mysqli_insert_id($conn);
    }
}


/**
 * This class' methods interact with the 'employee' table
 * of the database.
 */
class Employee{
    /**
     * Returns a 'employee' row based on a supplied id.
     */
    static function get_employee_id($conn, $id){
        $sql = "SELECT * from employee
                WHERE employee_id = '$id'";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($query);
    }

    /**
     * Returns a 'employee' row based on a supplied username.
     */
    static function get_employee_name($conn, $name){
        $sql = "SELECT * from employee
                WHERE username = '$name'";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($query);
    }
    
    /**
     * Inserts an 'employee' row based on a supplied information.
     */
    static function insert_employee($conn, $username, $password, $fname, $lname, $email, $contact){
        $sql = $conn->prepare("INSERT INTO employee VALUES (NULL, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param('ssssss', $username, $password, $fname, $lname, $email, $contact);
        $sql->execute();
        return mysqli_insert_id($conn);
    }
}

/**
 * This class' methods interact with the 'room' table
 * of the database.
 */
class Room{
    /**
     * Returns an array of all rooms ID's of a given type.
     * NOTE: Each element of the array is a 1-element array.
     */
    static function get_ids_of_type($conn, $type){
        $sql = "SELECT room_id from room
                WHERE type = '$type'";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_all($query);
    }
}

/**
 * This class' methods interact with the 'reservation' table
 * of the database.
 */
class Reservation{
    /**
     * Returns an array of reservations containing
     * the given room ID.
     */
    static function get_resv_of_room($conn, $room_id){
        $sql = "SELECT * from reservation
                WHERE room_id = '$room_id'";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    /**
     * Inserts a row into the 'reservation' table.
     * Returns the reservation ID produced.
     */
    static function insert_resv($conn, $check_in, $check_out, $pax, $room_id, $member_id){
        $sql = $conn->prepare("INSERT INTO reservation VALUES (NULL, ?, ?, ?, ?, ?)");
        $sql->bind_param("ssiii", $check_in, $check_out, $pax, $room_id, $member_id);
        $sql->execute();
        return mysqli_insert_id($conn);
    }

    /**
     * Returns an array of reservations made by
     * a user of a given ID.
     */
    static function get_user_resvs($conn, $id){
        $sql = "SELECT * from reservation
                WHERE member_id = '$id'";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
}

/**
 * This class' methods interact with the 'bill' table
 * of the database.
 */
class Bill{
    /**
     * Inserts a row into the 'bill' table.
     */
    static function insert_bill($conn, $total_cost, $method, $reserve_id){
        $sql = $conn->prepare("INSERT INTO bill VALUES (NULL, ?, ?, ?)");
        $sql->bind_param("dsi", $total_cost, $method, $reserve_id);
        $sql->execute();
    }

    /**
     * Returns the 'total bill' in a 'bill' row specified
     * by a reservation ID.
     */
    static function get_cost($conn, $id){
        $sql = "SELECT total_bill from bill
                WHERE reserve_id = '$id'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        return $row['total_bill'];
    }
}

/**
 * This class' methods interact with the 'discount' table
 * of the database or deal with 'discount' objects.
 */
class Discount{
    /**
     * Inserts a row into the 'discount' table.
     */
    static function insert_discount($conn, $discount, $start, $end, $type){
        $sql = $conn->prepare("INSERT INTO discount VALUES (NULL, ?, ?, ?, ?)");
        $sql->bind_param("dsss", $discount, $start, $end, $type);
        $sql->execute();
    }

    /**
     * Deletes a row from the 'discount' table, based on ID.
     */
    static function delete_discount($conn, $id){
        $sql = "DELETE FROM discount
                WHERE discount_id = '$id'";
        if(mysqli_query($conn, $sql)){
            return "Discount successfully deleted.";
        }

    }

    /**
     * Returns a 'discount' row based on a given ID.
     */
    static function get_discount($conn, $id){
        $sql = "SELECT * from discount
                WHERE discount_id = '$id'";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($query);
    }

    /**
     * Returns an array of discounts that apply
     * to the given room type.
     */
    static function get_discounts($conn, $type){
        $sql = "SELECT * from discount
                WHERE type = '$type'";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    /**
     * Returns an array of all discounts.
     */
    static function get_all_discounts($conn){
        $sql = "SELECT * from discount";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    /**
     * Takes an array of discounts, and returns
     * a discount that applies to a given date.
     */
    static function find_discount($discounts, $check_in){
        $check_in = strtotime($check_in);

        foreach ($discounts as $discount){
            if($check_in >= strtotime($discount['start_date']) && $check_in <= strtotime($discount['end_date'])){
                return $discount['discount'];
            }
        }
    }
}

class Rating{
    /**
     * Gets a row from the 'rating' table based on a supplied member ID.
     */
    static function get_rating($conn, $id){
        $sql = "SELECT * from rating
                WHERE member_id = '$id'";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($query);
    }

    /**
     * Inserts a row into the 'rating' table.
     */
    static function insert_rating($conn, $rating, $member_id, $title, $review, $date){
        $sql = $conn->prepare("INSERT INTO rating VALUES (NULL, ?, ?, ?, ?, ?)");
        $sql->bind_param("iisss", $rating, $member_id, $title, $review, $date);
        $sql->execute();
    }

    /**
     * Updates a row in the the 'rating' table.
     */
    static function update_rating($conn, $rating, $member_id, $title, $review, $date){
        $sql = $conn->prepare("UPDATE rating SET rating=?, title=?, review=?, rate_date=?
                               WHERE member_id=?");
        $sql->bind_param('isssi', $rating, $title, $review, $date, $member_id);
        if($sql->execute()){
        }
    }

    /**
     * Gets all rows from the 'rating' table.
     */
    static function get_all_ratings($conn){
        $sql = "SELECT * from rating";
        $query = mysqli_query($conn, $sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    /**
     * Gets average of all rating values in the 'rating' table.
     */
    static function rating_avg($conn){
        $ratings = Rating::get_all_ratings($conn);
        $scores = array();

        foreach($ratings as $rating){
            array_push($scores, $rating['rating']);
        }
        return array_sum($scores) / count($ratings);
    }

}