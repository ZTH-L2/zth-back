<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "GET" => [
        "routes" => [
            [
                "params" => ["/[0-9]{1,}/"],
                "function" => 'get_subscription'
            ],
            [
                "params" => ["/user/"],
                "function" => 'get_subscription_by_id'
            ]
        
        ]
    ],
    "POST" => [
        "function" => 'post_subscription'
    ],
    "PUT" => [
        "function" => 'put_subscription'
    ],
    "DELETE" => [
        "params" => ["/[0-9]{1,}/"],
        "function" => 'del_subscription'
    ]
    ];

$subscription_module = new Module($dict);