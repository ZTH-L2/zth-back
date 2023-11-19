<?php
require_once "modules/module.php";
require_once "controlleur.php";

$dict = [
    "OPTION" => [
        "function" => 'option_example'
    ],
    "GET" => [
        "routes" => [
            [
                "params" => ["/^exparam$/", "/^[0-9]$/"],
                "function" => 'get_example'
            ]
        ]
    ]
];
$example_module = new Module($dict);