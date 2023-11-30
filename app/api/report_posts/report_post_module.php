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
        "params" => ["/post/"],
        "function" => 'create_report_post'
    ],

    "GET" => [
        "routes" => [
            [
                "params" => ["/post/"],
                //if (select_report_post($conn, $id) != null) {
                    "function" => 'create_report_post'
                //} else {
                //    return invalid_format_data_error_message();
                //}
            ],

            [
                "params" => ["/^post$/","/[0-9][report,]/","/[0-9][update,]/"],
                "function" => 'update_report_post'
            ],

            [
                "params" => ["/^post$/","/[0-9][report,]/","/[0-9][update,]/","/[0-9][parametres?,]/"],
                "function" => 'update_report_post_with_parameter'
            ],

            [
                "params" => ["/^post$/","/[0-9][report,]/","/[0-9][select,]/"],
                "function" => 'select_report_post'
            ],

            [
                "params" => ["/^post$/","/[0-9][report,]/","/[0-9][select,]/","/[0-9][all,]/"],
                "function" => 'select_all_report_post'
            ],

            [
                "params" => ["/^post$/","/[0-9][report,]/","/[0-9][select,]/","/[0-9][all,]/","/[0-9][parametres?,]/"],
                "function" => 'select_all_report_post_with_parameter'
            ],

            [
                "params" => ["/^post$/","/[0-9][report,]/","/[0-9][delete,]/"],
                "function" => 'delete_report_post'
            ]
        ]
    ]
];

$report_post_module = new Module($dict);