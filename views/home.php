<?php
    $title = 'Home';
    require(APP . 'utils/home_manage_session.php');
    require(VIEW . 'layout/header.php');
?>

<main class="set-img">
    <img src="">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="success"><?php echo $_SESSION['message'];?></div>
    <?php endif; ?>

    <h1 class="home">Hotel Visaias</h1>
</main>

<?php
    if(isset($_SESSION['message'])){
        unset($_SESSION['message']);
    }
    require(VIEW . 'layout/footer.php');
?>