<?php
require_once("core/init.php");
require_once("core/helpers.php");

$registrationContent = include_template("pages/registration-template.php");

$page = include_template("reg-layout.php", [
    "content" => $registrationContent
]);

print($page);
