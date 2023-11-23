<?php

header('Access-Control-Allow-Origin : *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods : GET');

require_once "modules/module.php";
require_once "controlleur.php";

$dict = [
    "OPTION" => [
        "function" => 'option'

    ],

    "POST" => [
        "params" => ["/like/"],
        "function" => 'create_like'
    ],

    "GET" => [
        "routes" => [
            [
                "params" => ["/like/"],
                "function" => 'create_like'
            ],

            [
                "params" => ["/^like$/","/[0-9][update,]/"],
                "function" => 'update_like'
            ],

            [
                "params" => ["/^like$/","/[0-9][update/parametres?,]/"],
                "function" => 'update_like_with_parameter'
            ],
            
            [
                "params" => ["/^like$/","/[0-9][select,]/"],
                "function" => 'select_like'
            ],

            [
                "params" => ["/^like$/","/[0-9][select/all,]/"],
                "function" => 'select_all_like'
            ],

            [
                "params" => ["/^like$/","/[0-9][select/all/parametres?,]/"],
                "function" => 'select_all_like_with_parameter'
            ],

            [
                "params" => ["/^like$/","/[0-9][delete,]/"],
                "function" => 'delete_like'
            ]
        ]
    ]
];


$user_module = new Module($dict);

