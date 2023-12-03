<?php
header('Access-Control-Allow-Origin: *');
require_once "api/utils/utils.php";
require_once "cruds/crud_users.php";
require_once "api/db_connect.php";

// Public
function option_user($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
}


//Public
function get_name_by_id($params){
    if (1)
    {
        $conn = db_connect();
        $id = $params[1];
        // CRUD function
        $user_data = select_user_name($conn, $id);
        if (is_null($user_data))
        {
            $user_json = json_encode([]);
        }
        else
        {
            $user_json = json_encode($user_data); 
        }
        return $user_json;
        
    }
    else
    {
        return authentification_required_error_message();
    }
}

// Public Protected by admin
function get_user_by_id($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            $conn = db_connect();
            $id = $params[0];
            // CRUD function
            $user_data = select_user($conn, $id);
            if (is_null($user_data))
            {
                $user_json = json_encode([]);
            }
            else
            {
                $user_json = json_encode(make_data_of_user($user_data)); 
            }
            return $user_json;
            
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
// Public Protected by admin
function delet_user_by_id($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            $id = $params[0];
            // You can't suppress your own account 
            // with this function.
            // the admin should call /user with a DELETE method
            // when connected to delete his own account.
            if ($id == $_SESSION["id_user"])
            {
                return error_message_json(403, "403 Forbidden: Can't suppress your own account on this route. Go to the /user with a DELETE method while connected to delete your own account.");
            }
            
            $conn = db_connect();
            // CRUD function
            $res = delete_user($conn, $id);
            if ($res)
            {
                // we might want to know if we actually suppressed
                // something or not
                $affected_rows = mysqli_affected_rows($conn);
                if ($affected_rows>0)
                {
                    //  we have a message
                    $res = success_message_json(200, "200 OK: Deleted user successfully");
                    // this is the lightest but no message :
                    // http_response_code(204);
                    // return;
                }
                else
                {
                    $res = success_message_json(200, "200 OK: Deleted nothing but successfull");
                }
                
            }
            else
            {
                $res = error_message_json(500, "500 Internal Server Error: Could not delet user.");
            }
            return $res;
            
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
// Public Require authentification
function login($params){
    if (update_post_var())
    {
        
        // get the data
        if (isset($_POST["username"]) && isset($_POST["password"]))
        {
            $username_dirty = $_POST["username"];
            $password_dirty_raw = $_POST["password"];
        }
        else
        {
            return invalid_format_data_error_message();
        }

        // sanitize the data
        $username = filter_var($username_dirty);
        $password_raw = filter_var($password_dirty_raw);
        
        if (!$username || !$password_raw)
        {
            return unsafe_data_error_message();
        }
        
        $conn = db_connect();
        // search for username in users
        $user = select_user_by_username($conn, $username);
        // if not found
        if(is_null($user))
        {
            // We know that it's the username that is wrong
            // But we say also wrong password to not give any
            // information of who has an account on our website
            return error_message_json(401, "401 Unauthorized: Invalid username or password.");
        }
        
        // if found and good password
        if (password_verify($password_raw, $user["password"]))
        {
            // should not happen but if the user was already connected
            if (is_logged_in())
            {
                session_unset();
            }

            // update the restriction
            $latest_date = new DateTime($user["first_connexion"]);
            $latest_date->add(new DateInterval('PT1H'));
            $today = new DateTime();

            if ($today > $latest_date)

            // set the session 
            $_SESSION["id_user"] = $user["id_user"];
            $_SESSION["mail"] = $user["mail"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["permission"] = $user["permission"];
            $_SESSION["restricted"] = $user["restricted"];
            $_SESSION["first_connexion"] = $user["first_connexion"];
            $_SESSION["data_size"] = $user["data_size"];

            // echo 
            $user_data = make_data_of_user($_SESSION);
            return json_encode($user_data);
        }
        else
        {
            return error_message_json(401, "401 Unauthorized: Invalid username or password.");

        }
    }
    else
    {
        return no_data_error_message();
    }
}
// Public Not protected
function logout($params){
    session_unset();
    return success_message_json(204, "204 No Content: Logged out successfully.");
}
// Public 
function register($params){
    if (is_logged_in())
    {
        return error_message_json(403,"403 Forbidden: You are already logged in. Registration is not allowed while logged in.");
    }

    if (update_post_var())
    {   
        if (isset($_POST["username"]) && isset($_POST["mail"]) && isset($_POST["password"]))
        {
            $username_dirty = $_POST["username"];
            $mail_dirty = $_POST["mail"];
            $password_dirty_raw = $_POST["password"];
        }
        else
        {
            return invalid_format_data_error_message();
        }

        // sanitize the data
        $username = filter_var($username_dirty);
        $mail = filter_var($mail_dirty, FILTER_SANITIZE_EMAIL);
        $password_raw = filter_var($password_dirty_raw);
        
        if (!$username || !$mail || !$password_raw)
        {
            return unsafe_data_error_message();
        }

        // validate the data format
        $password_regex  = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        $username_regex  = '/^[a-zA-Z0-9_-]{3,16}$/';
        
        if (!filter_var($username, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $username_regex]]) ||
        !filter_var($password_raw, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $password_regex]]) || 
            !filter_var($mail, FILTER_VALIDATE_EMAIL))
        {
            return enforce_data_policy_error_message();
            
        }
        
        $conn = db_connect();
        // check if the user name is available
        if(count(select_all_user_with_parameter($conn, "username", $username)) != 0)
        {
            return cant_be_used_data_error_message();
        }

        // check if the mail is available
        if(count(select_all_user_with_parameter($conn, "mail", $mail)) != 0)
        {
            return cant_be_used_data_error_message();
        }

        $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);
        
        // Set the final variables
        $permission = 0;
        $restricted = 0;
        $first_connexion = date("Y-m-d");
        $data_size = 0;

        $conn = db_connect();
        // register the user in the db
        $res = create_user($conn, $mail, $username, $password_hashed, $permission, $restricted, $first_connexion, $data_size);
        if ($res)
        {
            $res = success_message_json(201, "201 Created: New user successfully created");
        }
        else
        {
            $res = error_message_json(500, "500 Internal Server Error: Could not create the user");
        }
        return $res;
    }
    else
    {
        return no_data_error_message();
    }
    
}
// Public Protected by authentification
function update_my_account($params){
    if (is_logged_in())
    {
        // should not happen
        if (!isset($_SESSION["permission"]) || !isset($_SESSION["restricted"]) || !isset($_SESSION["first_connexion"]))
        {
            return error_message_json(401, "401 Unauthorized: lack of permission, restricetd and first_connexion. Try to logout and log back in.");
        }

        // if not data in the request
        if (!update_post_var())
        {
            return no_data_error_message();
        }

        // get the data
        if (isset($_POST["username"]) && isset($_POST["mail"]) && isset($_POST["password"]))
        {
            $username_dirty = $_POST["username"];
            $mail_dirty = $_POST["mail"];
            $password_dirty_raw = $_POST["password"];
        }
        else
        {
            return invalid_format_data_error_message();
        }

        // sanitize the data
        $username = filter_var($username_dirty);
        $mail = filter_var($mail_dirty, FILTER_SANITIZE_EMAIL);
        $password_raw = filter_var($password_dirty_raw);
        
        if (!$username || !$mail || !$password_raw)
        {
            return unsafe_data_error_message();
        }

        // validate the data format
        $password_regex  = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        $username_regex  = '/^[a-zA-Z0-9_-]{3,16}$/';
        
        if (!filter_var($username, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $username_regex]]) ||
        !filter_var($password_raw, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $password_regex]]) || 
            !filter_var($mail, FILTER_VALIDATE_EMAIL))
        {
            return enforce_data_policy_error_message();
            
        }
        
        $conn = db_connect();
        // check if the user name is available
        if($username != $_SESSION["username"] && count(select_all_user_with_parameter($conn, "username", $username)) != 0)
        {
            return cant_be_used_data_error_message();
        }

        // check if the mail is available
        if($mail != $_SESSION["mail"] && count(select_all_user_with_parameter($conn, "mail", $mail)) != 0)
        {
            return cant_be_used_data_error_message();
        }

    
        $user = select_user($conn, $_SESSION["id_user"]);
        if (!password_verify($password_raw, select_user($conn, $_SESSION["id_user"])["password"]))
        {
            // Hash the new password
            $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);
        }
        else
        {
            $password_hashed = $user["password"];
        }

        $id = $_SESSION["id_user"];
        $permission = $_SESSION["permission"];
        $restricted = $_SESSION["restricted"];
        $first_connexion = $_SESSION["first_connexion"];
        $data_size = $_SESSION["data_size"];

        $conn = db_connect();
        // CRUD function
        $res = update_user($conn, $mail, $username, $password_hashed, $permission, $restricted, $first_connexion, $data_size, $id);

        if ($res)
        {
            // set the session 

            $_SESSION["mail"] = $mail;
            $_SESSION["username"] = $username;

            // 204 is shorter but 200 allows us to write a message.
            $res = success_message_json(200, "200 OK: Updated user's information successfully.") ;
        }
        else
        {
            $res = error_message_json(500, "500 Internal Server Error: Could not update user's information.");
        }

        return $res;

    }
    else
    {
        return authentification_required_error_message();
    }
}
// Public Protected by authentification
function delete_my_account($params){
    if (is_logged_in())
    {
        $conn = db_connect();
        $id = $_SESSION["id_user"];
        // CRUD function
        $res = delete_user($conn, $id);
        if ($res)
        {
            // we deleted our account so we "logout"
            // not calling logout because we don't want to change the http_response_code
            session_unset();

            // we have a message
            $res = success_message_json(200, "200 OK: Deleted user successfully");
            // this is the lightest but no message :
            // http_response_code(204);
            // return;
        }
        else
        {
            $res = error_message_json(500, "500 Internal Server Error: Could not delet user.");
        }
        return $res;
    }
    else
    {
        return authentification_required_error_message();
    }
}
// Private
function make_data_of_user($tab){
    $data = [
        "id_user" => $tab["id_user"],
        "mail" => $tab["mail"], 
        "username" => $tab["username"],
        "permission" => $tab["permission"],
        "restricted" => $tab["restricted"],
        "first_connexion" => $tab["first_connexion"],
        "data_size" => $tab["data_size"]
    ];
    return $data;
}