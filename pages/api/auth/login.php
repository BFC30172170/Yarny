
<?php
include_once base_path('/inc/inc_dbconnect.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {    
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $auth = new Auth();
        $creds = new Credential($data);
        $auth->userLogin($con,$creds);

        $response['status'] = "success";
        $response['message'] = $auth->message;
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
    } catch (\Exception $th) {
        $response['status'] = "failure";
        $response['message'] = "A product could not be created, please try again later.";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
    }
    $jsonRes = json_encode($response);
    echo $jsonRes;
}