<?php
include_once base_path('inc/inc_dbconnect.php');
?>

<?php
$id = $_SESSION['id'];
$addresses = Address::getAccountAddresses($con, $id);
?>

<?php
foreach($addresses as $address){
?>
<div>
<h1 class="text-xl font-black uppercase"><?=$address->postcode?></h1>
<p>Name: <?=$address->forename?> <?=$address->surname?></p>
<p><?=$address->line1?></p>
<p><?=$address->line2?></p>
<p><?=$address->line3?></p>
<p><?=$address->town?></p>
<p><?=$address->postcode?></p>
<p><?=$address->country?></p>
<p><?=$address->account?></p>
</div>

<?php
}
?>
