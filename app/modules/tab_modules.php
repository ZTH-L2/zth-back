<?php 
require_once "api/example/example_module.php";
require_once "api/users/user_module.php";

$modules = [
    "example" => $example_module,
    "user" => $user_module
];