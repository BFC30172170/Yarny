<?php
include_once base_path('/inc/inc_dbconnect.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {    
        new Message($con,[]);
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $messageDTO = new messageDTO($data);
        $message = Message::createMessage($con, $messageDTO);
        $message->sendMessage($con);
        $response['status'] = "success";
        $response['message'] = "A Message has been successfully submitted";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
    } catch (\Exception $e) {
        $response['status'] = "failure";
        $mess = $e->getMessage();
        $response['message'] = "An email could not be sent, please check your profile to see if it could be created. within the system.";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
    }
    $jsonRes = json_encode($response);
    echo $jsonRes;
}
