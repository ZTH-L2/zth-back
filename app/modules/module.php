<?php

class Module
{
    private $api_function_dict;
    
    public function __construct($dict){
        $this->api_function_dict = $dict;
    }
    private function debug(){
        echo "debug";
    }
    public function api($method, $params){
        // $method should be one of GET, POST, PUT, DELET
        if (array_key_exists($method, $this->api_function_dict))
        {
            $this->api_function_dict[$method]($params);
        }
        else
        {
            header('Content-Type: application/json');
            http_response_code(405);
            echo json_encode(['error' => "Method Not Allowed"]);
        }
    }
}