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
$alreadyLiked = array_search($_REQUEST['post-id'], $_SESSION['likes']);
if($alreadyLiked === false){
    //добавление лайка  
    $stmnt = $con->prepare(
        "INSERT INTO Likes 
        SET user = :user, post = :post"
    );
    
    $stmnt->execute([
        'user'=>$_SESSION['user_id'],
        'post'=>$_REQUEST['post-id']
    ]);
    array_push($_SESSION['likes'], $_REQUEST['post-id']);
} else{
    //unlike  
    $stmnt = $con->prepare(
        "DELETE FROM Likes 
        WHERE user = :user AND post = :post"
    );
    $stmnt->bindValue(':user', intval($_SESSION['user_id']), PDO::PARAM_INT);
    $stmnt->bindValue(':post', intval($_REQUEST['post-id']), PDO::PARAM_INT);
    $stmnt->execute();

    unset($_SESSION['likes'][$alreadyLiked]);
}

header('Location: '.$_SERVER['HTTP_REFERER']);