<?php
include_once base_path('/inc/inc_dbconnect.php');
include_once base_path('inc/inc_table.php');
?>

<!-- Get all the accounts sales -->
<?php
$id = $_SESSION['id'];
$sales = Sale::getAccountSales($con, $id);
?>
<h1>Your Orders</h1>
<!-- Render each of the sales -->
<?php
renderTable($con,$sales);
?>