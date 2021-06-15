<?php
require_once("core/helpers.php");
require_once("core/init.php");
$page = "post-details";
$postId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

//post info
$stmnt = $con->prepare(
    "SELECT p.*, p.id as post, u.login, u.profile_pic, u.reg_date,
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
    JOIN Users u on u.id = p.author 
    WHERE p.id = :id"
);
$stmnt -> execute(['id'=>$postId]);
$post = $stmnt -> fetch();

//превращение тэгов из строки в массив
if($post['hashtags'] != NULL){
    $posts[$key]['hashtags'] = explode(' ', $post['hashtags']); 
} else{
    unset($post['hashtags']);
}

//разбиение даты регистрации из единой строки в массив тип [year, month, day]??
//$years = intval(date('Y')) -  substr($post['reg_date'], 0, 3);

//извлекаем информацию о создатели поста чтобы передать её в шаблон profile-tab
$stmnt = $con->prepare(
    "SELECT u.*,
    (SELECT COUNT(*) FROM Posts p
    WHERE p.author = u.id) postsNum,
    (SELECT COUNT(*) FROM Subscriptions s
    WHERE s.user = u.id) subsNum 
    FROM Users u 
    WHERE u.id = :id"
);
$stmnt->execute(['id'=>$post['author']]);
$author = $stmnt->fetch();


//добавление +1 просмотра на данный пост
if($_SERVER['HTTP_CACHE_CONTROL'] != 'max-age=0'){
    $stmnt = $con->prepare(
        'UPDATE Posts SET views = views + 1
        WHERE id = :id'
    );
    $stmnt -> execute(['id'=>$postId]);
}

//comments
//limit the ammount of comments visible
$stmnt = $con->prepare(
    'SELECT * FROM Comments c 
    JOIN Users u on c.author=u.id 
    WHERE c.post = :id
    ORDER BY date_created DESC
    LIMIT 0,2');
$stmnt -> execute(['id'=>$postId]);
$comments = $stmnt -> fetchAll();
$commentsNum = count($comments);

//creating a new comment
$errors =[];
$newComment = $_POST;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //dd($newComment);
    $text = trim($newComment['text']);
    $errors['text'] = validateFilled('text');
    $errors = array_filter($errors);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)){
    $stmnt = $con->prepare("INSERT INTO Comments SET text = :text, author = :user, post = :post");
    $stmnt->execute([
        'text' => $newComment['text'],
        'user' => $_SESSION['user_id'],
        'post' => $newComment['post-id']
    ]);

    header('Location: post-details.php?id='.$newComment['post-id']);
}

$profileTab = include_template("profile-tab-template.php", [
    'profile'=> $author,
    'page' => $page
]);

$postContent = include_template("pages/post-details-template.php", [
    "errors" => $errors,
    "page" => $page,
    "post" => $post,
    "comments" => $comments,
    "commentsNum" => $commentsNum,
    "profileTab" => $profileTab,
    "newComment" => $newComment
]);

$page = include_template("layout.php", [
    "content" => $postContent,
    "isAuth" => $isAuth,
    "pgTitle" => 'публикация'
]);

print($page);