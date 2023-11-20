<?php
header('Access-Control-Allow-Origin: *');
require_once "api/utils/utils.php";
require_once "cruds/crud_comments.php";
require_once "cruds/crud_posts.php";
require_once "api/db_connect.php";

// Public
function option_comment($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: OPTION, GET, POST, PUT, DELETE');
}

function get_by_user_page_amount_sorted_by_report($params){
    // /byuser/id_user/page/nb_by_page
    if (!is_logged_in())
    {
        return authentification_required_error_message();
    }
    if (!is_admin())
    {
        return permission_denied_error_message();
    }

    $id_user = $params[1];
    $page = $params[2];
    $amount_per_page = $params[3];
    $offset = ($page-1)*$amount_per_page;

    $conn = db_connect();
    $stmt = $conn->prepare("SELECT * FROM comments WHERE id_user = ? ORDER BY nb_report DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("iii", $id_user, $amount_per_page, $offset); // "i" indicates integer type
    
    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC);;
        $stmt->close();
        return json_encode($comments);
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not get the comments of this user at this page with this amount per page");
    }
}

function get_my_comments_page_amount_sorted_by_likes($params){
    if (!is_logged_in())
    {
        return authentification_required_error_message();
    }

    $id_user = $_SESSION["id_user"];
    $page = $params[1];
    $amount_per_page = $params[2];
    $offset = ($page-1)*$amount_per_page;

    $conn = db_connect();
    $stmt = $conn->prepare("SELECT * FROM comments WHERE id_user = ? ORDER BY nb_like DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("iii", $id_user, $amount_per_page, $offset); // "i" indicates integer type
    
    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC);;
        $stmt->close();
        return json_encode($comments);
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not get your comments at this page with this amount per page");
    }
}

function get_nb_my($params){
    $conn = db_connect();

    $id_user = $_SESSION["id_user"];
    // stmt for statement
    $stmt = $conn->prepare("SELECT COUNT(id_comment) AS comment_count FROM comments WHERE id_user = ?");
    $stmt->bind_param("i", $id_user); // "i" indicates integer type
    
    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $res =  ($row) ? $row['comment_count'] : 0;
        return json_encode(["total" => $res]);
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not count the total number of comment for this post");
    }
}

function get_nb_total($params){
    $conn = db_connect();

    $id_post = $params[0];
    // verifiy if post exist
    $post = select_post($conn, $id_post);
    if (!$post)
    {
        return invalid_data_error_message();
    }

    // stmt for statement
    $stmt = $conn->prepare("SELECT COUNT(id_comment) AS comment_count FROM comments WHERE id_post = ?");
    $stmt->bind_param("i", $id_post); // "i" indicates integer type
    
    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $res =  ($row) ? $row['comment_count'] : 0;
        return json_encode(["total" => $res]);
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not count the total number of comment for this post");
    }
}

function get_nb_total_parent($params){
    $conn = db_connect();

    $id_post = $params[0];
    // verifiy if post exist
    $post = select_post($conn, $id_post);
    if (!$post)
    {
        return invalid_data_error_message();
    }

    // stmt for statement
    $stmt = $conn->prepare("SELECT COUNT(id_comment) AS comment_count FROM comments WHERE id_post = ? AND id_parent_comment = 0");
    $stmt->bind_param("i", $id_post); // "i" indicates integer type
    
    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $res =  ($row) ? $row['comment_count'] : 0;
        return json_encode(["total" => $res]);
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not count the total number of parent comment for this post");
    }
}

function get_nb_total_enfantof_parent($params){
    $conn = db_connect();
    
    $id_post = $params[0];
    // verifiy if post exist
    $post = select_post($conn, $id_post);
    if (!$post)
    {
        return invalid_data_error_message();
    }

    $id_parent_comment = $params[3];
    // verifiy if parent comment exist if needed
    $parent_comment = select_comment($conn, $id_parent_comment);
    if (!$parent_comment)
    {
        return invalid_data_error_message();
    }

    // stmt for statement
    $stmt = $conn->prepare("SELECT COUNT(id_comment) AS comment_count FROM comments WHERE id_post = ? AND id_parent_comment = ?");
    $stmt->bind_param("ii", $id_post, $id_parent_comment); // "i" indicates integer type
    
    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $res =  ($row) ? $row['comment_count'] : 0;
        return json_encode(["total" => $res]);
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not count the total number of enfant comment of a comment for this post");
    }
}

function get_parent_page_amount($params){
    // /id_post/parent/page/nb_by_page
    $id_post = $params[0];

    $conn = db_connect();
    // verifiy if post exist
    $post = select_post($conn, $id_post);
    if (!$post)
    {
        return invalid_data_error_message();
    }

    $page = $params[2];
    $amount_per_page = $params[3];
    $offset = ($page-1)*$amount_per_page;

    $stmt = $conn->prepare("SELECT * FROM comments WHERE id_post = ? AND id_parent_comment = 0 ORDER BY nb_like DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("iii", $id_post, $amount_per_page, $offset); // "i" indicates integer type
    
    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC);;
        $stmt->close();
        return json_encode($comments);
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not get your comments at this page with this amount per page");
    }
}

