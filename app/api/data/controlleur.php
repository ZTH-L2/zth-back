<?php

require_once "api/utils/utils.php";

function option_data($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET');
}

function get_data($params){
    $id_post = $params[0];
    $name = urldecode($params[1]);
    $fullPath = "./POSTS_DATA/". $id_post . "/". $name;
    if (file_exists($fullPath)) {
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                header('Content-Type: image/jpeg');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
            case 'gif':
                header('Content-Type: image/gif');
                break;
            case 'pdf':
                header('Content-Type: application/pdf');
                break;
            case 'txt':
                header('Content-Type: text/plain');
                break;
            case 'json':
                header('Content-Type: application/json');
                break;
            
            default:
                header('Content-Type: application/octet-stream');
        }
        readfile($fullPath);
    } else {
        http_response_code(404);
    }
}