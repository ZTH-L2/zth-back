<?php
header('Access-Control-Allow-Origin: *');

require_once "api/utils/utils.php";
require_once "cruds/crud_authors.php";
require_once "api/db_connect.php";

function option_author($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
}

function get_author($params){
    $conn = db_connect();
    $id = $params[0];
    $res = select_author($conn, $id);
    if (is_null($res))
    {
        return json_encode([]);
    }
    else
    {
        return json_encode($res);
    }
}

function get_author_by_user($params){
    $conn = db_connect();
    $id = $params[1];
    $res = select_author_by_user($conn, $id);
    if (is_null($res))
    {
        return json_encode([]);
    }
    else
    {
        return json_encode($res);
    }
}

function get_author_by_post($params){
    $conn = db_connect();
    $id = $params[1];
    $res = select_author_by_post($conn, $id);
    if (is_null($res))
    {
        return json_encode([]);
    }
    else
    {
        return json_encode($res);
    }
}

function post_author($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                $conn = db_connect();

                // get the data
                if (isset($_POST["id_user"]) && isset($_POST["id_post"]))
                {
                    $id_user_dirty = $_POST["id_user"];
                    $id_post_dirty = $_POST["id_post"];

                }
                else
                {
                    return invalid_format_data_error_message();
                }

                // sanitize the data
                $id_user = filter_var($id_user_dirty, FILTER_VALIDATE_INT);
                $id_post = filter_var($id_post_dirty, FILTER_VALIDATE_INT);


                if ($id_user  == "" || $id_post == "")
                {
                    return unsafe_data_error_message();
                }
                $res = create_author($conn, $id_user, $id_post);
                if ($res)
                {
                    return success_message_json(201, "201 Created: New author successfully created");
                }
                else
                {
                    return error_message_json(500, "500 Internal Server Error: Could not create the author");
                }
            }
            else
            {
                no_data_error_message();   
            }
        }
        else
        {
            return permission_denied_error_message();
        }
    }
    else
    {
        return authentification_required_error_message();
    }
}

function del_author($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            $conn = db_connect();
            delete_author($conn, $params[0]);
            if (mysqli_affected_rows($conn) > 0)
            {
                return success_message_json(200, "200 OK: Deleted author successfully");
            }
            else
            {
                return success_message_json(200, "200 OK: Deleted nothing but successfull");
            }
        }
        else
        {
            return permission_denied_error_message();
        }
    }
    else
    {
        return authentification_required_error_message();
    }
}

function put_author($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                $conn = db_connect();
            
                // get the data
                if (isset($_POST["id_author"]) && isset($_POST["id_user"]) && isset($_POST["id_post"]))
                {
                    $id_dirty = $_POST["id_author"];
                    $id_user_dirty = $_POST["id_user"];
                    $id_post_dirty = $_POST["id_post"];
                }
                else
                {
                    return invalid_format_data_error_message();
                }
            
                // sanitize the data
                $id_user = filter_var($id_user_dirty, FILTER_VALIDATE_INT);
                $id_post = filter_var($id_post_dirty, FILTER_VALIDATE_INT);
                $id = filter_var($id_dirty, FILTER_VALIDATE_INT);

                if ($id == "" || $id_user == "" || $id_post == "")
                {
                    return unsafe_data_error_message();
                }
                
                $res = update_author($conn, $id_user, $id_post, $id);
                if ($res)
                {
                    return success_message_json(200, "200 OK: Updated author's information successfully.") ;
                }
                else
                {
                    return error_message_json(500, "500 Internal Server Error: Could not update author's information.");
                }
            }
            else
            {
                no_data_error_message();   
            }
        }
        else
        {
            return permission_denied_error_message();
        }
    }
    else
    {
        return authentification_required_error_message();
    }
}
