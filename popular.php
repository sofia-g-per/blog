<?php
require_once("core/helpers.php");
require_once("core/init.php");

$page = 'popular';

//page link dhould have the page number which will define the offset in this line -FIX!!!
//same concept for filtering posts by type
$pageNum = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
$pagePar = filter_input(INPUT_GET, "par"); //likes, views or date is used as a filter for posts showing
$pageCat = filter_input(INPUT_GET, "con");

//часть запроса одинаковая при любой выбранной фильтрации публикаций
$basic = "SELECT p.* , p.id as post, u.login, u.profile_pic, 
    (SELECT GROUP_CONCAT(hashtag SEPARATOR ' ') 
    FROM Hashtags h 
    WHERE h.post_id = p.id) hashtags,
    (SELECT COUNT(*)
    FROM Posts p WHERE original_post_id=post) repost_num,
    (SELECT COUNT(*)
    FROM Likes l WHERE l.post = p.id ) likes_num,
    (SELECT COUNT(*)
    FROM Comments c WHERE c.post = p.id ) comments_num
FROM Posts p 
JOIN Users u on u.id = p.author";

//Добавления ограничения категории, если она выбрана
if ($pageCat != 'default'){

    $basic = $basic."WHERE content_type = '".$pageCat."'\n";
}
//add if for last page 
//добавления условия упорядывачивания постов согласно выбранному критерию (популярное (просмотры), лайки, дата ) 
$basic = $basic." ORDER BY p.".$pagePar." DESC LIMIT :st , 10";
$stmnt = $con->prepare($basic);

$offset = $pageNum * 10;
$stmnt->bindValue(':st', $offset, PDO::PARAM_INT);
$stmnt->execute();
$posts = $stmnt->fetchAll();

//превращение тэги из строки в массив
foreach($posts as $key=>$post){
    if($post['hashtags'] != NULL){
        $posts[$key]['hashtags'] = explode(' ', $post['hashtags']); 
    } else{
        unset($post['hashtags']);
    }
}

//getting category names
$stmnt = $con-> query('SELECT * FROM content_type');
$cats = $stmnt->fetchAll();

$popularContent = include_template("pages/popular-template.php", 
[
    'posts' => $posts,
    'page' => $page,
    'pageNum' => $pageNum,
    'pageCat' => $pageCat,
    'pagePar' => $pagePar,
    'cats' => $cats
]);

$page = include_template("layout.php", [
    "content" => $popularContent,
    "pgTitle" => 'популярное'
]);



print($page);
