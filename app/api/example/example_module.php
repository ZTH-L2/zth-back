<?php
require_once "modules/module.php";
require_once "controlleur.php";

$dict = [
    "OPTION" => 'option',
    "GET" => 'get'
];
$example_module = new Module($dict);