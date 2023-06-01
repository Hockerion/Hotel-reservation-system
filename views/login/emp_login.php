<?php
    $title = 'Employee Login';
    require(VIEW . 'layout/header.php');
?>

<main>
<center>
    <h2>Employee Login</h2><br>
    <form method="POST" action="/login-employee">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <div class="error"> 
            <?php if(isset($_SESSION['errors'])) {echo $_SESSION['errors']['username'];} 
                    unset($_SESSION['errors']);?> 
        </div>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <div class="error"> 
            <?php if(isset($_SESSION['errors'])) {echo $_SESSION['errors']['password'];
                    unset($_SESSION['errors']);} ?> 
        </div>

        <br>
        <input type="submit" value="Login">
    </form>

    <br>
    <a href="/signup-employee"><button>Create an Account</button></a><br><br>
    <a href="/">Back to Home</a>
</center>

</main>

<?php
    require(VIEW . 'layout/footer.php');
?>