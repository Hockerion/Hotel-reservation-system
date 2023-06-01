<?php
    $title = 'Rooms';
    require(VIEW . 'layout/header.php');
?>

<main>
    <section class="base-room">
    <div class="heading"><h1>All Rooms</h1></div>
        <div class="box-container">
            <div class="box">
                <img src="src/standard.jpg" alt="" class="image">
                <h3 class="title">Standard Room</h3>
                <a href="/standard" class="inline-btn">view room</a>
            </div>
            <div class="box">
                <img src="src/standard-family.jpg" alt="" class="image">
                <h3 class="title">Standard Family Room</h3>
                <a href="/standard-family" class="inline-btn">view room</a>
            </div>
            <div class="box">
                <img src="src/deluxe.jpg" alt="" class="image">
                <h3 class="title">Deluxe Room</h3>
                <a href="/deluxe" class="inline-btn">view room</a>
            </div>
            <div class="box">
                <img src="src/deluxe-family.jpg" alt="" class="image">
                <h3 class="title">Deluxe Family Room</h3>
                <a href="/deluxe-family" class="inline-btn">view room</a>
            </div>
            <div class="box">
                <img src="src/suite.jpg" alt="" class="image">
                <h3 class="title">Suite Room</h3>
                <a href="/suite" class="inline-btn">view room</a>
            </div>

            <div class="box">
                <a href="/" style="font-size: larger">Back to Home</a>
            </div>
            <br><br><br><br>
        </div>
    </div>
    </section>
</main>

<?php
    require(VIEW . 'layout/footer.php');
?>