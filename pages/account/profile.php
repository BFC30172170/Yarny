<?php
include_once '../../inc/inc_head.php';
include_once '../../lib/account.php';
?>

<?php
$id = $_SESSION['id'];
$account = getAccount($con, $id);
?>
        <p><?=$account->id?></p>
        <p><?=$account->username?></p>
        <p><?=$account->role?></p>
        <p><?=$account->email?></p>
        <p><?=$account->telephone?></p>
        <p><?=$account->mobile?></p>
        <p><?=$account->created?></p>



