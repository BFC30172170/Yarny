
<?php
include_once('../../inc/inc_dbconnect.php');
include_once('../../inc/inc_session.php');
include_once('../../lib/auth.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $creds = new Credential($_POST);
    $auth = new Auth();

    $response = $auth->userLogin($con,$creds);

    var_dump($response);
    $data = json_decode($json);

    header('Location: /fullstacksitetemplate/pages/account');
}