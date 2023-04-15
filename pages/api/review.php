<?php
include_once base_path('/inc/inc_dbconnect.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {    
        new Review($con,[]);
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $reviewDTO = new ReviewDTO($data);
        $review = Review::createReview($con, $reviewDTO);
        $response['review'] = $review;
        $response['status'] = "success";
        $response['message'] = "A new product has been created with id of $review->id";
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