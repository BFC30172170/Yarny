<?php
include_once('../inc/inc_dbconnect.php');
include_once('../lib/products.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id'])){
        $id = $_GET['id'] ?? '0';
        $product = getProduct($con, $id);
        $json = json_encode($product);
        echo $json;
    }else{
        $products = getProducts($con,new Query($_SERVER['QUERY_STRING']));
        $json = json_encode($products);
        echo $json;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {    
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $productDTO = new ProductDTO($data);
        $product = createProduct($con, $productDTO);
        $response['product'] = $product;
        $response['status'] = "success";
        $response['message'] = "A new product has been created with id of $product->id";
    } catch (\Exception $th) {
        $response['status'] = "failure";
        $response['message'] = "A product could not be created, please try again later.";
    }
    $jsonRes = json_encode($response);
    echo $jsonRes;
}

if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    try {    
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $productDTO = new ProductDTO($data);
        $product = createProduct($con, $productDTO);
        $response['product'] = $product;
        $response['status'] = "success";
        $response['message'] = "A new product has been created with id of $product->id";
    } catch (\Exception $th) {
        $response['status'] = "failure";
        $response['message'] = "A product could not be created, please try again later.";
    }
    $jsonRes = json_encode($response);
    echo $jsonRes;
}


if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    $get_string = $_SERVER['QUERY_STRING'];
    parse_str($get_string, $get_array);
    if(isset($get_array['id'])){
        $id = $get_array['id'] ?? '0';
        $product = deleteProduct($con, $id);
        $response['product'] = $product;
        $response['status'] = "success";
        $response['message'] = "This product has been deleted and is no longer here";
    }else{
        $response['status'] = "failure";
        $response['message'] = "An ID is required to successfully remove a product.";
    }
    $json = json_encode($response);
    echo $json;
}


?>