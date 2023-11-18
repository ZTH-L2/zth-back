<?php

function update_post_var(){
    /*
    This function update the $_POST variable
    and return false if it's NULL, true otherwise
    */
    // check if post is empty
    if($_POST == NULL)
    {
        // if empty, check if data was in json
        // if in json it's update $_POST
        $_POST = json_decode(file_get_contents('php://input'), true);
    }
    return !is_null($_POST);
}

function success_json_custom($message){
    echo json_encode([
        "success"=> true,
        "message"=> $message
    ]);
}

function error_json_custom($message){
    echo json_encode([
        "success"=> false,
        "error"=> $message
    ]);
}

function no_data_error(){
    error_json_custom("the body or the data of the request doesn't have any information or we couldn't access it.");
}