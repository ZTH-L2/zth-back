<?php

/*
This fill is purely for example
We should make all the checks here 
*/

// this is example to prove that it works : 
// it's simple and doesn't make any verification

//----- this part should be in the crud ----
function get_from_crud(){
    $data = array(
        'example' => "easy",
        'working' => true,
        'number' => 1
    );

    $jsonData = json_encode($data);
    return $jsonData;
}
//-----  ----

function get($params){
    
    header('Content-Type: application/json');
    if (count($params) == 0)
    {
        echo get_from_crud();
    }

    else
    {
        http_response_code(404);
        echo json_encode(['error' => 'Resource not found']);
    }
    
};