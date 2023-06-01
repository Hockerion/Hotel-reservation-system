<?php
    if(!isset($_SESSION['id']) && !isset($_SESSION['username'])){
        header('Location: /not-allowed');
    }

    $title = 'Booking';
    require(VIEW . 'layout/header.php');
    require(APP . 'booking/validate_booking.php');
?>

<main>
<center>
    <h2>Room Booking Page</h2>
    <br>
    <form method="post" action="/booking">
        
        <!-- Room type field -->
        <?php
            $selected = $type;
        ?>

        <label for="type">Room Type:</label>
        <select name="type" id="type">
            <option value="S" <?php if($selected == 'S'){echo("selected");}?> >Standard</option>
            <option value="SF" <?php if($selected == 'SF'){echo("selected");}?> >Standard-Family</option>
            <option value="D" <?php if($selected == 'D'){echo("selected");}?> >Deluxe</option>
            <option value="DF" <?php if($selected == 'DF'){echo("selected");}?> >Deluxe-Family</option>
            <option value="SU" <?php if($selected == 'SU'){echo("selected");}?> >Suite</option>
        </select>
        <a href="/rooms" class="room-info" title="Room Type Information">?</a>
        <div class="error"> <?php echo $errors['type']; ?> </div>

        <br> <!-- Check-in field -->
        <label for="check-in">Check-in:</label>
        <input type="date" name="check-in" id="check-in" value="<?php echo $check_in;?>" required>
        <div class="error"> <?php echo $errors['check-in']; ?> </div>

        <br> <!-- Check-out field -->
        <label for="check-out">Check-out:</label>
        <input type="date" name="check-out" id="check-out" value="<?php echo $check_out;?>" required>
        <div class="error"> <?php echo $errors['check-out']; ?> </div>

        <br> <!-- No. of Pax field -->
        <label for="pax">No. of Pax (1-2, or 2-4 for family rooms):</label>
        <input type="number" name="pax" id="pax" value="<?php echo $pax;?>" required min="1" max="4">
        <div class="error"> <?php echo $errors['pax']; ?> </div>

        <br> <!-- First name field -->
        <label for="fname">First Name:</label>
        <input type="text" name="fname" id="fname" value="<?php echo $fname;?>" required>
        <div class="error"> <?php echo $errors['fname']; ?> </div>

        <br> <!-- Last name field -->
        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" value="<?php echo $lname;?>" required>
        <div class="error"> <?php echo $errors['lname']; ?> </div>

        <br> <!-- 
            Contact number field.
            The regex pattern below accepts most 10-digit international 
            and 11-digit Filipino phone numbers.
        -->
        <label for="contact">Contact Number:</label>
        <input type="tel" name="contact" id="contact" pattern="((\+|00)?[1-9]{2}|0)[1-9]([0-9]){8,9}" 
        value="<?php echo $contact;?>" required>
        <div class="error"> <?php echo $errors['contact']; ?> </div>

        <br> <!-- Submission button -->
        <input type="submit" value="Submit">
    </form>

    <br>
    <a href="/">Cancel Reservation</a>
    <br><br><br><br>
</center>
</main>

<?php
    require(VIEW . 'layout/footer.php');
?>