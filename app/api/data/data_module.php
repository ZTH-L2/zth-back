<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "params" => ["/[0-9]{1,}/", "/.*/"],
        "function" => 'get_data'    
    ],
];

$data_module = new Module($dict);