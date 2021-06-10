<?php
require_once('core/helpers.php');
require_once('core/init.php');

//add reposts
$page = 'profile';

$profId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);  
$pagePar = filter_input(INPUT_GET, 'par');  

//getting the information about the user whose profile we are seeing
$stmnt = $con->prepare('SELECT * FROM Users WHERE id = :id');
$stmnt->execute(['id'=>$profId]);
$profile = $stmnt->fetch();

//number of posts the user published
$stmnt = $con->prepare(
    'SELECT COUNT(*) as num
    FROM Posts 
    WHERE author = :id'
);
$stmnt->execute(['id'=>$profId]);
$posts = $stmnt->fetch();
$postsNum = $posts['num'];

//amount of subscribers
$stmnt = $con->prepare('SELECT COUNT(*) as num FROM Subscriptions WHERE user = :id');
$stmnt->execute(['id'=>$profId]);
$subs = $stmnt->fetch();
$subsNum = $subs['num'];

//posts that are displayed on this page
switch($pagePar){
    case("posts"):
        $stmnt = $con->prepare(
            'SELECT *, u.id, u.login, u.profile_pic
            FROM Posts p
            JOIN Users u on p.author = u.id
            WHERE author = :id
            ORDER BY date_created ASC
            LIMIT 0, 10'
        );
        $stmnt->execute(['id'=>$profId]);
        $posts = $stmnt->fetchAll();
        
        break;

        case("likes"):
            $stmnt = $con->prepare(
                'SELECT p.*, u.id, u.login, u.profile_pic
                FROM Posts p
                JOIN Likes l on l.post = p.id
                JOIN Users u on p.author = u.id
                WHERE l.user = :id
                ORDER BY date_created ASC
                LIMIT 0, 10'
            );
            $stmnt->execute(['id'=>$profId]);
            $posts = $stmnt->fetchAll();
            
            break;

        case("subs"):
            $stmnt = $con->prepare(
                'SELECT p.*, u.id, u.login, u.profile_pic
                FROM Posts p
                JOIN Subscriptions s on s.user = p.author
                JOIN Users u on p.author = u.id
                WHERE s.subscriber = :id
                ORDER BY date_created ASC
                LIMIT 0, 10'
            );
            $stmnt->execute(['id'=>$profId]);
            $posts = $stmnt->fetchAll();
            
            break;
}
//для каждого репоста в массиве $posts заменяем значения 'original-author'
//на массив с id, логином и аватаркой пользователя  
foreach($posts as $key => $post){
    if($post['repost']){
        $stmnt = $con->prepare(
            'SELECT id, login, profile_pic FROM Users
            WHERE id = :original_author'
        );
        $stmnt->execute([
            'original_author' => $post['original_author']
        ]);
        $posts[$key]['original_author'] = $stmnt->fetch();
    }
}
//dd($posts[0]['original_author']['login']);
//all author info can be accessed via $post['original_author']['info needed']

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

$profileTab = include_template("profile-tab-template.php", [
    'profile'=> $profile,
    'postsNum' => $postsNum,
    'subsNum' => $subsNum,
    'page' => $page
]);

$postDisplay = include_template("post-on-page-template.php", [
    'posts' => $posts,
    'profile'=> $profile,
    'hashtags'=> $hashtags,
    'page' => $page
]);

$profileContent = include_template("pages/profile-template.php", [
    'pagePar' => $pagePar,
    'profileTab' => $profileTab,
    'postDisplay' => $postDisplay,
    'profile' => $profile,
]);

$page = include_template("layout.php", [
    'content' => $profileContent
]);

print($page);