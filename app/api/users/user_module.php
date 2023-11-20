<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "OPTION" => [
        "function" => 'option_user'
    ],
    "GET" => [
        "routes" => [
            [
                // admin only
                "params" => ["/^[0-9]{1,}$/"],
                "function" => 'get_user_by_id'
            ],
            [
                "params" => ["/^logout$/"],
                "function" => 'logout'
            ]
        ]
        
    ],
    "POST" => [
        "routes" => [
            [
                "params" => ["/^register$/"],
                "function" => 'register'
            ],
            [
                "params" => ["/^login$/"],
                "function" => 'login'
            ]
        ]
    ],
    "PUT" => [
        "routes" => [
            [
                // this is a /user | no params
                "params" => [],
                "function" => 'update_my_account'
            ]
        ]
    ],
    "DELETE" => [
        "routes" => [
            [
                // admin only
                "params" => ["/^[0-9]{1,}$/"],
                "function" => 'delet_user_by_id'
            ],
            [
                // this is a /user | no params
                "params" => [],
                "function" => 'delete_my_account'
            ]
        ]
    ]
];

$user_module = new Module($dict);