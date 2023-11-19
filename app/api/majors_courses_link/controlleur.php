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
            return json_encode(["succes"=>true,"message"=>select_major_course_link($conn, $id)]);
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
                    $id_major = filter_var($id_major_dirty);
                    $id_course = filter_var($id_course_dirty);
                    $id_year = filter_var($id_year_dirty);

                    if (!$id_major || !$id_course || !$id_year)
                    {
                        unsafe_data_error_message();
                        return;
                    }
                    return json_encode(["succes" => true, "message" => create_major_course_link($conn, $id_major, $id_course, $id_year)]);
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
    return json_encode(["succes"=>true,"message"=>delete_major_course_link(db_connect(), $params[0])]);
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
    $id = filter_var($id_dirty);
    $id_major = filter_var($id_major_dirty);
    $id_course = filter_var($id_course_dirty);
    $id_year = filter_var($id_year_dirty);

    if (!$id || !$id_major || !$id_course || !$id_year)
    {
        unsafe_data_error_message();
        return;
    }

    return json_encode(["succes" => true, "message" => update_major_course_link($conn, $id_major, $id_course, $id_year, $id)]);
}

else{
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