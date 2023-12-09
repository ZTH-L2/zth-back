<?php

require_once "api/utils/utils.php";
require_once "cruds/crud_subscriptions.php";
require_once "api/db_connect.php";
require_once "api/majors/controlleur.php";

function option_subscription($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
}

function get_subscription($params){
    $conn = db_connect();
    $id = $params[0];
    $res = select_subscription($conn, $id);
    if (is_null($res))
    {
        return json_encode([]);
    }
    else
    {
        return json_encode($res);
    }
}

function get_is_subscibe($params){
    if (is_logged_in())
    {
        $conn = db_connect();
        $id_user = $_SESSION["id_user"];
        $major = $params[1];
        $res = is_subscribe($conn, $id_user, $major);
        if ($res == []){
            return 0;
        }
        else{
            return 1;
        }
    }
    else
    {
        return authentification_required_error_message();
    }
}

function delete_sub($params){
    if (is_logged_in())
    {
        $conn = db_connect();
        $id_user = $_SESSION["id_user"];
        $major = $params[2];
        delete_sub_data($conn, $id_user, $major);
        if (mysqli_affected_rows($conn) > 0)
        {
            return success_message_json(200, "200 OK: Deleted subscription successfully");
        }
        else
        {
            return success_message_json(200, "200 OK: Deleted nothing but successfull");
        }
    }
    else
    {
        return authentification_required_error_message();
    }
}
function get_subscription_by_id($params){
    if (is_logged_in())
    {
        $conn = db_connect();
        $id = $_SESSION["id_user"];
        $res = select_subscription_by_user($conn, $id);
        if (is_null($res))
        {
            return json_encode([]);
        }
        else
        {
            $data = [];
            for ($i=0; $i < count($res); $i++)
            {
                $data[] = ["id_major" => $res[$i][2], "major_name" => get_major_name($res[$i][2])[0], "year" => get_major_name($res[$i][2])[1]];
            }
            return json_encode($data);
        }
    }
    else
    {
        return authentification_required_error_message();
    }
}
function post_subscription($params){
    if (is_logged_in())
    {
            if (update_post_var())
            {
                $conn = db_connect();

                // get the data
                if (isset($_POST["id_user"]) && isset($_POST["id_major"]))
                {
                    $id_user_dirty = $_POST["id_user"];
                    $id_major_dirty = $_POST["id_major"];
                }
                else
                {
                    return invalid_format_data_error_message();
                }

                // sanitize the data
                $id_user = filter_var($id_user_dirty, FILTER_VALIDATE_INT);
                $id_major = filter_var($id_major_dirty, FILTER_VALIDATE_INT);


                if ($id_user == "" || $id_major == "")
                {
                    return unsafe_data_error_message();
                }
                if ($id_user == $_SESSION["id_user"]){
                    $res = create_subscription($conn, $id_user, $id_major);
                    if ($res)
                    {
                        return success_message_json(201, "201 Created: New subscription successfully created");
                    }
                    else
                    {
                        return error_message_json(500, "500 Internal Server Error: Could not create the subscription");
                    }
                }
                else
                {
                    return authentification_required_error_message();
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

function del_subscription($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            $conn = db_connect();
            delete_subscription($conn, $params[0]);
            if (mysqli_affected_rows($conn) > 0)
            {
                return success_message_json(200, "200 OK: Deleted subscription successfully");
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

function put_subscription($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                $conn = db_connect();
            
                // get the data
                if (isset($_POST["id_subscription"]) && isset($_POST["id_user"]) && isset($_POST["id_major"]))
                {
                    $id_dirty = $_POST["id_subscription"];
                    $id_user_dirty = $_POST["id_user"];
                    $id_major_dirty = $_POST["id_major"];
                }
                else
                {
                    return invalid_format_data_error_message();
                }
            
                // sanitize the data
                $id = filter_var($id_dirty, FILTER_VALIDATE_INT);
                $id_user = filter_var($id_user_dirty, FILTER_VALIDATE_INT);
                $id_major = filter_var($id_major_dirty, FILTER_VALIDATE_INT);

                if ($id == "" || $id_user == "" || $id_major == "")
                {
                    return unsafe_data_error_message();
                }
            
                $res = update_subscription($conn, $id_user, $id_major, $id);
                if ($res)
                {
                    return success_message_json(200, "200 OK: Updated subscription's information successfully.") ;
                }
                else
                {
                    return error_message_json(500, "500 Internal Server Error: Could not update subscription's information.");
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
