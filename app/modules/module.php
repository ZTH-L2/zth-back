<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Origin: https://zth-l2.netlify.app');
header('Access-Control-Allow-Origin: https://notesync.aekhy.codes/connexion');

//header('Access-Control-Allow-Credentials: true');
// session_set_cookie_params(['SameSite' => 'None', 'Secure' => true]);
session_start();
class Module
{
    private $api_function_dict;
    
    public function __construct($dict){
        $this->api_function_dict = $dict;
    }

    public function api($method, $params){
        header('Content-Type: application/json');
        // $method should be one of OPTION, GET, POST, PUT, DELETE
        if (array_key_exists($method, $this->api_function_dict))
        {
            if (array_key_exists("routes", $this->api_function_dict[$method]))
            {
                $param_len = count($params);
                foreach ($this->api_function_dict[$method]["routes"] as $route)
                {
                    if ($param_len == count($route["params"]))
                    {
                        $wrong_match = false;
                        for ($i = 0; $i < $param_len; $i++) {
                            // if one parameter does not match one regex 
                            // of needed params it fails
                            $regex = $route["params"][$i];
                            if (!preg_match($regex, $params[$i])){
                                $wrong_match = true;
                                break;
                            }
                        }
                        if (!$wrong_match){
                            echo $route["function"]($params);
                            return;
                        }
                    }
                };
                // If we get here it means that we have not found a route matching the params
                http_response_code(404);
                echo json_encode(['error' => 'Resource not found | remove me : params does\'t match any route']);
                
            }
            else if(array_key_exists("params", $this->api_function_dict[$method]))
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
                    echo $this->api_function_dict[$method]["function"]($params);
                }
                else
                {
                    http_response_code(404);
                    echo json_encode(['error' => 'Resource not found | remove me : wrong len of params']);
                }
            }
            else
            {
                echo $this->api_function_dict[$method]["function"]($params);
            }
        }
        else
        {
            http_response_code(405);
            echo json_encode(['error' => "Method Not Allowed"]);
        }
    }
}