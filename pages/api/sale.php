<?php
include_once base_path('/inc/inc_dbconnect.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {    
        new Sale($con,[]);
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $basket = new Basket($_SESSION);
        $sale = Sale::createSale($con, $basket);

        $response['status'] = "success";
        $response['message'] = "A new sale has been created with id of $sale->id";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
        $_SESSION['basket'] = [];
    } catch (\Exception $th) {
        $response['status'] = "failure";
        $response['message'] = "A sale could not be created, please try again later.";
    }
    $jsonRes = json_encode($response);
    echo $jsonRes;
}