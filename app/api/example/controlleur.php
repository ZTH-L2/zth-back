<?php

function option_example($params){
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET');
}
/*
This fill is purely for example
We should make all the checks here 
*/

// this is example to prove that it works : 
// it's simple and doesn't make any verification

//----- this part should be in the crud ----
function get_from_crud($params){
    $data = array(
        'example' => "easy",
        'working' => true,
        'number' => intval($params[1])
    );

    $jsonData = json_encode($data);
    return $jsonData;
}
//-----  ----

function get_example($params){
    echo get_from_crud($params);
};


