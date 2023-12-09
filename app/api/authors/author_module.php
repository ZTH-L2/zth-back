<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "routes" => [
            [
                "params" => ["/^[0-9]{1,}$/"],
                "function" => 'get_author'
            ],
            [
                "params" => ["/^user$/","/^[0-9]{1}$/"],
                "function" => 'get_author_by_user'
            ],
            [
                "params" => ["/^post$/","/^[0-9]{1}$/"],
                "function" => 'get_author_by_post'
            ]
        ]
        
    ],
    "POST" => [
        "params" => [],
        "function" => 'post_author'
    ],
    "PUT" => [
        "params" => [],
        "function" => 'put_author'
    ],
    "DELETE" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'del_author'
    ]
];

$author_module = new Module($dict);