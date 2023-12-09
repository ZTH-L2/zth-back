<?php
include "./modules/tab_modules.php";
// Get the uri of the url
// Example url : localhost:8080/example/1
//         uri : /example/1
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri !== "/")
{
    // This pattern matches with /moduleexample and /moduleexample/param1/param2/...
    $pattern = "/^\/[a-z]{1,}(\/[0-9a-z]{1,})?/";

    // if the uri matches with the pattern
    if (preg_match($pattern, $requestUri))
    {

        $params = explode("/", $requestUri);
        // uri is : $params[0](="")/$params[1](="moduleexample)/$params[2](=param1)/...
        $module = $params[1];
        if (array_key_exists($module,$modules))
        {
            $method = $_SERVER['REQUEST_METHOD'];
            $params = array_slice($params, 2);
            $modules[$module]->api($method, $params);
        }
        else
        {
            // Module not used in our api so
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(['error' => 'Resource not found']);
        }

    }
    else
    {
        // Module not used in our api so
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode(['error' => 'Resource not found']);
    }
}
else
{
    echo "Welcome to our api, we currently have the /example/exparam/1 route available.<br>";
    echo "If you type an uri unavailable, you will face a not found error.";
}
?>
