<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "routes" => [
            [
                "params" => [],
                "function" => 'get_grade_admin'
            ],
            [
                "params" => ["/^user$/"],
                "function" => 'get_grade'
            ]
        ]
    ],
    "POST" => [
        "routes" => [
            [
                "params" => ["/^[0-9]{1,}$/"],
                "function" => 'post_grade_admin'
            ],
            [
                "params" => ["/^post$/"],
                "function" => 'post_grade'
            ]
        ]
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