<?php
include_once base_path('inc/inc_dbconnect.php');
include_once base_path('/lib/basket.php');
?>

<?php

$basket = new Basket($_SESSION);
$products = $basket->getBasketProducts($con);

?>

<?php
foreach($products as $product){
            ?>
            <div class="flex my-4">
                <img src="<?= $product->image ?>" alt="Angled front view with bag zipped and handles upright." class="w-16 h-16 object-center object-cover sm:rounded-lg mr-2">
                <div>
                <p><?=$product->name ?></p>
                <p>£<?=$product->price ?></p>
                </div>
            </div>
            <?php
            }
            ?>