<?php
include_once base_path('inc/inc_dbconnect.php');
include_once base_path('inc/inc_table.php');
include base_path('inc/inc_admin.php');
?>

<!-- Get the account and render its details -->
<?php
$id = $_SESSION['id'];
$query = new Query('active=false');
$products = Product::getProducts($con,$query);
?>
<div class="flex items-center">
<h1>All Products</h1>
<a href="/products/new" class="p-2 border-2 shadow-md rounded-lg hover:shadow-lg hover:font-bold ml-auto bg-teal-300">ADD NEW PRODUCT</a>
</div>

<?php
renderTable($con,$products);
?>
