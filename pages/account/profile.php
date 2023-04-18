<?php
include_once base_path('inc/inc_dbconnect.php');
include_once base_path('inc/inc_table.php');
include base_path('inc/inc_user.php');
?>

<!-- Get the account and render its details -->
<?php
$id = $_SESSION['id'];
$account = Account::getAccount($con, $id);
$messages = Message::getAccountMessages($con, $id);
?>

<h1>Your Profile</h1>

<?php
renderTable($con,[$account]);
?>

<h2>Your Messages</h2>

<?php
renderTable($con, $messages);
?>