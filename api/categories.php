<?php
include_once('../inc/inc_dbconnect.php');
include_once('../lib/categories.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id'])){
        $id = $_GET['id'] ?? '0';
        $product = getCategory($con, $id);
        $json = json_encode($product);
        echo $json;
    }else{
        $products = getCategories($con);
        $json = json_encode($products);
        echo $json;
    }
}

?>