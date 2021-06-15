<?php
require_once("core/helpers.php");
require_once("core/init.php");

$page = 'feed';
$pageCat = filter_input(INPUT_GET, 'con');

//посты пользователей, на которых подписан пользователь
$basic = "SELECT p.*, p.id as post, u.id, u.login, u.profile_pic, 
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
    JOIN Subscriptions s on s.user = p.author
    JOIN Users u on p.author = u.id
    WHERE s.subscriber = :id";
//добавление категории к запросу, если она выбрана пользователем
if($pageCat != 'all'){
    $basic = $basic." AND p.content_type = '".$pageCat."'";  
}

$basic = $basic." ORDER BY date_created ASC LIMIT 0, 10";
$stmnt = $con->prepare($basic);
$stmnt->execute(['id'=>$_SESSION['user_id']]);
$posts = $stmnt->fetchAll();

//превращение тэги из строки в массив
foreach($posts as $key=>$post){
    if($post['hashtags'] != NULL){
        $posts[$key]['hashtags'] = explode(' ', $post['hashtags']); 
    } else{
        unset($post['hashtags']);
    }
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
//all author info can be accessed via $post['original_author']['info needed']


//getting category names
$stmnt = $con-> query('SELECT * FROM content_type');
$cats = $stmnt->fetchAll();

$feedContent = include_template("pages/feed-template.php",[
    'posts' => $posts,
    'page' => $page,
    'pageCat' => $pageCat,
    'cats' => $cats
]);

$page = include_template("layout.php", [
    "content" => $feedContent,
    "pgTitle" => 'моя лента'
]);

print($page);