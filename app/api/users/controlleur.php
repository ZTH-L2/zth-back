<?php
session_start();
header('Access-Control-Allow-Origin: *');
require_once "api/utils/utils.php";
require_once "api/users/crud_users.php";
require_once "api/db_connect.php";


function option_user($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: OPTION, GET, POST, PUT, DELETE');
}

// Protected by admin
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
// Protected by admin
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
            return invalid_format_data_error_message();
        }

        // sanitize the data
        $username = filter_var($username_dirty);
        $password_raw = filter_var($password_dirty_raw);

        if (!$username || !$password_raw)
        {
            return unsafe_data_error_message();
        }

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

function logout($params){
    session_unset();
    return success_message_json(204, "204 No Content: Logged out successfully.");
}

function register($params){
    if (update_post_var())
    {
        
        $data = handle_username_mail_password();
        // checkout the function to see what could have caused error
        if (array_key_exists("error", $data))
        {
            return $data["error"];
        }
        
        $id = $_SESSION["id_user"];
        $username = $data["username"];
        $mail = $data["mail"];
        $password_hashed = $data["password_hashed"];
        // Set the final variables
        $permission = 0;
        $restricted = 0;
        $first_connexion = date("Y-m-d");
        
        $conn = db_connect();
        // register the user in the db
        $res = create_user($conn, $mail, $username, $password_hashed, $permission, $restricted, $first_connexion);
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

        $data = handle_username_mail_password();
        // checkout the function to see what could have caused error
        if (array_key_exists("error", $data))
        {
            return $data["error"];
        }

        $id = $_SESSION["id_user"];
        $username = $data["username"];
        $mail = $data["mail"];
        $password_hashed = $data["password_hashed"];
        $permission = $_SESSION["permission"];
        $restricted = $_SESSION["restricted"];
        $first_connexion = $_SESSION["first_connexion"];

        $conn = db_connect();
        // CRUD function
        $res = update_user($conn, $mail, $username, $password_hashed, $permission, $restricted, $first_connexion, $id);

        if ($res)
        {
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
    return;
}


function is_logged_in(){
    return  isset($_SESSION["id_user"]);
}

function is_admin(){
    // should be called only if is_logged_in has returned true
    // but can handle the case where is_logged_in has returned false
    return isset($_SESSION["permission"]) && $_SESSION["permission"] == 1;
}

function handle_username_mail_password()
{
    // get the data
    if (isset($_POST["username"]) && isset($_POST["mail"]) && isset($_POST["password"]))
    {
        $username_dirty = $_POST["username"];
        $mail_dirty = $_POST["mail"];
        $password_dirty_raw = $_POST["password"];
    }
    else
    {
        return ["error" => invalid_format_data_error_message()];
    }

    // sanitize the data
    $username = filter_var($username_dirty);
    $mail = filter_var($mail_dirty, FILTER_SANITIZE_EMAIL);
    $password_raw = filter_var($password_dirty_raw);
    
    if (!$username || !$mail || !$password_raw)
    {
        return ["error" => unsafe_data_error_message()];
    }

    // validate the data format
    $password_regex  = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    $username_regex  = '/^[a-zA-Z0-9_-]{3,16}$/';
    
    if (!filter_var($username, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $username_regex]]) ||
    !filter_var($password_raw, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => $password_regex]]) || 
        !filter_var($mail, FILTER_VALIDATE_EMAIL))
    {
        return ["error" => enforce_data_policy_error_message()];
        
    }
    
    $conn = db_connect();
    // check if the user name is available
    if(count(select_all_user_with_parameter($conn, "username", $username)) != 0)
    {
        return ["error" => cant_be_used_data_error_message()];
    }

    // check if the mail is available
    if(count(select_all_user_with_parameter($conn, "mail", $mail)) != 0)
    {
        return ["error" => cant_be_used_data_error_message()];
    }

    // Hash the password
    $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

    $data = [
        "username" => $username,
        "mail" => $mail,
        "password_hashed" => $password_hashed
    ];

    return $data;
}

function make_data_of_user($tab){
    $data = [
        "id_user" => $tab["id_user"],
        "mail" => $tab["mail"], 
        "username" => $tab["username"],
        "permission" => $tab["permission"],
        "restricted" => $tab["restricted"],
        "first_connexion" => $tab["first_connexion"]
    ];
    return $data;
}