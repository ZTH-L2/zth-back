<?php
header('Access-Control-Allow-Origin: *');
require_once "api/utils/utils.php";
require_once "cruds/crud_years.php";
require_once "api/db_connect.php";

function option_year($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
}

function get_year($params){
   
    return json_encode(["succes"=>true,"message"=>select_year(db_connect(), $params[0])]);

}

function post_year($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
            if (update_post_var())
            {
                $conn = db_connect();

                // get the data
                if (isset($_POST["name"]))
                {
                    $name_dirty = $_POST["name"];
                }
                else
                {
                    invalid_format_data_error_message();
                    return;
                }

                // sanitize the data
                $name = filter_var($name_dirty);
                if (!$name)
                {
                    unsafe_data_error_message();
                    return;
                }

                return json_encode(["succes" => true, "message" => create_year($conn, $name)]);
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


function del_year($params){
    if (is_logged_in())
    {
        if (is_admin())
        {
    return json_encode(["succes"=>true,"message"=>delete_year(db_connect(), $params[0])]);
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

function put_year($params){
     if (is_logged_in())
    {
        if (is_admin())
        {
    if (update_post_var())
    {
    $conn = db_connect();

    // get the data
    if (isset($_POST["name"]) && (isset($_POST["id_year"])))
    {
        $name_dirty = $_POST["name"];
        $id_dirty = $_POST["id_year"];
    }
    else
    {
        invalid_format_data_error_message();
        return;
    }

    // sanitize the data
    $name = filter_var($name_dirty);
    $id = filter_var($id_dirty);


    if (!$name)
    {
        unsafe_data_error_message();
        return;
    }

    return json_encode(["succes" => true, "message" => update_year(db_connect(), $name, $id)]);
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
