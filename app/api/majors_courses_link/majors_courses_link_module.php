<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'get_majors_courses_link'
    ],
    "POST" => [
        "params" => [],
        "function" => 'post_majors_courses_link'
    ],
    "PUT" => [
        "params" => [],
        "function" => 'put_majors_courses_link'
    ],
    "DELETE" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'del_majors_courses_link'
    ]
];

$majors_courses_link_module = new Module($dict);