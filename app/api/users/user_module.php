<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "OPTION" => [
        "function" => 'option_user'
    ],
    "POST" => [
        "routes" => [
            [
                "params" => ["/register/"],
                "function" => 'register'
            ],
            [
                "params" => ["/login/"],
                "function" => 'login'
            ]
        ]
    ]
];

$user_module = new Module($dict);