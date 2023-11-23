<?php
require_once "modules/module.php";
require_once "controlleur.php";

$dict = [
    "OPTIONS" => [
        "function" => 'option_comment'
    ],
    "GET" => [
        "routes" => [
            [
                "params" => ["/^liked$/"],
                "function" => 'those_i_liked'
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