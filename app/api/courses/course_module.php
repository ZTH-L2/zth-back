<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'get_course'
    ],
    "POST" => [
        "function" => 'post_course'
    ],
    "PUT" => [
        "function" => 'put_course'
    ],
    "DELETE" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'del_course'
    ]
];

$course_module = new Module($dict);