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
        "params" => ["/comment/"],
        "function" => 'create_comment'
    ],

    "GET" => [
        "routes" => [
            [
                "params" => ["/^comment$/","/[0-9][update,]/"],
                "function" => 'update_comment'
            ],

            [
                "params" => ["/^comment$/","/[0-9][update,]/","/[0-9][parametres?,]/"],
                "function" => 'update_comment_with_parameter'
            ],

            [
                "params" => ["/^comment$/","/[0-9][select,]/"],
                "function" => 'select_comment'
            ],

            [
                "params" => ["/^comment$/","/[0-9][select,]/","/[0-9][all,]/"],
                "function" => 'select_all_comment'
            ],

            [
                "params" => ["/^comment$/","/[0-9][report,]/","/[0-9][select,]/","/[0-9][all,]/"],
                "function" => 'select_all_report_post'
            ],

            [
                "params" => ["/^comment$/","/[0-9][select,]/","/[0-9][all,]/","/[0-9][parametres?,]/"],
                "function" => 'select_all_comment_with_parameter'
            ],

            [
                "params" => ["/^comment$/","/[0-9][delete,]/"],
                "function" => 'delete_comment'
            ]
        ]
    ]
];


$user_module = new Module($dict);

