<?php
$host = $_ENV["PMA_HOST"];
$user = $_ENV["MYSQL_USER"];
$password = $_ENV["MYSQL_PASSWORD"];
$db_name = $_ENV["MYSQL_DATABASE"];

$conn = mysqli_connect($host, $user, $password, $db_name);


