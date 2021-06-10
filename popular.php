<?php
require_once("core/helpers.php");
require_once("core/init.php");

$page = 'popular';

//page link dhould have the page number which will define the offset in this line -FIX!!!
//same concept for filtering posts by type
$pageNum = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
$pagePar = filter_input(INPUT_GET, "par"); //likes, views or date is used as a filter for posts showing
$pageCat = filter_input(INPUT_GET, "con");

//find 10 posts with biggest view number 
//change 4 to 10

//add if for last page 
switch($pagePar){
    case('views'):
        $basic = 'SELECT p.* , u.login, u.profile_pic
            FROM Posts p 
            JOIN Users u on u.id = p.author  
            ORDER BY views DESC LIMIT :st , 4';
    break;
    case('likes_num'):
        $basic = 'SELECT p.* , u.login, u.profile_pic
            FROM Posts p 
            JOIN Users u on u.id = p.author  
            ORDER BY likes_num DESC LIMIT :st , 4';
    break;
    case('reg_date'):
        $basic = 'SELECT p.* , u.login, u.profile_pic
            FROM Posts p 
            JOIN Users u on u.id = p.author  
            ORDER BY reg_date DESC LIMIT :st , 4';
    break;
}

//Adding category restraint on to the query
if ($pageCat == 'default'){
    //if no category is chosen
    $stmnt = $con-> prepare($basic);
} else{
    //inserting the category type between the join... line and the order by... line
    $basic = explode("\n", $basic);
    $basic1 = $basic[0].$basic[1].$basic[2];
    $basic2 = $basic[3];
    $stmnt = $con->prepare($basic1."WHERE content_type = '".$pageCat."'\n".$basic2);
    //dd($stmnt);
}

$offset = $pageNum * 4;
$stmnt->bindValue(':st', $offset, PDO::PARAM_INT);
$stmnt->execute();
$posts = $stmnt->fetchAll();

//getting category names
$stmnt = $con-> query('SELECT * FROM content_type');
$cats = $stmnt->fetchAll();

$postsContent = include_template("post-on-page-template.php", [
    'posts' => $posts,
    'page' => $page
]);

$popularContent = include_template("pages/popular-template.php", 
[
    'postsContent' => $postsContent,
    'posts' => $posts,
    'pageNum' => $pageNum,
    'pageCat' => $pageCat,
    'pagePar' => $pagePar,
    'cats' => $cats
]);

$page = include_template("layout.php", [
    "content" => $popularContent,
    "_SESSION" => $_SESSION
]);



print($page);



//likes with count 
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