<?php
session_start();
if (!isset($_SESSION["path"]) || !$_SESSION["path"] )
{
    http_response_code(403);
}
elseif (isset($_SESSION["path"]) && $_SESSION["path"])
{
    $_SESSION["path"] = False;
    # access allowed

    # the api code
}