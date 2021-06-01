<?php
require_once("core/helpers.php");

$feedContent = include_template("pages/feed-template.php");

$page = include_template("layout.php", [
    "content" => $feedContent
]);

print($page);