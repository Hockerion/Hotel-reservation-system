<?php
$title = 'Employee Panel';
require(VIEW . 'layout/header_emp.php');
date_default_timezone_set('Asia/Singapore');

// check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: /login-employee");
    exit();
}

// upon clicking time in button
if (isset($_POST['time_in'])) {
    // unset time_out and set time_in
    setcookie('time_out', '', time() - 3600, '/');
    setcookie('time_in', time(), time() + (86400 * 30), '/');
    header("Location: /emp-panel"); // Redirect to reload the page after setting cookies
    exit();
}

// upon clicking time out button
if (isset($_POST['time_out'])) {
    // time out and calculate the total time worked
    setcookie('time_out', time(), time() + (86400 * 30), '/');
    header("Location: /emp-panel"); // Redirect to reload the page after setting cookies
    exit();
}

// check if the user had already timed out
if (isset($_COOKIE['time_out'])) {
    // calculate total time worked
    $total_time = $_COOKIE['time_out'] - $_COOKIE['time_in'];

    // format timestamps
    $time_in_formatted = date("F j, Y || h:i:s A", $_COOKIE['time_in']);
    $time_out_formatted = date("F j, Y || h:i:s A", $_COOKIE['time_out']);

    // format total time worked
    $hours = floor($total_time / 3600);
    $minutes = floor(($total_time % 3600) / 60);
    $seconds = $total_time % 60;
    $total_shift_time = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

    // check if total shift time is less than 8 hours
    if ($total_time < 8 * 60 * 60) { 
        $shift_status = "Incomplete";
    } else {
        $shift_status = "Complete";
    }
}
?>

<main>
<center>
    <h1>Welcome, <?php echo $_SESSION['username'] . "!"; ?></h1>
    <h2>Current Time: <?php echo date("F j, Y || h:i:s A"); ?></h2><br>

    <?php if (isset($_COOKIE['time_in'])): ?>
        <p>Time In: <?php echo date("F j, Y || h:i:s A", $_COOKIE['time_in']); ?></p><br>
    <?php endif; ?>

    <?php if (isset($_COOKIE['time_out'])): ?>
        <p>Time Out: <?php echo date("F j, Y || h:i:s A", $_COOKIE['time_out']); ?></p><br>
        <p>Total Shift Time: <?php echo $total_shift_time; ?></p><br>
        <p>Shift Status: <?php echo $shift_status; ?></p><br>
    <?php endif; ?>

    <?php if (!isset($_COOKIE['time_in']) && !isset($_COOKIE['time_out'])): ?>
        <form method="post" action="/emp-panel">
            <input type="submit" name="time_in" value="Time In"> 
        </form>
    <?php elseif (isset($_COOKIE['time_out']) && isset($_COOKIE['time_in'])): ?>
        <form method="post" action="/emp-panel">
            <input type="submit" name="time_in" value="Time In"> 
        </form>

    <?php elseif (!isset($_COOKIE['time_out'])): ?>
        <br><br><br>
        <form method="post" action="/emp-panel">
            <input type="submit" name="time_out" value="Time Out">
        </form>
    <?php endif; ?>
</center>
</main>

<?php
require(VIEW . 'layout/footer.php');
?>