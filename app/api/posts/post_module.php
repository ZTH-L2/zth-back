<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'get_post'
    ],
    "POST" => [
        "params" => [],
        "function" => 'post_post'
    ],
    "PUT" => [
        "params" => [],
        "function" => 'put_post'
    ],
    "DELETE" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'del_post'
    ]
];

$post_module = new Module($dict);