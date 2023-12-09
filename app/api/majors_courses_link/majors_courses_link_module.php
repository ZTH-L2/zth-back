<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "OPTIONS" => [
        "function" => 'option_majors_courses_link'
    ],
    "GET" => [
        "routes" => [
            [
                "params" => ["/^[0-9]{1,}$/", "/^[0-9]{1,}$/"],
                "function" => 'get_all_majors_courses_link_page_amount'
            ],
            [
                "params" => ["/^[0-9]{1,}$/"],
                "function" => 'get_majors_courses_link'
            ],
            [
                "params" => ["/^major$/", "/^[0-9]{1,}$/"],
                "function" => 'get_courses_major'
            ]
        ]
        
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