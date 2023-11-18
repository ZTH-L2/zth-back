<?php
session_start();
header('Access-Control-Allow-Origin: *');
require_once "api/utils/utils.php";
require_once "api/users/crud_users.php";
require_once "api/db_connect.php";


function option_user($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: OPTION, POST');
}


function get_user($params){
    echo json_encode(["succes"=>true,"message"=>"not implemented yet"]);
}

function login($params){
    if (update_post_var())
    {
        $conn = db_connect();

        // get the data
        if (isset($_POST["username"]) && isset($_POST["password"]))
        {
            $username_dirty = $_POST["username"];
            $password_dirty_raw = $_POST["password"];
        }
        else
        {
            error_json_custom("The data in not formated correctly (invalid keys)");
            return;
        }

        // sanitize the data
        $username = filter_var($username_dirty);
        $password_raw = filter_var($password_dirty_raw);

        if (!$username || !$password_raw)
        {
            error_json_custom("The data is not safe");
            return;
        }

        // search for username in users
        $user = select_user_by_username($conn, $username);
        // if not found
        if(count($user) == 0)
        {
            // We know that it's the username that is wrong
            // But we say also wrong password to not give any
            // information of who has an account on our website
            error_json_custom("Wrong username or password");
            return;
        }
        
        // if found and good password
        if (password_verify($password_raw, $user["password"]))
        {
            // should not happen but if the user was already connected
            // we disconnect first : 
            // mutliple option :
            // destroy the session with session_destroy()
            // unset the session with session_unset()
            // unset specific variables with unset($_SESSION["varname"])

            // for now we will go with unset(). 
            session_unset();

            // set the session 
            $_SESSION["id_user"] = $user["id_user"];
            $_SESSION["mail"] = $user["mail"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["permission"] = $user["permission"];
            $_SESSION["restricted"] = $user["restricted"];
            $_SESSION["first_connexion"] = $user["first_connexion"];

            // echo success
            success_json_custom("Logged in successfully");
        }
        else
        {
            error_json_custom("Wrong username or password");
            return; 
        }
    }
    else
    {
        no_data_error();
    }
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
    }
    
}


function put_user($params){
    return;
}

function delet_user($params){
    return;
}




