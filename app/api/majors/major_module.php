<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "function" => 'get_major'
    ],
    "POST" => [
        "function" => 'post_major'
    ],
    "PUT" => [
        "function" => 'put_major'
    ],
    "DELETE" => [
        "function" => 'del_major'
    ]
];

$major_module = new Module($dict);