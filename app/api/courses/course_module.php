<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'get_course'
    ],
    "POST" => [
        "params" => [],
        "function" => 'post_course'
    ],
    "PUT" => [
        "params" => [],
        "function" => 'put_course'
    ],
    "DELETE" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'del_course'
    ]
];

$course_module = new Module($dict);