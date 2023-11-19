<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'get_author'
    ],
    "POST" => [
        "function" => 'post_author'
    ],
    "PUT" => [
        "function" => 'put_author'
    ],
    "DELETE" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'del_author'
    ]
];

$author_module = new Module($dict);