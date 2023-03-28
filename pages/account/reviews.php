<?php
include_once base_path('inc/inc_dbconnect.php');
?>

<?php
$id = $_SESSION['id'];
$reviews = Review::getAccountReviews($con, $id);
?>

<?php
foreach($reviews as $review){
?>
<div>
<h1 class="text-xl font-black uppercase"><?=$review->name?></h1>

<p><?=$review->description?></p>
<p><?=$review->score?></p>
<p><?=$review->created?></p>
<p><?=$review->active?></p>
<p><?=$review->product?></p>
<p><?=$review->account?></p>

</div>

<?php
}
?>

