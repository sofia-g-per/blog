<?php
require_once('core/helpers.php');
require_once('core/init.php');


$profileContent = include_template("pages/profile-template.php");

$page = include_template("layout.php", [
    'content' => $profileContent
]);

print($page);