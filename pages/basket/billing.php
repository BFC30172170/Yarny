<?php
include_once base_path('inc/inc_dbconnect.php');
include_once base_path('inc/inc_table.php');
include base_path('inc/inc_user.php');
?>

<?php
// Initialise a basket from the session and retrieve and expand its values.
$basket = new Basket($_SESSION);
$products = $basket->getBasketProducts($con);
$total = $basket->getBasketSummary();
$packaging = $basket->getBasketPackaging();
$address = Address::getAddress($con, $basket->addressId);
$account = Account::getAccount($con, $basket->accountId);
?>


<div class="flex gap-8">
<!-- Render Selected Address -->
<div class="flex flex-col w-full">
<h1>Review your order</h1>
<h2>Products</h2>
<?php
renderTable($con, $products);
?>
<h2>Delivery Address</h2>
<?php
renderTable($con, [$address]);
?>
<h2>Purchase Account</h2>
<?php
renderTable($con, [$account]);
?>
</div>

<!-- Render Basket Summaries -->
<div class="flex flex-col w-96 border-4 p-4 rounded-lg gap-8">
    <h3>Summary</h3>
    <div class="flex">
        <p>Subtotal:</p>
        <p class="ml-auto"> £<?= $total ?></p>
    </div>
    <div class="flex">
        <p>Postage and Packaging:</p>
        <p class="ml-auto"> £<?= $packaging ?></p>
    </div>
    <div class="flex">
        <p>Grand Total:</p>
        <p class="ml-auto"> £<?= $total + $packaging ?></p>
    </div>
    <button class="border-4 p-4 hover:font-bold" id="checkout-button">Create Sale</button>
</div>
</div>


<script>
    // Call the sale api, values do not need to be passed as these are all stored in the session
    const form = document.querySelector('#checkout-button');
    form.addEventListener("click", handleSubmission, false);

    async function handleSubmission(e) {
        e.preventDefault();

        const res = await postSale();
        window.location.href = "/account/orders"
        Alpine.store('main').addMessage(res.status, res.message);
    }
    async function postSale() {
        const res = await fetch('/api/sale', {
            method: "POST",
        });
        const json = await res.json();
        return json;
    }
</script>