<?php
header('Access-Control-Allow-Credentials: true');


require_once "api/utils/utils.php";
require_once "cruds/crud_grades.php";
require_once "api/db_connect.php";
function option_grade($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
}

function get_grade($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            $conn = db_connect();
            $id = $params[0];
            $res = select_grade($conn, $id);
            if (is_null($res))
            {
                return json_encode([]);
            }
            else
            {
                return json_encode($res);
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

function get_grade_post($params){
    if (is_logged_in())
    {
        $conn = db_connect();
        $id = $params[1];
        $res = select_grade_post($conn, $id);
        if (is_null($res))
        {
            return json_encode([]);
        }
        else
        {
            return json_encode($res);
        }
    }
    else
    {
        return authentification_required_error_message();
    }
}

function post_grade($params){
    if (is_logged_in())
    {
        if (update_post_var())
        {
            $conn = db_connect();

            // get the data
            if (isset($_POST["id_user"]) && isset($_POST["id_post"]) && isset($_POST["grade"]))
            {
                $id_user_dirty = $_POST["id_user"];
                $id_post_dirty = $_POST["id_post"];
                $grade_dirty = $_POST["grade"];
            }
            else
            {
                return invalid_format_data_error_message();
            }
            // sanitize the data
            $id_user = filter_var($id_user_dirty, FILTER_VALIDATE_INT);
            $id_post = filter_var($id_post_dirty, FILTER_VALIDATE_INT);
            $grade = filter_var($grade_dirty, FILTER_VALIDATE_FLOAT);


            if ($id_user == "" || $id_post == "" || $grade == "")
            {
                return unsafe_data_error_message();
            }
            if ($id_user != $_SESSION["id_user"])
            {
                return permission_denied_error_message();
            }
            $test = select_grade_user_post($conn, $id_user, $id_post);
            if (is_null($test))
            {
                $res = create_grade($conn, $id_user, $id_post, $grade);
                if ($res)
                {
                    return success_message_json(201, "201 Created: New grade successfully created");
                }
                else
                {
                    return error_message_json(500, "500 Internal Server Error: Could not create the grade");
                }
            }
            else
            {
                return error_message_json(422, "422 Unprocessable Entity: The grade already exist");
            }
        }
        else
        {
            no_data_error_message();   
        }
    }
    else
    {
        return authentification_required_error_message();
    }
}

function post_grade_admin($params){

    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                $conn = db_connect();

                // get the data
                if (isset($_POST["id_user"]) && isset($_POST["id_post"]) && isset($_POST["grade"]))
                {
                    $id_user_dirty = $_POST["id_user"];
                    $id_post_dirty = $_POST["id_post"];
                    $grade_dirty = $_POST["grade"];
                }
                else
                {
                    return invalid_format_data_error_message();
                }

                // sanitize the data
                $id_user = filter_var($id_user_dirty, FILTER_VALIDATE_INT);
                $id_post = filter_var($id_post_dirty, FILTER_VALIDATE_INT);
                $grade = filter_var($grade_dirty, FILTER_VALIDATE_FLOAT);


                if ($id_user == "" || $id_post == "" || $grade == "")
                {
                    return unsafe_data_error_message();
                }

                $test = select_grade_user_post($conn, $id_user, $id_post);
                if (is_null($test))
                {
                    $res = create_grade($conn, $id_user, $id_post, $grade);
                    if ($res)
                    {
                        return success_message_json(201, "201 Created: New grade successfully created");
                    }
                    else
                    {
                        return error_message_json(500, "500 Internal Server Error: Could not create the grade");
                    }
                }
                else
                {
                    return error_message_json(422, "422 Unprocessable Entity: The grade already exist");
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

function del_grade($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            $conn = db_connect();
            delete_grade($conn, $params[0]);
            if (mysqli_affected_rows($conn) > 0)
            {
                return success_message_json(200, "200 OK: Deleted grade successfully");
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

function put_grade($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                $conn = db_connect();
            
                // get the data
                if ((isset($_POST["id_grade"])) && isset($_POST["id_user"]) && isset($_POST["id_post"]) && isset($_POST["grade"]))
                {
                    $id_dirty = $_POST["id_grade"];
                    $id_user_dirty = $_POST["id_user"];
                    $id_post_dirty = $_POST["id_post"];
                    $grade_dirty = $_POST["grade"];
                }
                else
                {
                    return invalid_format_data_error_message();
                }
            
                // sanitize the data
                $id = filter_var($id_dirty, FILTER_VALIDATE_INT);
                $id_user = filter_var($id_user_dirty, FILTER_VALIDATE_INT);
                $id_post = filter_var($id_post_dirty, FILTER_VALIDATE_INT);
                $grade = filter_var($grade_dirty, FILTER_VALIDATE_FLOAT);

                if ($id == "" || $id_user == "" || $id_post == "" || $grade == "")
                {
                    return unsafe_data_error_message();
                }
            
                $res = update_grade($conn, $id_user, $id_post, $grade, $id);
                if ($res)
                {
                    return success_message_json(200, "200 OK: Updated grade's information successfully.") ;
                }
                else
                {
                    return error_message_json(500, "500 Internal Server Error: Could not update grade's information.");
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
    {
    return authentification_required_error_message();
    }
}

function put_grade_user($params){
    if (is_logged_in())
    {
        if (update_post_var())
        {
            $conn = db_connect();
        
            // get the data
            if (isset($_POST["id_user"]) && isset($_POST["id_post"]) && isset($_POST["grade"]))
            {
                $id_user_dirty = $_POST["id_user"];
                $id_post_dirty = $_POST["id_post"];
                $grade_dirty = $_POST["grade"];
            }
            else
            {
                return invalid_format_data_error_message();
            }
        
            // sanitize the data
            $id_user = filter_var($id_user_dirty, FILTER_VALIDATE_INT);
            $id_post = filter_var($id_post_dirty, FILTER_VALIDATE_INT);
            $grade = filter_var($grade_dirty, FILTER_VALIDATE_FLOAT);

            if ($id_user == "" || $id_post == "" || $grade == "")
            {
                return unsafe_data_error_message();
            }
            if ($grade > 5 || $grade < 0){
                return invalid_data_error_message();
            }
            if ($id_user != $_SESSION["id_user"])
            {
                return permission_denied_error_message();
            }
            $res = modify_grade($conn, $id_user, $id_post, $grade);
            if ($res)
            {
                return success_message_json(200, "200 OK: Updated grade's information successfully.") ;
            }
            else
            {
                return error_message_json(500, "500 Internal Server Error: Could not update grade's information.");
            }
        }
    }
    else
    {
        return permission_denied_error_message();
    }
}
