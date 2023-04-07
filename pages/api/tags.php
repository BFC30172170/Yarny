<?php
include_once base_path('/inc/inc_dbconnect.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {    
        new Tag($con,[]);
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $tagDTO = new TagDTO($data);
        $tag = Tag::createTag($con, $tagDTO);
        $response['status'] = "success";
        $response['message'] = "A new tag has been created with id of $tag->id";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
    } catch (\Exception $th) {
        $response['status'] = "failure";
        $response['message'] = "A tag could not be created, please try again later.";
    }
    $jsonRes = json_encode($response);
    echo $jsonRes;
}

if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if(isset($data['tagId'])){
        $id = intval($data['tagId']);
        $tag = Tag::deleteTag($con, $id);
        $response['status'] = "success";
        $response['message'] = "This tag has been deleted and is no longer here";
        $newMessages = $_SESSION['messages'];
        array_push($newMessages, $response);
        $_SESSION['messages'] = $newMessages;
    }else{
        $response['status'] = "failure";
        $response['message'] = "An ID is required to successfully remove a tag.";
    }
    $json = json_encode($response);
    echo $json;
}