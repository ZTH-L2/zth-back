<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "OPTION" => [
        "function" => 'option_user'
    ],
    "POST" => [
        "params" => ["/register/"],
        "function" => 'register'
    ]
];

$user_module = new Module($dict);