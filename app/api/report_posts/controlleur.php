<?php


require_once "api/utils/utils.php";
require_once "api/db_connect.php";

function option_report_post($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: OPTIONS, GET, POST, DELETE');
}