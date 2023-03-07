<?php
include_once '../../inc/inc_head.php';
include_once '../../lib/review.php';
?>

<?php
$id = $_SESSION['id'];
$reviews = getAccountReviews($con, $id);
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

