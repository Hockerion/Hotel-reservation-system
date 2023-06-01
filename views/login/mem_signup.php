<?php
    $title = 'Member Sign-Up';
    require(VIEW . 'layout/header.php');

    // check for errors
    if(!isset($errors)){
        $errors = array(
            'username' => '',
            'confirm_password' => '',
        );
    }
    
    if (isset($_GET['error']) && $_GET['error'] === 'exists') {
        $errors['username'] = 'Username already exists. Please choose a different username.';
    }

    if (isset($_GET['error']) && $_GET['error'] === 'incorrect') {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

?>

<main>
<center>
    <h2>Member Sign-Up</h2><br>
    <form action="/signup-member" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <div class="error"> <?php echo $errors['username']; ?> </div>

        <br>
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required><br><br>

        <label for="lastname=">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        <div class="error"> <?php echo $errors['confirm_password']; ?> </div>
        <br>
        <label for="contact_num">Contact Number:</label>
        <input type="tel" id="contact_num" name="contact_num" pattern="((\+|00)?[1-9]{2}|0)[1-9]([0-9]){8,9}" required><br><br>
  
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="newsletter">Subscribe to Newsletter:</label>
        <input type="checkbox" id="subscribe" name="subscribe" value="1"><br><br>

        <input type="submit" value="Sign Up"><br><br>
        
        <a href="/"> Back to Home</a>
        <br><br><br>
    </form>
</center>

</main>

<?php
    require(VIEW . 'layout/footer.php');
?>