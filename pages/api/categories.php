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

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {    
        new Category($con,[]);
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $catDTO = new CategoryDTO($data);
        $cat = Category::createCategory($con, $catDTO);
        $response['status'] = "success";
        $response['message'] = "A new category has been created with id of $cat->id";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
    } catch (\Exception $th) {
        $response['status'] = "failure";
        $response['message'] = "A category could not be created, please try again later.";
    }
    $jsonRes = json_encode($response);
    echo $jsonRes;
}

if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if(isset($data['categoryId'])){
        $id = intval($data['categoryId']);
        $category = Category::deleteCategory($con, $id);
        $response['status'] = "success";
        $response['message'] = "This category has been deleted and is no longer here";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
    }else{
        $response['status'] = "failure";
        $response['message'] = "An ID is required to successfully remove a category.";
    }
    $json = json_encode($response);
    echo $json;
}

?>