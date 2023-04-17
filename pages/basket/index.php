<?php
include_once base_path('inc/inc_dbconnect.php');
?>
<!-- First step of checkout process -->


<?php
// Initialise basket and get products and summary
$basket = new Basket($_SESSION);
$products = $basket->getBasketProducts($con);
$total = $basket->getBasketSummary();
$packaging = $basket->getBasketPackaging();

?>

<?php
// Render each product in the basket
foreach ($products as $product) 
{
?>
    <div class="flex my-4">
        <img src="<?= $product->image ?>" alt="Angled front view with bag zipped and handles upright." class="w-16 h-16 object-center object-cover sm:rounded-lg mr-2">
        <div>
            <p><?= $product->name ?></p>
            <p>£<?= $product->price ?></p>
        </div>
        <button onclick="removeFromBasket(<?=$product->id?>)">Remove from basket</button>
    </div>
<?php
}
?>

<!-- Render the basket summaries -->
<div>Substotal: £
    <?= $total ?>
</div>
<div>Postage and Packaging: £
    <?= $packaging ?>
</div>
<div>Grand Total: £
    <?= $total + $packaging ?>
</div>
<a href="/basket/delivery"><button class="border p-2">Continue</button></a>

<script>
const removeFromBasket = async (id) => {
    const res = await fetch('/api/basket', {
        method: 'DELETE',
        body: JSON.stringify({
            'productId': id
        })
    });
    const json = await res.json();
    Alpine.store('main').addMessage(json.status, json.message)
    window.location.href = "/basket"
}
</script>