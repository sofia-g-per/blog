<?php
require_once("core/helpers.php");

$loginContent = include_template("pages/login-template.php");

$page = include_template("login-layout.php", [
    "content" => $loginContent
]);

print($page);