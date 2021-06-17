<?php 
require_once("core/helpers.php");
require_once("core/init.php");

$page = 'no-results';

$postsContent = include_template("pages/no-posts-template.php", 
[
    'posts' => $posts,
    'page' => $page,

]);

$page = include_template("layout.php", [
    "content" => $postsContent,
    "pgTitle" => 'нет публикаций'
]);



print($page);