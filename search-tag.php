<?php 
require_once('core/init.php');
require_once('core/helpers.php');
$page = 'search';

$tag = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
$tag = trim($tag);
var_dump($tag);

$stmnt = $con->prepare(
    "SELECT p.*, p.id as post, u.id, u.login, u.profile_pic, 
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
    JOIN Hashtags h on h.post_id = p.id
    WHERE MATCH(h.hashtag) AGAINST(:tag)"
);
$stmnt->execute(['tag'=> $tag]);
$posts = $stmnt->fetchAll();

//превращение тэгов из строки в массив
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
//var_dump($posts);

//Формирование страницы
$searchContent = include_template('pages/search-results-template.php', [
    'posts' => $posts,
    'page' => $page,
    'search' => '#'.$tag
]);

$page = include_template('layout.php', [
    'content' => $searchContent,
    'page' => $page,
    'pgTitle' => 'страница результов поиска'
]);

print($page);