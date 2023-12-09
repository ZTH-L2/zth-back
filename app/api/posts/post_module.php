<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "OPTIONS" => [
        "function" => 'option_post'
    ],
    "GET" => [
        "routes" => [
            [
                "params" => ["/^[0-9]{1,}$/","/^[0-9]{1,}$/"],
                "function" => 'get_all_post'
            ],
            [
                "params" => ["/^[0-9]{1,}$/"],
                "function" => 'get_post'
            ],
            [
                "params" => ["/^[0-9]{1,}$/", "/^[a-zA-Z]*$/"],
                "function" => 'get_post_course'
            ],
            [
                "params" => ["/^user$/","/^[0-9]{1,}$/"],
                "function" => 'get_post_user'
            ],
            [
                "params" => ["/^file/","/^[0-9]{1,}$/", "/.*/"],
                "function" => 'del_files_post'
            ]
        ]
    ],
    "POST" => [
        "routes" => [
            [
                "params" => [],
                "function" => 'post_post'
            ],
            [
                "params" => ["/^put$/"],
                "function" => 'put_post'
            ]
        ]

    ],
    "PUT" => [
            "params" => [],
            "function" => 'put_post'
    ],
    "DELETE" => [
        "routes" => [
            [
                "params" => ["/^admin$/", "/^[0-9]{1,}$/"],
                "function" => 'del_post_admin'
            ],
            [
                "params" => ["/^[0-9]{1,}$/"],
                "function" => 'del_post'
            ]
        ]
    ]
];

$post_module = new Module($dict);