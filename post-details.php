<?php
require_once("core/helpers.php");
require_once("core/init.php");

$postId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

//post info
$stmnt = $con->prepare('SELECT * FROM Posts WHERE id = :id');
$stmnt -> execute(['id'=>$postId]);
$post = $stmnt -> fetch();

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
if($likesNum != 0){

}

else{
    foreach($likes as $row_num=> $row){
        $likes[$row_num] = $row['user'];
    }
}
//преобразование массива из двумерного в одномерный

$postContent = include_template("pages/post-details-template.php", [
    "errors" => $errors
]);

$page = include_template("layout.php", [
    "content" => $postContent,
    "isAuth" => $isAuth
]);

print($page);