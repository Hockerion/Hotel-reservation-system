<?php
    if(!isset($_SESSION['id']) && !isset($_SESSION['username'])){
        header('Location: /not-allowed');
    }
    if($_SESSION['booked'] == false){
        header('Location: /not-allowed');
    }

    $title = 'Rating the Hotel';
    require(VIEW . 'layout/header.php');
    require(APP . 'rating/process_rating.php');
?>

<main>
<center>
    <h2>Rate the Hotel</h2>

    <form method="POST" action="/rating">
        <div class="star-rating">
            <input class="radio-input" type="radio" id="star5" name="rating" value="5" />
            <label class="radio-label" class for="star5" title="5 stars">5 stars</label>

            <input class="radio-input" type="radio" id="star4" name="rating" value="4" />
            <label class="radio-label" for="star4" title="4 stars">4 stars</label>

            <input class="radio-input" type="radio" id="star3" name="rating" value="3" />
            <label class="radio-label" for="star3" title="3 stars">3 stars</label>

            <input class="radio-input" type="radio" id="star2" name="rating" value="2" />
            <label class="radio-label" for="star2" title="2 stars">2 stars</label>

            <input class="radio-input" type="radio" id="star1" name="rating" value="1" required/>
            <label class="radio-label" for="star1" title="1 star">1 star</label>
        </div>

    <h2>Give a Review (Optional)</h2>
        <label for="title">Review Title:</label>
        <input type="text" name="title" id="title" value="<?php echo $title;?>"><br><br>
        <div class="error"> <?php echo $errors['title']; ?> </div>

        <label for="review">Review:</label>
        <textarea name="review" id="review" maxlength="1000" cols="30" rows="5"><?php if(!empty($review)){echo $review;}?></textarea><br><br>
        <div class="error"> <?php echo $errors['review']; ?> </div>

        <br>  <!-- Submission button -->
        <input type="submit" value="Submit Rating"><br><br>
    </form>

    <br>
    <a href="/">Back to Home</a>
    <br><br><br><br>
</center>
</main>

<?php
    require(VIEW . 'layout/footer.php');
?>