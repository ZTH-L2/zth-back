<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'get_year'
    ],
    "POST" => [
        "params" => [],
        "function" => 'post_year'
    ],
    "PUT" => [
        "params" => [],
        "function" => 'put_year'
    ],
    "DELETE" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'del_year'
    ]
];

$year_module = new Module($dict);