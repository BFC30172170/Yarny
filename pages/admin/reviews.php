<?php
include_once base_path('inc/inc_dbconnect.php');
include_once base_path('inc/inc_table.php');
include base_path('inc/inc_admin.php');
?>

<!-- Get all of the accounts reviews -->
<?php
$id = $_SESSION['id'];
$reviews = Review::getReviews($con, $id);
?>

<h1>All Reviews</h1>
<!-- Render these reviews -->
<?php
renderTable($con,$reviews);
?>