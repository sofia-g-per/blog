<?php
require_once('core/init.php');

//checking if the user is already subscribed to this profile
$stmnt = $con->prepare(
    'SELECT COUNT(*) as num
    FROM subscriptions
    WHERE user = :profile AND subscriber = :id'
);
$stmnt->execute([
    'profile' => $_REQUEST['profileId'],
    'id' => $_SESSION['user_id']
]);
$IsSubscribed = $stmnt->fetch();
$IsSubscribed = $IsSubscribed['num'];

if($IsSubscribed == 0){
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

}


header('Location: '.$_SERVER['HTTP_REFERER']);

