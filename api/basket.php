<?php
include_once('../inc/inc_dbconnect.php');
include_once('../lib/products.php');
include_once('../lib/basket.php');
include_once('../inc/inc_session.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    echo 'na';
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // try {
        $get_string = $_SERVER['QUERY_STRING'];
        parse_str($get_string, $get_array);
        if(isset($get_array['productId'])){
            $id = intval($get_array['productId']);

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        if(isset($_SESSION['basket'])){
            $basket = new Basket($_SESSION);
            $basket->addToBasket($id);
        }else{
            $basket = new Basket($_SESSION);
            $basket->addToBasket($id);
        }
        $_SESSION['basket'] = $basket->productIds;
        $jsonRes = json_encode($basket);
        echo $jsonRes;
    }
    // } catch (\Throwable $th) {
    //     http_response_code(500);
    //     $jsonRes = json_encode($th);
    //     echo $jsonRes;
    // }

};
