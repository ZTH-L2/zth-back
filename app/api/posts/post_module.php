<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'get_post'
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
            ],
            [
                "params" => ["/^del$/"],
                "function" => 'del_files_post'
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