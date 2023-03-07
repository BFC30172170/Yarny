<?php
include_once '../../inc/inc_head.php';
include_once '../../lib/sales.php';
?>

<?php
$id = $_SESSION['id'];
$sales = getAccountSales($con, $id);
?>

<?php
foreach($sales as $sale){
?>
<div>
<h1 class="text-2xl font-black uppercase">Order #<?=$sale->id?></h1>
<p>Created: <?=$sale->created?></p>
<p>Processed: <?=$sale->processed?></p>
<p>Dispatched: <?=$sale->dispatched?></p>
<p>Arrival: <?=$sale->estimatedArrival?></p>
<p>Status: <?=$sale->status?></p>
<p>Account: <?=$sale->account?></p>
</div>
<br/>
<h1 class="text-xl font-black uppercase">Deliver to <?=$sale->address->postcode?></h1>
<p>Name: <?=$sale->address->forename?> <?=$sale->address->surname?></p>
<p><?=$sale->address->line1?></p>
<p><?=$sale->address->line2?></p>
<p><?=$sale->address->line3?></p>
<p><?=$sale->address->town?></p>
<p><?=$sale->address->postcode?></p>
<p><?=$sale->address->country?></p>
<p><?=$sale->address->account?></p>
</div>


<h1 class="text-xl font-black uppercase">Sale Rows: <?=count($sale->saleRows)?></h1>
<div class="flex gap-2">
<?php
foreach($sale->saleRows as $saleRow){
?>
<div class="bg-amber-200 p-4 rounded-md">
    <p>original price: <?=$saleRow->originalPrice?></p>
    <p>final price: <?=$saleRow->finalPrice?></p>
    <p>quantity: <?=$saleRow->quantity?></p>
    <p>sale ID: <?=$saleRow->sale?></p>
    <p>Product ID: <?=$saleRow->product?></p>
</div>
<?php
}
?>
</div>
<?php
}
?>
