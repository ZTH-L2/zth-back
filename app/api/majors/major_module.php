<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "OPTIONS" => [
        "function" => 'option_major'
    ],
    "GET" => [
        "routes" => [
            [
                "params" => [],
                "function" => 'get_all_major'    
            ],
            [
                "params" => ["/^[0-9]{1,}$/", "/^[0-9]{1,}$/"],
                "function" => 'get_all_major_page_amount'    
            ],
            [
                "params" => ["/^[0-9]{1,}$/"],
                "function" => 'get_major'
            ]
        ]
        
    ],
    "POST" => [
        "params" => [],
        "function" => 'post_major'
    ],
    "PUT" => [
        "params" => [],
        "function" => 'put_major'
    ],
    "DELETE" => [
        "params" => ["/^[0-9]{1,}$/"],
        "function" => 'del_major'
    ]
];

$major_module = new Module($dict);