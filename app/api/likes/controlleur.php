<?php
header('Access-Control-Allow-Origin: *');
require_once "api/utils/utils.php";
require_once "cruds/crud_comments.php";
require_once "cruds/crud_posts.php";
require_once "api/db_connect.php";

// Public
function option_like($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: OPTION, DELETE','GET');
}

// TO DO
function those_i_liked($params){
    return; 
}
// TO DO
function did_i_like_this($params){
    if (!is_logged_in())
    {
        return authentification_required_error_message();
    }
    
    $id_user = $_SESSION["id_user"];
    $id_comment = $params[1];

    $conn = db_connect();
    $stmt = $conn->prepare("SELECT COUNT(*) AS like_count FROM likes WHERE id_user = ? AND id_comment = ?");
    $stmt->bind_param("ii", $id_user, $id_comment); // "ii" indicates integer type

    if(!$stmt->execute())
    {
        return error_message_json(500, "500 Internal Server Error: Could not verify that you liked it");
    }

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return json_encode(["res"=>($row['like_count'] > 0)]);

}

// TO DO
function like_one($params){
    return; 
}
// TO DO
function like_many($params){
    return; 
}
// TO DO
function unlike_many($params){
    return; 
}
// TO DO
function did_i_liked_those($params){
    return; 
}

// TO DO
function unlike_one($params){
    return; 
}