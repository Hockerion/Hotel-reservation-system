<?php
require_once(MODEL . 'database.php');
use Database as DB;

$rating = $title = $review = $rate_date ='';
$errors = array(
    'title' => '',
    'review' => '',
);


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $rating = $_POST['rating'];
    $title = $_POST['title'];
    $review = $_POST['review'];
    $rate_date = date('Y-m-d');

    /**
     * If title is filled, then comment must be filled,
     * and vice versa.
     */
    if(empty($title) && !empty($review)){
        $errors['title'] = "A title must be given if making a review.";
    }

    if(!empty($title) && empty($review)){
        $errors['review'] = "A review must be written with a title.";
    }

    /**
     * If the user has already made a rating, update rating.
     * Otherwise, insert new rating.
     */
    if(!array_filter($errors)){
        $id = $_SESSION['id'];
        $conn = DB\Connect::db_connect();
        $result = DB\Rating::get_rating($conn, $id);

        if(empty($result)){
            DB\Rating::insert_rating($conn, $rating, $id, $title, $review, $rate_date);
            $_SESSION['message'] = "Your rating has been recieved.";
            header('Location: /');
        }
        else{
            DB\Rating::update_rating($conn, $rating, $id, $title, $review, $rate_date);
            $_SESSION['message'] = "Your rating has been updated.";
            header('Location: /');
        }
    }
}
