<?php
include_once base_path('inc/inc_dbconnect.php');
?>

<!-- Get the account and render its details -->
<?php
$id = $_SESSION['id'];
$account = Account::getAccount($con, $id);
?>
<p><?= $account->id ?></p>
<p><?= $account->username ?></p>
<p><?= $account->role ?></p>
<p><?= $account->email ?></p>
<p><?= $account->telephone ?></p>
<p><?= $account->mobile ?></p>
<p><?= $account->created ?></p>