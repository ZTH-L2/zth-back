<?php
header('Access-Control-Allow-Origin: *');

require_once "api/utils/utils.php";
require_once "cruds/crud_posts.php";
require_once "api/db_connect.php";
function option_post($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
}

function get_post($params){
    $conn = db_connect();
    $id = $params[0];
    $res = select_post($conn, $id);
    if (is_null($res))
    {
        return json_encode([]);
    }
    else
    {
        return json_encode($res);
    }
}

function post_post($params){
    if (is_logged_in())
    {
        if (update_post_var())
        {
            $conn = db_connect();
            // get the data
            if (isset($_POST["id_creator"]) && isset($_POST["id_course"]) && isset($_POST["title"]) && isset($_POST["category"]) && isset($_POST["privacy"]))
            {
                $id_creator_dirty = $_POST["id_creator"];
                $id_course_dirty = $_POST["id_course"];
                $title_dirty = $_POST["title"];
                $category_dirty = $_POST["category"];
                $privacy_dirty = $_POST["privacy"];
            }
            else
            {
                return invalid_format_data_error_message();
            }
            // sanitize the data
            $id_creator = filter_var($id_creator_dirty, FILTER_VALIDATE_INT);
            $id_course = filter_var($id_course_dirty, FILTER_VALIDATE_INT);
            $title = filter_var($title_dirty);
            $category = filter_var($category_dirty);
            $privacy = filter_var($privacy_dirty, FILTER_VALIDATE_INT);


            if (!$id_creator || !$id_course || !$title || !$category || !$privacy)
            {
                return unsafe_data_error_message();
            }

            $date = getdate();
            $date = $date["year"] + "-" + $date["mon"] +  "-" + $date["mday"];
            if ($id_creator == $_SESSION["id_user"])
            {
                $res = create_post($conn, $id_creator, $id_course, $title, $category, $date, $privacy,1, 0, 0, 0);
                if ($res)
                {
                    return success_message_json(201, "201 Created: New post successfully created");
                }
                else
                {
                    return error_message_json(500, "500 Internal Server Error: Could not create the post");
                }
            }
            else
            {
                return permission_denied_error_message();
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

function del_post_admin($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            $conn = db_connect();
            delete_post($conn, $params[0]);
            if (mysqli_affected_rows($conn) > 0)
            {
                return success_message_json(200, "200 OK: Deleted post successfully");
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


function del_post($params){
    if (is_logged_in())
    {
        $conn = db_connect();
        $post = select_post($conn, $params[0]);
        if ($post["id_creator"] == $_SESSION["id_user"])
        {
            delete_post($conn, $params[0]);
            if (mysqli_affected_rows($conn) > 0)
            {
                return success_message_json(200, "200 OK: Deleted post successfully");
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

function put_post_admin($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                $conn = db_connect();
            
                // get the data
                if (isset($_POST["id_post"]) && isset($_POST["id_creator"]) && isset($_POST["id_course"]) && isset($_POST["title"])&& isset($_POST["category"])  && isset($_POST["privacy"]) && isset($_POST["published"]) && isset($_POST["date"]) && isset($_POST["grade"]) && isset($_POST["nb_note"]) && isset($_POST["nb_report"]))
                {
                    $id_dirty = $_POST["id_post"];
                    $id_creator_dirty = $_POST["id_creator"];
                    $id_course_dirty = $_POST["id_course"];
                    $title_dirty = $_POST["title"];
                    $category_dirty = $_POST["category"];
                    $privacy_dirty = $_POST["privacy"];
                    $date = $_POST["date"];
                    $grade_dirty = $_POST["grade"];
                    $nb_note_dirty = $_POST["nb_note"];
                    $nb_report_dirty = $_POST["nb_report"];
                    $published_dirty = $_POST["published"];

                }
                else
                {
                    return invalid_format_data_error_message();
                }
                // sanitize the data
                $id = filter_var($id_dirty, FILTER_VALIDATE_INT);
                $id_creator = filter_var($id_creator_dirty, FILTER_VALIDATE_INT);
                $id_course = filter_var($id_course_dirty, FILTER_VALIDATE_INT);
                $title = filter_var($title_dirty);
                $category = filter_var($category_dirty);
                $nb_note = filter_var($nb_note_dirty, FILTER_VALIDATE_INT);
                $nb_report = filter_var($nb_report_dirty, FILTER_VALIDATE_INT);
                $grade = filter_var($grade_dirty, FILTER_VALIDATE_FLOAT);
                $privacy = filter_var($privacy_dirty, FILTER_VALIDATE_INT);
                $published = filter_var($published_dirty, FILTER_VALIDATE_INT);

                if (!$id || !$id_creator || !$id_course || !$title || !$category || !$published || !$nb_note || !$nb_report || !$grade || !$privacy)
                {
                    return unsafe_data_error_message();
                    
                }
                
                $res = update_post($conn, $id_creator, $id_course, $title, $category, $date, $privacy, $published, $grade, $nb_note, $nb_report, $id);
                if ($res)
                {
                    return success_message_json(200, "200 OK: Updated post's information successfully.") ;
                }
                else
                {
                    return error_message_json(500, "500 Internal Server Error: Could not update post's information.");
                }
            }
            else
            {
                return no_data_error_message();   
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


function put_post($params){
    if (is_logged_in())
    {
        if (update_post_var())
        {
            $conn = db_connect();
            
            // get the data
            if (isset($_POST["id_post"]) && isset($_POST["privacy"]) && isset($_POST["title"]) && isset($_POST["published"]))
            {
                $id_dirty = $_POST["id_post"];
                $title_dirty = $_POST["title"];
                $privacy_dirty = $_POST["privacy"];
                $published_dirty = $_POST["published"];

            }
            else
            {
                return invalid_format_data_error_message();
            }
            
            // sanitize the data
            $id = filter_var($id_dirty, FILTER_VALIDATE_INT);
            $title = filter_var($title_dirty);
            $privacy = filter_var($privacy_dirty, FILTER_VALIDATE_INT);
            $published = filter_var($published_dirty, FILTER_VALIDATE_INT);


            if (!$id || !$title || !$privacy || !$published)
            {
                return unsafe_data_error_message();
            }
            $date = getdate();
            $date = $date["year"] + "-" + $date["mon"] +  "-" + $date["mday"];
            $res = update_post_user($conn, $title, $date, $privacy, $published, $id);
            if ($res)
            {
                return success_message_json(200, "200 OK: Updated post's information successfully.");
            }
            else
            {
                return error_message_json(500, "500 Internal Server Error: Could not update post's information.");
            }
        }
        else
        {
            return no_data_error_message();   
        }
    }
    else
    {
        return authentification_required_error_message();
    }
}
