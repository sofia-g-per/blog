<?php
require_once('core/init.php');
require_once('core/helpers.php');
$stmnt = $con->prepare(
    "SELECT * FROM Likes
    WHERE user = :user AND post = :post"
);
$stmnt->execute(
    ['user'=>$_SESSION['user_id'],
    'post'=>$_REQUEST['post-id']
]);
$alreadyLiked = $stmnt->fetch();
if(!$alreadyLiked){
    $stmnt = $con->prepare(
        "UPDATE Posts 
        SET likes_num = likes_num + 1
        WHERE id = :id"
    );
    $stmnt->execute(['id'=>$_REQUEST['post-id']]);
    
    $stmnt = $con->prepare(
        "INSERT INTO Likes 
        SET user = :user, post = :post"
    );
    
    $stmnt->execute([
        'user'=>$_SESSION['user_id'],
        'post'=>$_REQUEST['post-id']
    ]);
} else{
    $stmnt = $con->prepare(
        "UPDATE Posts 
        SET likes_num = likes_num - 1
        WHERE id = :id"
    );
    $stmnt->execute(['id'=>$_REQUEST['post-id']]);
    
    $stmnt = $con->prepare(
        "DELETE FROM Likes 
        WHERE user = :user AND post = :post"
    );
    $stmnt->bindValue(':user', intval($_SESSION['user_id']), PDO::PARAM_INT);
    $stmnt->bindValue(':post', intval($_REQUEST['post-id']), PDO::PARAM_INT);
    $stmnt->execute();
}

header('Location: '.$_SERVER['HTTP_REFERER']);