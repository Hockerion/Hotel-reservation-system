<?php
require_once(MODEL . 'database.php');
use Database as DB;

if(isset($_GET['delete_id'])){
    $conn = DB\Connect::db_connect();
    $id = $_GET['delete_id'];
    $disc = DB\Discount::get_discount($conn, $id);

    $_SESSION['message'] = DB\Discount::delete_discount($conn, $id);
    header('Location: /discounts');
}
else{
    header('Location: /discounts');
}
?>