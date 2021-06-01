<?php
require_once("core/helpers.php");

$addingPostContent = include_template("pages/adding-post-template.php");

$page = include_template("layout.php", [
    "content" => $addingPostContent
]);

print($page);