<?php
    if(!isset($_SESSION['id']) && !isset($_SESSION['username'])){
        header('Location: /not-allowed');
    }
    if(!isset($_SESSION['booking_info'])){
        header('Location: /not-allowed');
    }

    $title = 'Billing';
    require(VIEW . 'layout/header.php');
    require(APP . 'booking/validate_billing.php');
?>

<main>
    <center>
    <h2>Billing Page</h2>

    <b>Length of Stay:</b> 
        <?php 
        echo $duration;
        if($duration == 1)
            echo " night";
        else
            echo " nights";
        ?>
    <br>
    <br>
    <b>Total Cost:</b>
        <?php 
        if($dis_factor != 0)
            echo "<s>₱$total</s>" . ' <b class="discount">₱'. $dis_total . '</b>';
        else
            echo "₱$dis_total";
        ?>
    <div class="discount"> <?php echo $message; ?> </div>

    <form method="post" action="/billing">

        <!-- Payment options field -->
        <p><b>Choose a Method of Payment:</b></p>
        <input type="radio" name="pay-method" id="BDO" value="BDO" <?php if($method == "BDO"){echo "checked";}
            else{echo "checked";}?> required>
        <label for="BDO">BDO</label>
        <br>
        <input type="radio" name="pay-method" id="BPI" value="BPI" <?php if($method == "BPI"){echo "checked";}?>>
        <label for="BDO">BPI</label>
        <br>
        <input type="radio" name="pay-method" id="other" value="other" <?php if($method == "other"){echo "checked";}?>>
        <label for="other">Other (Specify a Bank): </label>
        <input type="text" name="other-method" id="other-method" value="">

        <div class="error"> <?php echo $errors['pay_method']; ?> </div>

        <br>
        <br> <!-- Submission button -->
        <input type="submit" value="Make Reservation">
    </form>

    <br>
    <a href="/">Cancel Reservation</a>
    </center>
</main>

<?php
    require(VIEW . 'layout/footer.php');
?>