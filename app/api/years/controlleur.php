<?php
header('Access-Control-Allow-Origin: *');

require_once "api/utils/utils.php";
require_once "api/years/crud_years.php";
require_once "api/db_connect.php";
function option_year($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
}

function get_year($params){
    echo json_encode(["succes"=>true,"message"=>select_year(db_connect(), $params[0])]);
}

function post_year($params){
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
        error_json_custom("The data in not formated correctly (invalid keys)");
        return;
    }

    // sanitize the data
    $name = filter_var($name_dirty);

    if (!$name)
    {
        error_json_custom("The data is not safe");
        return;
    }

    echo json_encode(["succes" => true, "message" => create_year(db_connect(), $name)]);
}

else{
    no_data_error();   
}
}

function del_year($params){
    echo json_encode(["succes"=>true,"message"=>delete_year(db_connect(), $params[0])]);
}

function put_year($params){
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
        error_json_custom("The data in not formated correctly (invalid keys)");
        return;
    }

    // sanitize the data
    $name = filter_var($name_dirty);
    $id = filter_var($id_dirty);


    if (!$name)
    {
        error_json_custom("The data is not safe");
        return;
    }

    echo json_encode(["succes" => true, "message" => update_year(db_connect(), $name, $id)]);
}

else{
    no_data_error();   
}
}
