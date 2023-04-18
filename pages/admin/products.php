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

<h1>All Products</h1>

<?php
renderTable($con,$products);
?>
