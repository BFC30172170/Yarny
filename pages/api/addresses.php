<?php
include_once base_path('/inc/inc_dbconnect.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {    
        new Address($con,[]);
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $addressDTO = new AddressDTO($data);
        $address = Address::createAddress($con, $addressDTO);
        $response['address']=$address;
        $response['status'] = "success";
        $response['message'] = "A new address has been created with id of $address->id";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
    } catch (\Exception $th) {
        $response['status'] = "failure";
        $response['message'] = "A address could not be created, please try again later.";
    }
    $jsonRes = json_encode($response);
    echo $jsonRes;
}