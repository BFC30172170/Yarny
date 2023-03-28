<?php
include_once('../inc/inc_dbconnect.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id'])){
        $id = $_GET['id'] ?? '0';
        $product = Category::getCategory($con, $id);
        $json = json_encode($product);
        echo $json;
    }else{
        $products = Category::getCategories($con);
        $json = json_encode($products);
        echo $json;
    }
}

?>