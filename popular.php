<?php
require_once("core/helpers.php");

$popularContent = include_template("pages/popular-template.php");

$page = include_template("layout.php", [
    "content" => $popularContent
]);

print($page);

