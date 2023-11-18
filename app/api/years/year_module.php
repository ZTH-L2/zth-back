<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "params" => ["/[0-9]{1,}/"],
        "function" => 'get_year'
    ],
    "POST" => [
        "function" => 'post_year'
    ],
    "PUT" => [
        "function" => 'put_year'
    ],
    "DELETE" => [
        "params" => ["/[0-9]{1,}/"],
        "function" => 'del_year'
    ]
];

$year_module = new Module($dict);