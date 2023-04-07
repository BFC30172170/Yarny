<?php
include_once base_path('/inc/inc_dbconnect.php');


if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id'])){
        $id = $_GET['id'] ?? '0';
        $product = Product::getProduct($con, $id);
        $json = json_encode($product);
        echo $json;
    }else{
        $products = Product::getProducts($con,new Query($_SERVER['QUERY_STRING']));
        $json = json_encode($products);
        echo $json;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {    
        new Product($con,[]);
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        var_dump($data);
        $productDTO = new ProductDTO($data);
        $product = Product::createProduct($con, $productDTO);
        $response['product'] = $product;
        $response['status'] = "success";
        $response['message'] = "A new product has been created with id of $product->id";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
    } catch (\Exception $th) {
        $response['status'] = "failure";
        $response['message'] = "A product could not be created, please try again later.";
    }
    $jsonRes = json_encode($response);
    echo $jsonRes;
}

if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    try {    
        new Product($con,[]);
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $productDTO = new ProductDTO($data);
        $product = Product::updateProduct($con, $productDTO);
        $response['product'] = $product;
        $response['status'] = "success";
        $response['message'] = "Product $product->id has been updated";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
    } catch (\Exception $e) {
        $response['status'] = "failure";
        $response['message'] = $e->getMessage();
    }
    $jsonRes = json_encode($response);
    echo $jsonRes;
}


if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if(isset($data['productId'])){
        $id = intval($data['productId']);
        $product = Product::deleteProduct($con, $id);
        $response['product'] = $product;
        $response['status'] = "success";
        $response['message'] = "This product has been deleted and is no longer here";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
    }else{
        $response['status'] = "failure";
        $response['message'] = "An ID is required to successfully remove a product.";
    }
    $json = json_encode($response);
    echo $json;
}


?>