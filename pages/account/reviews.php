<?php
include_once base_path('inc/inc_dbconnect.php');
?>

<!-- Get all of the accounts reviews -->
<?php
$id = $_SESSION['id'];
$reviews = Review::getAccountReviews($con, $id);
?>

<!-- Render these reviews -->
<?php
foreach ($reviews as $review) {
    ?>
    <div>
        <h3><?= $review->name ?></h3>
        <p><?= $review->description ?></p>
        <p><?= $review->score ?></p>
        <p><?= $review->created ?></p>
        <p><?= $review->active ?></p>
        <p><?= $review->product ?></p>
        <p><?= $review->account ?></p>

    </div>

    <?php
}
?>