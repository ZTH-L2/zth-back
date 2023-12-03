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
        // Assurez-vous que le fichier existe
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        if ($extension == "pdf"){
            header('Content-Type: application/pdf');
        }
        readfile($fullPath); // Lit et renvoie le contenu du fichier
    } else {
        http_response_code(404); // Si le fichier n'existe pas, renvoie une réponse 404
    }
}
