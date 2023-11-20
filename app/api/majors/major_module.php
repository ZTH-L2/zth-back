<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'get_major'
    ],
    "POST" => [
        "params" => [],
        "function" => 'post_major'
    ],
    "PUT" => [
        "params" => [],
        "function" => 'put_major'
    ],
    "DELETE" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'del_major'
    ]
];

$major_module = new Module($dict);