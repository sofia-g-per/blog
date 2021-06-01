<?php
require_once("core/helpers.php");

$mainContent = include_template("pages/main-template.php");

$page = include_template("main-layout.php", [
    "content" => $mainContent
]);

print($page);