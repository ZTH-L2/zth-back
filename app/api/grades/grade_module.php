<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'get_grade'
    ],
    "POST" => [
        "params" => [],
        "function" => 'post_grade'
    ],
    "PUT" => [
        "routes" => [
            [
                "params" => [],
                "function" => 'put_grade'
            ],
            [
                "params" => ["/^user$/"],
                "function" => 'put_grade_user'
            ]
        
        ]
    ],
    "DELETE" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'del_grade'
    ]
];

$grade_module = new Module($dict);