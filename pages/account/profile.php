<?php
include_once base_path('inc/inc_dbconnect.php');
include_once base_path('inc/inc_table.php');
?>

<!-- Get the account and render its details -->
<?php
$id = $_SESSION['id'];
$account = Account::getAccount($con, $id);
?>

<h1>Your Profile</h1>

<?php
renderTable($con,[$account]);
?>