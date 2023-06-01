<?php
$title = 'Add Discount';
require(VIEW . 'layout/header_emp.php');
require(APP . 'discount/validate_discount.php');
$selected = $type;
?>

<main>
<center>
    <h2>Add Discount</h2><br><br>

    <form method="post" action="/add-discount">
        <!-- Room type field -->
        <label for="type">Room Type:</label>
        <select name="type" id="type">
            <option value="S" <?php if($selected == 'S'){echo("selected");}?> >Standard</option>
            <option value="SF" <?php if($selected == 'SF'){echo("selected");}?> >Standard-Family</option>
            <option value="D" <?php if($selected == 'D'){echo("selected");}?> >Deluxe</option>
            <option value="DF" <?php if($selected == 'DF'){echo("selected");}?> >Deluxe-Family</option>
            <option value="SU" <?php if($selected == 'SU'){echo("selected");}?> >Suite</option>
        </select>
        <div class="error"> <?php echo $errors['type']; ?> </div>

        <br> <!-- Discount Field -->
        <label for="disc">Discount (1-100):</label>
        <input type="number" name="disc" id="disc" value="<?php echo $disc;?>" required  min="1" max="100"> %
        <div class="error"> <?php echo $errors['disc']; ?> </div>

        <br> <!-- Start Date field -->
        <label for="start">Start Date:</label>
        <input type="date" name="start" id="start" value="<?php echo $start;?>" required>
        <div class="error"> <?php echo $errors['start']; ?> </div>

        <br> <!-- End Date field -->
        <label for="end">End Date:</label>
        <input type="date" name="end" id="end" value="<?php echo $end;?>" required>
        <div class="error"> <?php echo $errors['end']; ?> </div>

        <br> <!-- Submission button -->
        <input type="submit" value="Submit">
    </form>
</center>
</main>

<?php
require(VIEW . 'layout/footer.php');
?>