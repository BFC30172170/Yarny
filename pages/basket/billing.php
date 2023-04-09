<?php
include_once base_path('inc/inc_dbconnect.php');
include_once base_path('/lib/basket.php');
?>

<?php

$basket = new Basket($_SESSION);
$products = $basket->getBasketProducts($con);
$total = $basket->getBasketSummary();
$packaging = $basket->getBasketPackaging();
$address = Address::getAddress($con, $basket->addressId);
$account = Account::getAccount($con, $basket->accountId);
?>

<?php
foreach ($products as $product) {
?>
    <div class="flex my-4">
        <img src="<?= $product->image ?>" alt="Angled front view with bag zipped and handles upright." class="w-16 h-16 object-center object-cover sm:rounded-lg mr-2">
        <div>
            <p><?= $product->name ?></p>
            <p>£<?= $product->price ?></p>
        </div>
    </div>
<?php
}
?>

<div>Substotal: £<?= $total ?></div>
<div>Postage and Packaging: £<?= $packaging ?></div>
<div>Grand Total: £<?= $total + $packaging ?></div>

<div>
    <h1 class="text-xl font-black uppercase"><?= $address->postcode ?></h1>
    <p>Name: <?= $address->forename ?> <?= $address->surname ?></p>
    <p><?= $address->line1 ?></p>
    <p><?= $address->line2 ?></p>
    <p><?= $address->line3 ?></p>
    <p><?= $address->town ?></p>
    <p><?= $address->postcode ?></p>
    <p><?= $address->country ?></p>
    <p><?= $address->account ?></p>
</div>

<?php var_dump($account)?>

<a href="/"><button class="border p-2">Checkout</button></a>

<button id="checkout-button">Create Sale</button>

<script>
    const form = document.querySelector('#checkout-button');
    form.addEventListener("click", handleSubmission, false);

    async function handleSubmission(e) {
        e.preventDefault();

        const res = await postSale();
        window.location.href = "http://localhost/account/orders"
        Alpine.store('main').addMessage(res.status, res.message);
    }
    async function postSale() {
        const res = await fetch('http://localhost/api/sale', {
            method: "POST",
        });
        const json = await res.json();
        return json;
    }
</script>