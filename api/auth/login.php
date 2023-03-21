
<?php
include_once('../../inc/inc_dbconnect.php');
include_once('../../inc/inc_session.php');
include_once('../../lib/auth.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $creds = new Credential($data);
    $auth = new Auth();
    $auth->userLogin($con,$creds);

    $response['status'] = "success";
    $response['message'] = "Login Successful!";
    $newMessages = $_SESSION['messages'];
    array_push($newMessages, $response);
    $_SESSION['messages'] = $newMessages;

    $jsonRes = json_encode($response);
    echo $jsonRes;
}