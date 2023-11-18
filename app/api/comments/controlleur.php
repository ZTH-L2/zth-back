<?php
session_start();
header('Access-Control-Allow-Origin: *');
require_once "api/utils/utils.php";
require_once "cruds/crud_users.php";
require_once "api/db_connect.php";

// Public
function option_user($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: OPTION, GET, POST, PUT, DELETE');
}


