<?php
header('Access-Control-Allow-Origin: *');

require_once "api/utils/utils.php";
require_once "cruds/crud_majors_courses_link.php";
require_once "api/db_connect.php";
function option_majors_courses_link($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
}

//public
function get_majors_courses_link($params){
    $conn = db_connect();
    $id = $params[0];
    $res = select_major_course_link($conn, $id);
    if (is_null($res))
    {
        return json_encode([]);
    }
    else
    {
        return json_encode($res);
    }
}

// public protected
function post_majors_courses_link($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                if ((isset($_POST["id_major"])) && (isset($_POST["id_course"])) && (isset($_POST["id_year"])))
                {
                    $id_major_dirty = $_POST["id_major"];
                    $id_course_dirty = $_POST["id_course"];
                    $id_year_dirty = $_POST["id_year"];
                    $conn = db_connect();
                }
                    else
                    {
                        invalid_format_data_error_message();
                        return;
                    }

                    // sanitize the data
                    $id_major = filter_var($id_major_dirty, FILTER_VALIDATE_INT);
                    $id_course = filter_var($id_course_dirty, FILTER_VALIDATE_INT);
                    $id_year = filter_var($id_year_dirty, FILTER_VALIDATE_INT);

                    if (!$id_major || !$id_course || !$id_year)
                    {
                        unsafe_data_error_message();
                        return;
                    }
                    $res = create_major_course_link($conn, $id_major, $id_course, $id_year);
                    if ($res)
                    {
                        return success_message_json(201, "201 Created: New majors_courses_link successfully created");
                    }
                    else
                    {
                        return error_message_json(500, "500 Internal Server Error: Could not create the majors_courses_link");
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

// public protected

function del_majors_courses_link($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            $conn = db_connect();
            delete_major_course_link($conn, $params[0]);
            if (mysqli_affected_rows($conn) > 0)
            {
                return success_message_json(200, "200 OK: Deleted majors_courses_link successfully");
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

// public protected

function put_majors_courses_link($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                $conn = db_connect();
                
                // get the data
                if ((isset($_POST["id_majors_courses_link"])) && (isset($_POST["id_major"])) && (isset($_POST["id_course"])) && (isset($_POST["id_year"])))
                {
                    $id_dirty = $_POST["id_majors_courses_link"];
                    $id_major_dirty = $_POST["id_major"];
                    $id_course_dirty = $_POST["id_course"];
                    $id_year_dirty = $_POST["id_year"];
                }
                else
                {
                    invalid_format_data_error_message();
                    return;
                }
            
                // sanitize the data
                $id = filter_var($id_dirty, FILTER_VALIDATE_INT);
                $id_major = filter_var($id_major_dirty, FILTER_VALIDATE_INT);
                $id_course = filter_var($id_course_dirty, FILTER_VALIDATE_INT);
                $id_year = filter_var($id_year_dirty, FILTER_VALIDATE_INT);
            
                if (!$id || !$id_major || !$id_course || !$id_year)
                {
                    unsafe_data_error_message();
                    return;
                }
                $res = update_major_course_link($conn, $id_major, $id_course, $id_year, $id);
                if ($res)
                {
                    return success_message_json(200, "200 OK: Updated majors_courses_link's information successfully.") ;
                }
                else
                {
                    return error_message_json(500, "500 Internal Server Error: Could not update majors_courses_link's information.");
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

// private
function private_post_majors_courses_link($id_course, $id_major, $id_year){
    $conn = db_connect();
    create_major_course_link($conn, $id_major, $id_course, $id_year);

}