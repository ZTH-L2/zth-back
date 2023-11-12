<?php
session_start();
if (!isset($_SESSION["path"]) || !$_SESSION["path"] )
{
    http_response_code(403);
}
elseif (isset($_SESSION["path"]) && $_SESSION["path"])
{
    $_SESSION["path"] = False;
    # access allowed

    # the api code
    header('Content-Type: application/json; charset=utf-8');
    $data = ["custom_key"=>"custom_value"];
    echo json_encode($data);
}