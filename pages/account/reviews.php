<?php
include_once base_path('inc/inc_dbconnect.php');
include_once base_path('inc/inc_table.php');
?>

<!-- Get all of the accounts reviews -->
<?php
$id = $_SESSION['id'];
$reviews = Review::getAccountReviews($con, $id);
?>

<h1> Your Reviews</h1>
<!-- Render these reviews -->
<?php
renderTable($con,$reviews);
?>