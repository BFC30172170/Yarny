<?php
include_once base_path('/inc/inc_dbconnect.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    echo 'na';
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if(isset($data['productId'])){
            $id = intval($data['productId']);

        if(isset($_SESSION['basket'])){
            $basket = new Basket($_SESSION);
            $basket->addToBasket($id);
        }else{
            $basket = new Basket($_SESSION);
            $basket->addToBasket($id);
        }
        $_SESSION['basket'] = $basket->productIds;
        
        $product = Product::getProduct($con, $id);
        $response['product'] = $product;
        $response['status'] = "success";
        $response['message'] = "$product->name has been added to your basket";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;

        $jsonRes = json_encode($response);
        echo $jsonRes;
    }
};

if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if(isset($data['productId'])){
        $id = intval($data['productId']);
    if(isset($_SESSION['basket'])){
        $basket = new Basket($_SESSION);
        $basket->removeFromBasket($id);
    }

    $_SESSION['basket'] = $basket->productIds;
    $product = Product::getProduct($con, $id);
    $response['product'] = $product;
    $response['status'] = "success";
    $response['message'] = "$product->name has been removed from your basket";
    $newMessages = $_SESSION['messages'];
    array_push($newMessages, $response);
    $_SESSION['messages'] = $newMessages;

    $jsonRes = json_encode($response);
    echo $jsonRes;
}
};
