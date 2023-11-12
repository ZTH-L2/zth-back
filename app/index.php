<?php
session_start();
$requestUri = $_SERVER['REQUEST_URI'];

// this little code is not suppose to represent 
// how we will do it
// Check if the request is for api_dummy
if ($requestUri === "/api/dummy") {
    // Redirect to api_dummy.php
    $_SESSION["path"] = True;
    header("Location: /api/api_dummy.php");
    exit;
}

echo "Success\n";
echo "your uri : " . $requestUri;

?>
