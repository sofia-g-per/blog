<?php
require_once('core/init.php');
require_once('core/helpers.php');

$stmnt = $con->prepare(
    "SELECT * FROM Posts 
     WHERE id =:id"
);
$stmnt -> execute(['id'=>$_REQUEST['post-id']]);

$originalPost = $stmnt->fetch();

$originalPost['user'] = $_SESSION['user_id'];
unset($originalPost['date_created']);
unset($originalPost['views']);
unset($originalPost['likes_num']);
unset($originalPost['repost_num']);
unset($originalPost['comments_num']);
unset($originalPost['repost']);
unset($originalPost['original_post_id']);
unset($originalPost['original_author']);

$stmnt = $con->prepare(
    "INSERT INTO Posts 
     SET title = :title, 
     content = :content,
     author = :user,
     content_type = :content_type,
     quote_author = :quote_author,
     repost = 1,
     original_author = :author,
     original_post_id = :id" 
);


$stmnt->execute($originalPost);

//add one to repost_num of original post
$stmnt = $con->prepare(
    "UPDATE Posts
     SET repost_num = repost_num + 1 
     WHERE id =:id "
);
$stmnt->execute(['id'=>$_REQUEST['post-id']]);
header("Location: profile.php?id=".$originalPost['author']."&par=posts");