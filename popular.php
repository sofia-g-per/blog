<?php
require_once("core/helpers.php");
require_once("core/init.php");


//find 10 posts with biggest view number
$stmnt = 'SELECT * FROM Posts ORDER BY views DESC LIMIT 1';
$stmnt->execute();

dd();

$popularContent = include_template("pages/popular-template.php");

$page = include_template("layout.php", [
    "content" => $popularContent,
    "_SESSION" => $_SESSION
]);



print($page);

