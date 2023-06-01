<?php
    $title = 'Error';
    require(VIEW . 'layout/header.php');
?>

<main>
    <h1>Oops!</h1>
    <?php if (!isset($_SESSION['id']) && !isset($_SESSION['username'])): ?>
        <h3>Access to this page is not allowed if not logged in.</h3>
    <?php elseif (isset($_SESSION['booked']) && $_SESSION['booked'] == false): ?>
        <h3>Access to this page is not allowed if you haven't booked yet.
        </h3>
    <?php else: ?>
        <h3>Access to this page is not allowed yet.</h3>
    <?php endif; ?>
</main>

<?php
    require(VIEW . 'layout/footer.php');
?>