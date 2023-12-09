<?php
require_once "modules/module.php";
require_once "controlleur.php";

$dict = [
    "OPTIONS" => [
        "function" => 'option_report_post'

    ],

    "POST" => [
        "params" => ["/^post$/"],
        "function" => ''
    ],

    "GET" => [
        "routes" => [
            [
                "params" => ["/^post$/"],
                # TO DO
                "function" => '' # someting that uses create_report_post

            ],

            [
                "params" => ["/^post$/","/^[0-9]{1,}$/","/^[0-9]{1,}$/"],
                # TO DO
                "function" => '' # someting that uses update_report_post
            ],

            [
                "params" => ["/^post$/","/^[0-9]{1,}$/","/^[0-9]{1,}$/","/^[0-9]{1,}$/"],
                # TO DO
                "function" => '' # someting that uses update_report_post_with_parameter
            ],

            [
                "params" => ["/^post$/","/^[0-9]{1,}$/","/^[0-9]{1,}$/"],
                # TO DO
                "function" => '' # someting that uses select_report_post
            ],

            [
                "params" => ["/^post$/","/^[0-9]{1,}$/","/^[0-9]{1,}$/","/^[0-9]{1,}$/"],
                # TO DO
                "function" => '' # someting that uses select_all_report_post
            ],

            [
                "params" => ["/^post$/","/^[0-9]{1,}$/","/^[0-9]{1,}$/","/^[0-9]{1,}$/","/^[0-9]{1,}$/"],
                # TO DO
                "function" => '' # someting that uses select_all_report_post_with_parameter 
            ],

            [
                "params" => ["/^post$/","/^[0-9]{1,}$/","/^[0-9]{1,}$/"],
                # TO DO
                "function" => '' # someting that uses delete_report_post 
            ]
        ]
    ]
];

$report_post_module = new Module($dict);