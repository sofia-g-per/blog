<?php
require_once('core/helpers.php');
require_once('core/init.php');
$page = 'profile';
$profId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);  

$stmnt = $con->prepare('SELECT * FROM Users WHERE id = :id');
$stmnt->execute(['id'=>$profId]);
$profile = $stmnt->fetch();

//posts
//limit number of posts!!!!
$stmnt = $con->prepare('SELECT * FROM Posts WHERE author = :id');
$stmnt->execute(['id'=>$profId]);
$posts = $stmnt->fetchAll();
$postsNum = count($posts);
//hashtags for each post
$hashtags = [];
foreach($posts as $post){
    $stmnt = $con->prepare(
        'SELECT hashtag
        FROM Hashtags 
        WHERE post_id = :id
        ORDER BY post_id ASC'
    ); 
    $stmnt->execute(['id'=>$post['id']]);
    $currHshtgs = $stmnt->fetchAll();
    

    if(!empty($currHshtgs)){
        foreach($currHshtgs as $key=>$hshtg){
            $currHshtgs[$key]= $hshtg['hashtag'];
        }
        $hashtags[$post['id']]= $currHshtgs;
    }
}

//amount of subscribers
$stmnt = $con->prepare('SELECT COUNT(*) as num FROM Subscriptions WHERE user = :id');
$stmnt->execute(['id'=>$profId]);
$subs = $stmnt->fetch();
$subsNum = $subs['num'];

$postDisplay = include_template("post-on-page-template.php", [
    'posts' => $posts,
    'profile'=> $profile,
    'hashtags'=> $hashtags,
    'page' => $page
]);

$profileContent = include_template("pages/profile-template.php", [
    'postDisplay' => $postDisplay,
    'profile' => $profile,
    'postsNum' => $postsNum,
    'subsNum' => $subsNum
]);

$page = include_template("layout.php", [
    'content' => $profileContent
]);

print($page);