<?php
require_once('core/init.php');

//checking if the user is already subscribed to this profile
$IsSubscribed = array_search($_REQUEST['profileId'], $_SESSION['subs']);
//если пользователь не подписан на этот профиль
if($IsSubscribed === false){
    //checking if the user is trying to subscribe to themselves
    if($_REQUEST['profileId'] != $_SESSION['user_id']){
        
        //subscribing
        $stmnt = $con->prepare(
            'INSERT INTO subscriptions
            SET subscriber = :id,
            user = :profile'
        );
        $stmnt->execute([
            'profile' => $_REQUEST['profileId'],
            'id' => $_SESSION['user_id']
        ]);
        array_push($_SESSION['subs'], $_REQUEST['profileId']);
    }
} else{
    //unsubscribing
    $stmnt = $con->prepare(
        'DELETE FROM subscriptions
        WHERE subscriber = :id AND user = :profile'
    );
    $stmnt->execute([
        'profile' => $_REQUEST['profileId'],
        'id' => $_SESSION['user_id']
    ]);
    unset($_SESSION['subs'][$IsSubscribed]);
}

header('Location: '.$_SERVER['HTTP_REFERER']);

