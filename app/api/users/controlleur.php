<?php
header('Access-Control-Allow-Origin: *');
require_once "api/utils/utils.php";
require_once "api/users/crud_users.php";
require_once "api/db_connect.php";


function option_user($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET');
}


function get_user($params){
    null;
}

function register($params){
    if (update_post_var())
    {
        $conn = db_connect();

        // get the data
        if (isset($_POST["username"]) && isset($_POST["mail"]) && isset($_POST["password"]))
        {
            $username_dirty = $_POST["username"];
            $mail_dirty = $_POST["mail"];
            $password_dirty_raw = $_POST["password"];
        }
        else
        {
            error_json_custom("The data in not formated correctly (invalid keys)");
            return;
        }

        // sanitize the data
        $username = filter_var($username_dirty);
        $mail = filter_var($mail_dirty, FILTER_SANITIZE_EMAIL);
        $password_raw = filter_var($password_dirty_raw);

        if (!$username || !$mail || !$password_raw)
        {
            error_json_custom("The data is not safe");
            return;
        }
        
        // validate the data format
        $password_regex  = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        $username_regex  = '/^[a-zA-Z0-9_-]{3,16}$/';
        
        if (!filter_var($username, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $username_regex]]) ||
            !filter_var($password_raw, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $password_regex]]) || 
            !filter_var($mail, FILTER_VALIDATE_EMAIL))
        {
            error_json_custom("The data does not match our validation policy.");
            return;
        }
        
        // check if the user name is available
        if(count(select_all_user_with_parameter($conn, "username", $username)) != 0)
        {
            error_json_custom("CHANGE ME PLEASE : the username can't be choosen");
            return;
        }

        // Hash the password
        $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

        // Set the final variables
        $permission = 0;
        $restricted = 0;
        $first_connexion = date("Y-m-d");

        // register the user in the db
        create_user($conn, $mail, $username, $password_hashed, $permission, $restricted, $first_connexion);

    }
    else
    {
       no_data_error();
       return;
    }
    
}


function put_user($params){
    return;
}

function delet_user($params){
    return;
}




