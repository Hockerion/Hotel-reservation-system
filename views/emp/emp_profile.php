<?php
    $title = 'Profile';
    require(VIEW . 'layout/header_emp.php');
    require_once(MODEL . 'database.php');
    use Database as DB;
    
    $conn = DB\Connect::db_connect();
    $emp = DB\Employee::get_employee_id($conn, $_SESSION['id']);
?>

<main>
<center>
    <h2>Employee Profile Information:</h2>

    <div class="card">
        <div>
            <b>Username:</b> <?php echo $emp['username'];?>
        </div>
        <div>
            <b>ID:</b> <?php echo $emp['employee_id'];?>
        </div>
        <div>
            <b>First Name:</b> <?php echo $emp['firstname'];?>
        </div>
        <div>
            <b>Last Name:</b> <?php echo $emp['lastname'];?>
        </div>   
        <div>
            <b>Contant Number:</b> <?php echo $emp['contact_num'];?>
        </div>
        <div>
            <b>Email:</b> <?php echo $emp['email'];?>
        </div>
    </div>
    <center>
</main>


<?php
    require(VIEW . 'layout/footer.php');
?>