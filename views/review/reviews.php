<?php
    $title = 'Reviews';
    require(VIEW . 'layout/header.php');
    require_once(MODEL . 'database.php');
    use Database as DB;

    $conn = DB\Connect::db_connect();
    $avg = DB\Rating::rating_avg($conn);
    $ratings = DB\Rating::get_all_ratings($conn);
?>

<main>
<center>
    <h2>Overall Hotel Rating: </h2>
    <h1><?php echo $avg;?></h1>

    <br><br>
    <h2>User Reviews: </h2>

    <?php foreach($ratings as $rating){?>
        <?php if(!empty($rating['title'])):?>
            <div class="review-container">
                <div class="name">
                    <b>Username:</b> <?php $name = DB\Member::get_username($conn, $rating['member_id']);
                    echo $name;?>
                </div>
                <div class="date">
                    <b>Date Posted:</b> <?php echo $rating['rate_date'];?>
                </div>
                <div class="rating">
                    <b>Rating:</b> <?php echo $rating['rating'];?>
                </div>
                <div class="title">
                    <b>"<?php echo $rating['title'];?>"</b>
                </div>   
                <div class="review">
                    <?php echo $rating['review'];?>
                </div>
            </div>
        <?php endif; ?>
    <?php }?>
    
    <br>
    <a href="/">Back to Home</a>
    <br><br><br><br>
</center>
</main>

<?php
    require(VIEW . 'layout/footer.php');
?>