<?php
require_once("core/helpers.php");
require_once("core/init.php");


//find 10 posts with biggest view number 
//change 4 to 10
$stmnt = $con-> query(
    'SELECT p.* , u.login, u.profile_pic, u.reg_date 
    FROM Posts p 
    JOIN Users u on u.id = p.author  
    ORDER BY views DESC LIMIT 0, 4'
    );
$posts = $stmnt->fetchAll();

//likes
$likesNum = 0;
$commentsNum = 0;
/*$stmnt = $con->prepare('SELECT user FROM Likes WHERE post = :id');
$stmnt -> execute(['id'=>$postId]);
$likes = $stmnt -> fetchAll();
$likesNum = count($likes);
//преобразование массива из двумерного в одномерный
if($likesNum != 0){
    foreach($likes as $row_num=> $row){
        $likes[$row_num] = $row['user'];
    }
}
//comments
$stmnt = $con->prepare('SELECT * FROM Comments WHERE post = :id');
$stmnt -> execute(['id'=>$postId]);
$comments = $stmnt -> fetchAll();
$commentsNum = count($comments); */


$popularContent = include_template("pages/popular-template.php", 
[
    'posts' =>$posts,
    'likesNum' => $likesNum,
    'commentsNum' => $commentsNum
]);

$page = include_template("layout.php", [
    "content" => $popularContent,
    "_SESSION" => $_SESSION
]);



print($page);

