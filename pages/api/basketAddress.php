<?php
include_once base_path('/inc/inc_dbconnect.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // try {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if(isset($data['id'])){

        $_SESSION['address'] = $data['id'];
        
        $basket = new Basket($_SESSION);
        $ressponse['basket'] = $basket;
        $response['status'] = "success";
        $response['message'] = "An address has been added to the basket";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
        $jsonRes = json_encode($response);
        echo $jsonRes;
    }
    // } catch (\Throwable $th) {
    //     http_response_code(500);
    //     $jsonRes = json_encode($th);
    //     echo $jsonRes;
    // }

};
