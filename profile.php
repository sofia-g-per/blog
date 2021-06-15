<?php
require_once('core/helpers.php');
require_once('core/init.php');

//add reposts
$page = 'profile';

$profId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);  
$pagePar = filter_input(INPUT_GET, 'par');  

//getting the information about the user whose profile we are seeing
$stmnt = $con->prepare(
    'SELECT u.*,
        (SELECT COUNT(*) FROM Posts p
        WHERE p.author = u.id) postsNum,
        (SELECT COUNT(*) FROM Subscriptions s
    WHERE s.user = u.id) subsNum
    FROM Users u
    WHERE id = :id'
);
$stmnt->execute(['id'=>$profId]);
$profile = $stmnt->fetch();


//ПОСТЫ
$stmnt = $con->prepare(
    "SELECT p.*, p.id as post, u.login, u.profile_pic, 
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
    JOIN Users u on p.author = u.id
    WHERE author = :id
    ORDER BY date_created DESC
    LIMIT 0, 10"
);
$stmnt->execute(['id'=>$profId]);
$posts = $stmnt->fetchAll();

//для каждого репоста в массиве $posts заменяем значения 'original-author'
//на массив с id, логином и аватаркой пользователя  
//do with left join but check the template
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

//превращение тэги из строки в массив
foreach($posts as $key=>$post){
    if($post['hashtags'] != NULL){
        $posts[$key]['hashtags'] = explode(' ', $post['hashtags']); 
    } else{
        unset($post['hashtags']);
    }
}

//ЛАЙКИ
//извлечение данных постов пользователя, которые недавно лайкали другие пользователи 
$stmnt = $con->prepare(
    'SELECT p.id, p.content, p.content_type, p.author, l.date_created, u.login, u.profile_pic
    FROM Likes l
    INNER JOIN Posts p on l.post = p.id
    INNER JOIN Users u on l.user = u.id
    WHERE p.author = :id
    ORDER BY l.date_created DESC
    LIMIT 0, 10'
);
$stmnt->execute(['id'=>$profId]);
$likes = $stmnt->fetchAll();
            
//ПОДПИСКИ
//извлечение данных профилей, на которые подписан пользователь
$stmnt = $con->prepare(
    'SELECT u.id, u.login, u.profile_pic, u.reg_date,
        (SELECT COUNT(*) FROM Subscriptions
        WHERE user = u.id) as subs_num,
        (SELECT COUNT(*) FROM Posts
        WHERE author = u.id) as posts_num
        
    FROM Subscriptions s
    JOIN Users u on s.user = u.id
    WHERE s.subscriber = :id
    ORDER BY s.date_created DESC
    LIMIT 0, 10'
);
$stmnt->execute(['id'=>$profId]);
$subs = $stmnt->fetchAll();

$profileTab = include_template("profile-tab-template.php", [
    'profile'=> $profile,
    'page' => $page
]);

$profileContent = include_template("pages/profile-template.php", [
    'posts' => $posts,
    'likes' => $likes,
    'subs' => $subs,
    'profile'=> $profile,
    'page' => $page,
    'pagePar' => $pagePar,
    'profileTab' => $profileTab,
    'profile' => $profile
]);

$page = include_template("layout.php", [
    'content' => $profileContent,
    "pgTitle" => 'профиль'
]);

print($page);