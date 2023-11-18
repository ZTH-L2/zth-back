<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "function" => 'get_year'
    ],
    "POST" => [
        "function" => 'post_year'
    ],
    "PUT" => [
        "function" => 'put_year'
    ],
    "DELETE" => [
        "function" => 'del_year'
    ]
];

$year_module = new Module($dict);