<?php
require_once "modules/module.php";
require_once "controlleur.php";

$dict = [
    "OPTIONS" => [
        "function" => 'option_report_comment'
    ],
    "GET" => [
        "routes" => [
            [
                "params" => ["/bycomment/", "/^[0-9]{1,}$/", "/^[0-9]{1,}$/", "/^[0-9]{1,}$/"],
                "function" => 'get_by_id_comment_page_amount'
            ],
            [
                "params" => ["/^byuser$/", "/^[0-9]{1,}$/", "/^[0-9]{1,}$/", "/^[0-9]{1,}$/"],
                "function" => 'get_by_id_user_page_amount'
            ]
        ]
    ],
    "POST" => [
        "params" => [],
        "function" => 'report'
    ],
    "DELETE" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'delete_report_by_id'
    ]
    
];
$report_comment_module = new Module($dict);