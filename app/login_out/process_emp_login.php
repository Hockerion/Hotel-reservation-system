<?php
require_once(MODEL . 'database.php');
use Database as DB;

$errors = array(
    'username' => '',
    'password' => '',
);
$_SESSION['errors'] = $errors;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // grab form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // new mysqli instance
    $conn = DB\Connect::db_connect();
    $result =  DB\Employee::get_employee_name($conn, $username);

    if ($result) {
        $hashedPassword = $result['password'];

        // verify password
        if (password_verify($password, $hashedPassword)) {
            // correct
            $_SESSION['username'] = $username;
            $_SESSION['firstname'] = $result['firstname'];
            $_SESSION['id'] = $result['employee_id'];
            $_SESSION['user_type'] = 'emp';
            header('Location: /emp-panel');
        } 
        else {
            // incorrect
            $_SESSION['errors']['password'] = "Incorrect password.";
            header("Location: /login-employee");
            exit();
        }
    } 
    else {
        // user does not exist
        $_SESSION['errors']['username'] = "User does not exist.";
        header("Location: /login-employee");
        exit();
    }
} 