function get_enfant_of_parent_page_amount($params){
    $conn = db_connect();
    
    $id_post = $params[0];
    // verifiy if post exist
    $post = select_post($conn, $id_post);
    if (!$post)
    {
        return invalid_data_error_message();
    }

    $id_parent_comment = $params[2];
    // verifiy if parent comment exist if needed
    $parent_comment = select_comment($conn, $id_parent_comment);
    if (!$parent_comment)
    {
        return invalid_data_error_message();
    }
    
    $page = $params[3];
    $amount_per_page = $params[4];
    $offset = ($page-1)*$amount_per_page;

    $stmt = $conn->prepare("SELECT * FROM comments WHERE id_post = ? AND id_parent_comment = ? ORDER BY nb_like DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("iiii", $id_post, $id_parent_comment, $amount_per_page, $offset); // "i" indicates integer type
    
    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC);;
        $stmt->close();
        return json_encode($comments);
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not get your comments at this page with this amount per page");
    }
}

function make_comment($params){
    if (!is_logged_in())
    {
        return authentification_required_error_message();
    }
    if (!update_post_var())
    {
        return no_data_error_message();
    }	
    if (!isset($_POST["id_post"]) || !isset($_POST["id_parent_comment"]) || !isset($_POST["content"]))
    {
        return invalid_format_data_error_message();
    }

    $id_post = filter_var($_POST["id_post"], FILTER_VALIDATE_INT);
    $id_parent_comment = filter_var($_POST["id_parent_comment"], FILTER_VALIDATE_INT);
    // this sanitization is handled by the crud, go see it
    $content_dirty = $_POST["content"];

    if (($id_post != 0 && !$id_post) || ($id_parent_comment != 0 && !$id_parent_comment))
    {
        return error_message_json(400, "$id_post, $id_parent_comment");
        //return unsafe_data_error_message();
    }

    $conn = db_connect();

    // verifiy if post exist
    $post = select_post($conn, $id_post);
    if (!$post)
    {
        return invalid_data_error_message();
    }
    // verifiy if parent comment exist if needed
    if ($id_parent_comment != 0)
    {
        $parent_comment = select_comment($conn, $id_parent_comment);
        if (!$parent_comment)
        {
            return invalid_data_error_message();
        }
    }

    $id_user = $_SESSION["id_user"];
    $nb_like = 0;
    $nb_report = 0;

    $res = create_comment($conn, $id_post, $id_user, $id_parent_comment, $nb_like, $nb_report, $content_dirty);
    if ($res)
    {
        http_response_code(201);
        return;
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not create the comment.");
    }
}

function modify_my_comment($params){
    if(is_logged_in())
    {   
        if (!update_post_var())
        {
            return no_data_error_message();
        }
        // get data
        if (!isset($_POST["id_comment"]) || !isset($_POST["content"]))
        {
            return invalid_format_data_error_message();
        }

        $id = filter_var($_POST["id_comment"], FILTER_VALIDATE_INT);
        // we don't sanitize here but in the crud, go see it.
        $content_dirty =  $_POST["content"];

        if (!$id)
        {
            return unsafe_data_error_message();
        }

        $conn = db_connect();
        // belong to me ?
        $comment = select_comment($conn, $id);
        if ($comment)
        {
            if ($comment["id_user"] != $_SESSION["id_user"])
            {
                return permission_denied_error_message();
            }
        }
        else
        {
            return error_message_json(500, "500 Internal Server Error: Could not check if comment belong to user.");
        }

        // update
        $res = update_comment($conn, $id, $content_dirty);
        if ($res)
        {
            return success_message_json(200, "200 OK: Updated comment successfully");
        }
        else
        {
            return error_message_json(500, "500 Internal Server Error: Could not update comment.");
        }

    }
    else
    {
        return authentification_required_error_message();
    }
}

function delete($params){
    if(is_logged_in())
    {
        // get the id
        $id = $params[0];

        // check if comment belong to user or is admin
        $conn = db_connect();
        if (!is_admin())
        {   
            // belong to me ?
            $comment = select_comment($conn, $id);
            if ($comment)
            {
                if ($comment["id_user"] != $_SESSION["id_user"])
                {
                    return permission_denied_error_message();
                }
            }
            else
            {
                return error_message_json(500, "500 Internal Server Error: Could not check if comment belong to user.");
            }
        }

        // delete the comment
        $res = delete_comment($conn, $id);
        // if delete success
        if ($res)
        {
            http_response_code(204);
            return;
        }
        else
        {
            return error_message_json(500, "500 Internal Server Error: Could not delete comment.");
        }   
    }
    else
    {
        return authentification_required_error_message();
    }
}

