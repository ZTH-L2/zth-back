<?php

class Module
{
    private $api_function_dict;
    
    public function __construct($dict){
        $this->api_function_dict = $dict;
    }

    public function api($method, $params){
        header('Content-Type: application/json');
        // $method should be one of OPTION, GET, POST, PUT, DELET
        if (array_key_exists($method, $this->api_function_dict))
        {
            if (array_key_exists("params", $this->api_function_dict[$method]))
            {
                $param_len = count($params);
                if ($param_len == count($this->api_function_dict[$method]["params"]))
                {
                    for ($i = 0; $i < $param_len; $i++) {
                        // if one parameter does not match one regex 
                        // of needed params it fails
                        $regex = $this->api_function_dict[$method]["params"][$i];
                        if (!preg_match($regex, $params[$i])){
                            http_response_code(404);
                            echo json_encode(['error' => 'Resource not found | remove me : wrong match for param number ' . strval($i)]);
                            return;
                        }
                    }
                }
                else
                {
                    http_response_code(404);
                    echo json_encode(['error' => 'Resource not found | remove me : wrong len of params']);
                    return;
                }
            }
            $this->api_function_dict[$method]["function"]($params);
        }
        else
        {
            http_response_code(405);
            echo json_encode(['error' => "Method Not Allowed"]);
        }
    }
}