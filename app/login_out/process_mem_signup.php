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
    $subscribe = isset($_POST['subscribe']);

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
    $result =  DB\Member::get_member_name($mysqli, $username);

    if (!empty($result)) {
        // user ALREADY exists
        $mysqli->close();
        header("Location: /signup-member?error=exists");
        exit();
    } else {
        // password hashing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $id = DB\Member::insert_member($mysqli, $username, $hashedPassword, $firstname, $lastname, $email, $contact_num);

        // check if insertion was successful
        if(!empty($id)) {

            // send email if checkbox ticked
            if ($subscribe) {
                // email headers
                $headers = "From: HotelVisaias@gmail.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: multipart/related; boundary=\"boundary123\"\r\n\r\n";

                // email message
                $message = "--boundary123\r\n";
                $message .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
                $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                $message .= "<html><body>";
                $message .= "<h1>Welcome to our Newsletter!</h1>";
                $message .= "<p>Thank you for subscribing.</p>";
                $message .= "<img src=\"cid:image123\" alt=\"Embedded Image\">";
                $message .= "</body></html>\r\n\r\n";

                // read the image file
                $image_path = "src/img.jpg";
                $image_data = file_get_contents($image_path);

                // encode the image data
                $image_data_encoded = base64_encode($image_data);

                // add the image as a separate part in the email
                $message .= "--boundary123\r\n";
                $message .= "Content-Type: image/jpeg\r\n";
                $message .= "Content-Transfer-Encoding: base64\r\n";
                $message .= "Content-ID: <image123>\r\n";
                $message .= "Content-Disposition: inline; filename=\"image.jpg\"\r\n\r\n";
                $message .= $image_data_encoded."\r\n\r\n";

                // send email
                $result = mail($email, "Welcome to our Newsletter!", $message, $headers);
            }

            //log in and return to homepage
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            $_SESSION['booked'] = false;
            header("Location: /");
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