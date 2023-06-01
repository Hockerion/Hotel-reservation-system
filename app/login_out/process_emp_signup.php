<?php
require_once(MODEL . 'database.php');
use Database as DB;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $contact_num = $_POST['contact_num'];
    $confirm_password = $_POST['confirm_password'];

    // check if both passwords match
    if ($password !== $confirm_password) {
        // Incorrect password
        header("Location: /signup-member?error=incorrect");
        exit();
    }

    // new mysqli instance
    $mysqli = DB\Connect::db_connect();

    // check db connection
    if ($mysqli->connect_errno) {
        // error    
        die('Connection error: ' . $mysqli->connect_error);
    }
	
    // check db if user exists
    $result =  DB\Employee::get_employee_name($mysqli, $username);

    if (!empty($result)) {
        // user ALREADY exists
        $mysqli->close();
        header("Location: /signup-member?error=exists");
        exit();
    } else {
        // password hashing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $id = DB\Employee::insert_employee($mysqli, $username, $hashedPassword, $firstname, $lastname, $email, $contact_num);

        // check if insertion was successful
        if(!empty($id)) {
            //log in and return to homepage
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            $_SESSION['user_type'] = 'emp';
            $mysqli->close();
            header("Location: /emp-panel");
        } 
        else {
            echo 'Insert failed.';
            echo 'Error: ' . $mysqli->error;
        }

        // close db connection
        $mysqli->close();
        }   
}
?>