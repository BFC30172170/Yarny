<?php
include_once('../inc_dbconnect.php');
include_once('../lib/products.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id'])){
        $id = $_GET['id'] ?? '0';
        $product = getProduct($con, $id);
        $json = json_encode($product);
        echo $json;
    }else{
        $products = getProducts($con,new Query('dasdsa'));
        $json = json_encode($products);
        echo $json;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $json = file_get_contents('php://input');
    var_dump($json);
    $data = json_decode($json);

    json_last_error();
    var_dump($json, $data);
    $product = createProduct($con, $data);
    $jsonRes = json_encode($product);
    echo $jsonRes;
}

if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    $get_string = $_SERVER['QUERY_STRING'];
    parse_str($get_string, $get_array);
    if(isset($get_array['id'])){
        $id = $get_array['id'] ?? '0';
        echo $id;
        $product = deleteProduct($con, $id);
        $json = json_encode($product);
        echo $json;
    }else{
        echo 'id required';
    }
}


?>