<?php
require_once "modules/module.php";
require_once "controlleur.php";

$dict = [
    "OPTIONS" => [
        "function" => 'option_like'
    ],
    "GET" => [
        "routes" => [
            [
                "params" => ["/^liked$/", "/^[0-9]{1,}$/", "/^[0-9]{1,}$/"],
                "function" => 'those_i_liked_page_amount'
            ],
            [
                "params" => ["/^isliked$/","/^[0-9]{1,}$/"],
                "function" => 'did_i_like_this'
            ]
        ]
    ],
    "POST" => [
        "routes" => [
            [
                "params" => [],
                "function" => 'like_one'
            ],
            [
                "params" => ["/^many$/", "/^like$/"],
                "function" => 'like_many'
            ],
            [
                "params" => ["/^many$/", "/^unlike$/"],
                "function" => 'unlike_many'
            ],
            [
                "params" => ["/^check$/"],
                "function" => 'did_i_liked_those'
            ]
        ]
    ],
    "DELETE" => [
        // remove a like
        "routes" => [
            [
                "params" => ["/^unlike$/","/^[0-9]{1,}$/"],
                "function" => 'unlike_one'
            ]
        ]
    ]
];

$like_module = new Module($dict);