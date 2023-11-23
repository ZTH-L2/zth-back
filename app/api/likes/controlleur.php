<?php
header('Access-Control-Allow-Origin: *');
require_once "api/utils/utils.php";
require_once "cruds/crud_comments.php";
require_once "cruds/crud_posts.php";
require_once "api/db_connect.php";

// Public
function option_like($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: OPTION, DELETE, GET');
}

// TO DO
function those_i_liked($params){
    if (!is_logged_in())
    {
        return authentification_required_error_message();
    }
    $conn = db_connect();
    
    $page = $params[1];
    $amount_per_page = $params[2];
    $offset = ($page - 1) * $amount_per_page;

    $conn = db_connect();
    $likes = select_all_user_page_amount($conn, $_SESSION["id_user"], $amount_per_page, $offset);
    
    return json_encode($likes);
}

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

function like_one($params){
    if (!is_logged_in())
    {
        return authentification_required_error_message();
    }
    if(!update_post_var())
    {
        return no_data_error_message();
    }
    if(!isset($_POST["id_comment"]))
    {
        return invalid_format_data_error_message();
    }
    
    $id_comment = filter_var($_POST["id_comment"], FILTER_VALIDATE_INT);
    if (!$id_comment)
    {
        return invalid_data_error_message();
    }

    // check if comment exists
    $conn = db_connect();
    $comment = select_comment($conn, $id_comment);
    if (count($comment) == 0)
    {
        return invalid_data_error_message();
    }
    // check if not already liked
    $like = select_like_with_comment_and_user($conn, $_POST["id_comment"], $id_comment);
    if (count($like) == 0)
    {
        return error_message_json(403, "403 Forbidden: You already liked this comment.");
    }
    // like the comment
    $res = create_like($conn, $_SESSION["id_user"], $id_comment);
    if($res)
    {
        http_response_code(201);
        return;
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not like the comment");
    }

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
    if (!is_logged_in())
    {
        return authentification_required_error_message();
    }
    if(!update_post_var())
    {
        return no_data_error_message();
    }  
    if(!isset($_POST["id_comment"]))
    {
        return invalid_format_data_error_message();
    }
    
    $id_comment = filter_var($_POST["id_comment"], FILTER_VALIDATE_INT);
    if (!$id_comment)
    {
        return invalid_data_error_message();
    }

    // check if comment exists
    $conn = db_connect();
    $comment = select_comment($conn, $id_comment);
    if (count($comment) == 0)
    {
        return invalid_data_error_message();
    }
    // check if like exist
    $like = select_like_with_comment_and_user($conn, $_POST["id_comment"], $id_comment);
    if (count($like) != 0)
    {
        return error_message_json(403, "403 Forbidden: You already liked this comment.");
    }
    // unlike the comment
    $res = delete_like($conn, $like["id_like"]);
    if($res)
    {
        http_response_code(201);
        return;
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not like the comment");
    }
}