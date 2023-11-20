<?php
header('Access-Control-Allow-Origin: *');
require_once "api/utils/utils.php";
require_once "cruds/crud_reports_comments.php";
require_once "api/db_connect.php";

function option_report_comment($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET');
}

function get_by_id_comment_page_amount($params){
    if (!is_logged_in())
    {
        return authentification_required_error_message();
    }
    if (!is_admin()){
        return permission_denied_error_message();
    }
    // "/bycomment/", "/^[0-9]{1,}$/", "/^[0-9]{1,}$/", "/^[0-9]{1,}$/"
    $id_comment = $params[1];
    $page = $params[2];
    $amount_per_page = $params[3];
    $offset = ($page - 1) * $amount_per_page;

    $conn = db_connect();
    $stmt = $conn->prepare("SELECT * FROM report_comments WHERE id_comment = ? DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("iii", $id_comment, $amount_per_page, $offset); // "i" indicates integer type
    
    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $reports = $result->fetch_all(MYSQLI_ASSOC);;
        $stmt->close();
        return json_encode($reports);
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not get your comments at this page with this amount per page");
    }
}

function get_by_id_user_page_amount($params){
    if (!is_logged_in())
    {
        return authentification_required_error_message();
    }
    if (!is_admin()){
        return permission_denied_error_message();
    }
    $id_user = $params[1];
    $page = $params[2];
    $amount_per_page = $params[3];
    $offset = ($page - 1) * $amount_per_page;

    $conn = db_connect();
    $stmt = $conn->prepare("SELECT * FROM report_comments WHERE id_user = ? DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("iii", $id_user, $amount_per_page, $offset); // "i" indicates integer type
    
    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $reports = $result->fetch_all(MYSQLI_ASSOC);;
        $stmt->close();
        return json_encode($reports);
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not get your comments at this page with this amount per page");
    }
}


function report($params){
    if (!is_logged_in())
    {
        return authentification_required_error_message();
    }
    if (!update_post_var())
    {
        return no_data_error_message();
    }
    if(!isset($_POST["id_comment"]) || !isset($_POST["report"]))
    {
        return invalid_format_data_error_message();
    }

    $id_comment = filter_var($_POST["id_comment"], FILTER_VALIDATE_INT);
    if (!$id_comment)
    {
        return unsafe_data_error_message();
    }

    $conn = db_connect();
    $comment = select_comment($conn, $id_comment);
    if (count(($comment)) == 0)
    {
        return invalid_data_error_message();
    }
    
    $id_user = $_SESSION["id_user"];
    $report_dirty = $_POST["report"];
    $conn = db_connect();
    $stmt = $conn->prepare("INSERT INTO `reports_comments`(`id_user`, `id_comment`, `report`) VALUES(?, ?, ?)");
    $stmt->bind_param("iii", $id_user, $id_comment, $report_dirty); // "i" indicates integer type
    
    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        $reports = $result->fetch_all(MYSQLI_ASSOC);;
        $stmt->close();
        return json_encode($reports);
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not get your comments at this page with this amount per page");
    }
}

function delete_report_by_id($params){
    if (!is_logged_in())
    {
        return authentification_required_error_message();
    }
    if (!is_admin()){
        return permission_denied_error_message();
    }

    $id_report_comment = $params[0];
    $conn = db_connect();
    if (delete_report_comment($conn, $id_report_comment))
    {
        http_response_code(204);
        return;
    }
    else
    {
        return error_message_json(500, "500 Internal Server Error: Could not delete this report.");
    }

}