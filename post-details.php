<?php
require_once("core/helpers.php");
require_once("core/init.php");
$page = "post-details";
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

//getting the information about the user whose profile we are seeing
$stmnt = $con->prepare('SELECT * FROM Users WHERE id = :id');
$stmnt->execute(['id'=>$post['author']]);
$author = $stmnt->fetch();
//number of posts the user published
$stmnt = $con->prepare(
    'SELECT COUNT(*) as num
    FROM Posts 
    WHERE author = :id'
);
$stmnt->execute(['id'=>$post['author']]);
$posts = $stmnt->fetch();
$postsNum = $posts['num'];
//amount of subscribers
$stmnt = $con->prepare('SELECT COUNT(*) as num FROM Subscriptions WHERE user = :id');
$stmnt->execute(['id'=>$post['author']]);
$subs = $stmnt->fetch();
$subsNum = $subs['num'];


//adding one to the current post's view value
$stmnt = $con->prepare(
    'UPDATE Posts SET views = views + 1
    WHERE id = :id'
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

//comments
//limit the ammount of comments visible
$stmnt = $con->prepare(
    'SELECT * FROM Comments c JOIN Users u on c.author=u.id 
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
    'postsNum' => $postsNum,
    'subsNum' => $subsNum,
    'page' => $page
]);

$postContent = include_template("pages/post-details-template.php", [
    "errors" => $errors,
    "post" => $post,
    "hashtags" => $hashtags,
    "comments" => $comments,
    "commentsNum" => $commentsNum,
    "profileTab" => $profileTab,
    "newComment" => $newComment
]);

$page = include_template("layout.php", [
    "content" => $postContent,
    "isAuth" => $isAuth
]);

print($page);