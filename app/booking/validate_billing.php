<?php
require_once(APP . 'utils/clean_input.php');
require_once(APP . 'utils/date_math.php');
require(ROOT . 'config/room_rates.php');
require_once(MODEL . 'database.php');
use Database as DB;

$type = $_SESSION['booking_info']['type'];
$check_in = $_SESSION['booking_info']['check-in'];
$check_out = $_SESSION['booking_info']['check-out'];
$pax = $_SESSION['booking_info']['pax'];
$room_id = $_SESSION['booking_info']['room_id'];
$method = ""; //Sets the default choice for the payment method buttons.

/**
 * Finding an applicable discount.
 */
$message = '';
$dis_factor = 0;
$conn = DB\Connect::db_connect();
$discounts = DB\Discount::get_discounts($conn, $type);
$dis_factor = DB\Discount::find_discount($discounts, $check_in);
if($dis_factor != 0){
    $message = "There is currently a $dis_factor% discount for the chosen type of room!";
}

/**
 * Calculation for total cost of stay.
 */
$duration = DateMath::days_diff($check_in, $check_out);
switch($type){
    case "S":
        $cost = $S;
        break;
    case "SF":
        $cost = $SF;
        break;
    case "D":
        $cost = $D;
        break;
    case "DF":
        $cost = $DF;
        break;
    case "SU":
        $cost = $SU;
        break;
    default:
        echo '<div class="error">Invalid room type.</div>';
}
$total = $cost * $duration;
$dis_total = $cost * $duration * ((100 - $dis_factor)/100);


/**
 * Form handling starts here.
 */
$errors = array(
    'pay_method' => '',
);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $method = $_POST['pay-method'];
    if($method == "other"){
        $method = CleanInput::clean_text($_POST['other-method']);
        if(empty($method)){
            $errors['pay_method'] = "This field must be filled.";
        }
    }

    if(!array_filter($errors)){
        $resv_id = DB\Reservation::insert_resv($conn, $check_in, $check_out, $pax, $room_id, $_SESSION['id']);
        DB\Bill::insert_bill($conn, $dis_total, $method, $resv_id);
        $_SESSION['message'] = "Reservation was successfully made, and your bill has been finalized.<br>
                                Your Reservation ID is $resv_id.";
        header('Location: /');
    }
}
?>