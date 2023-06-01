<?php
    $title = 'Profile';
    require(VIEW . 'layout/header.php');
    require_once(MODEL . 'database.php');
    use Database as DB;
    
    $conn = DB\Connect::db_connect();
    $member = DB\Member::get_member($conn, $_SESSION['id']);
    $resvs = DB\Reservation::get_user_resvs($conn, $_SESSION['id']);
?>

<main>
<center>
    <h2>User Profile Information:</h2>

    <div class="card">
        <div>
            <b>Username:</b> <?php echo $member['username'];?>
        </div>
        <div>
            <b>ID:</b> <?php echo $member['member_id'];?>
        </div>
        <div>
            <b>First Name:</b> <?php echo $member['firstname'];?>
        </div>
        <div>
            <b>Last Name:</b> <?php echo $member['lastname'];?>
        </div>   
        <div>
            <b>Contant Number:</b> <?php echo $member['contact_num'];?>
        </div>
        <div>
            <b>Email:</b> <?php echo $member['email'];?>
        </div>
    </div>

    <h2>Room Reservations Made:</h2>
    <?php foreach($resvs as $resv){?>
        <div class="card">
            <div>
                <b>Reservation ID:</b> <?php echo $resv['reserve_id'];?>
            </div>
            <div>
                <b>Room ID:</b> <?php echo $resv['room_id'];?>
            </div>
            <div>
                <b>Check-in:</b> <?php echo $resv['check_in'];?>
            </div>
            <div>
                <b>Check-out:</b> <?php echo $resv['check_out'];?>
            </div>
            <div>
                <b>No. of Pax:</b> <?php echo $resv['no_of_pax'];?>
            </div>   
            <div>
                <b>Total Cost:</b> 
                ₱<?php 
                    $cost = DB\Bill::get_cost($conn, $resv['reserve_id']);
                    echo $cost;
                ?>
            </div>
        </div>
    <?php }?>


    <br>
    <a href="/">Back to Home</a>
    <br><br><br><br>
</center>
</main>

<?php
    require(VIEW . 'layout/footer.php');
?>