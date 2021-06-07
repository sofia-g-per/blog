<?php
require_once("core/helpers.php");
require_once("core/init.php");

$postId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

//post info
$stmnt = $con->prepare(
    'SELECT p.* , u.login, u.profile_pic, u.reg_date 
    FROM Posts p 
    JOIN Users u on u.id = p.author 
    WHERE p.id = :id'
);
$stmnt -> execute(['id'=>$postId]);
$post = $stmnt -> fetch();
//разбиение даты регистрации из единой строки в массив тип [year, month, day]??

//$years = intval(date('Y')) -  substr($post['reg_date'], 0, 3);


//adding one to the current post's view value
$stmnt = $con->prepare(
    'UPDATE Posts SET views = views + 1
    WHERE p.id = :id'
);
$stmnt -> execute(['id'=>$postId]);

//hashtags
$stmnt = $con->prepare('SELECT hashtag FROM Hashtags WHERE post_id = :id');
$stmnt -> execute(['id'=>$postId]);
$hashtags = $stmnt -> fetchAll();

//преобразование массива из двумерного в одномерный
//[[''=>ht], [], []]
foreach($hashtags as $row_num=> $row){
    $hashtags[$row_num] = $row['hashtag'];
}

//likes
$stmnt = $con->prepare('SELECT user FROM Likes WHERE post = :id');
$stmnt -> execute(['id'=>$postId]);
$likes = $stmnt -> fetchAll();
$likesNum = count($likes);
//преобразование массива из двумерного в одномерный
if($likesNum != 0){
    foreach($likes as $row_num=> $row){
        $likes[$row_num] = $row['user'];
    }
}
//follower number
$stmnt = $con->prepare('SELECT subscriber FROM Subscriptions WHERE user = :id');
$stmnt -> execute(['id'=>$post['author']]);
$followers = $stmnt -> fetchAll();
$followerNum = count($followers);
//posts
$stmnt = $con->prepare('SELECT id FROM Posts WHERE author = :userID');
$stmnt -> execute(['userID'=>$post['author']]);
$user_posts = $stmnt -> fetchAll();
$postsNum = count($user_posts);
//comments
$stmnt = $con->prepare('SELECT * FROM Comments WHERE post = :id');
$stmnt -> execute(['id'=>$postId]);
$comments = $stmnt -> fetchAll();
$commentsNum = count($comments);

//repost number?

//creating a new comment
$errors =[];
$rules = [];




$postContent = include_template("pages/post-details-template.php", [
    "errors" => $errors,
    "post" => $post,
    "hashtags" => $hashtags,
    "likesNum" => $likesNum,
    "postsNum" => $postsNum,
    "followersNum" => $followersNum,
    "commentsNum" => $commentsNum,
    "years" => $years
]);

$page = include_template("layout.php", [
    "content" => $postContent,
    "isAuth" => $isAuth
]);

print($page);