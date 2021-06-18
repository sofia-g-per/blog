<?php
require_once("core/helpers.php");
require_once("core/init.php");

$isAuth = false;

$errors = [];
$rules = [
    'login' => function(){
        return validateFilled('login');
    },
    'password' => function(){
        return validateFilled('password');
    }
];

$user = $_POST;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    foreach($user as $key => $value){
        if(isset($rules[$key])){
            $errors[$key] = $rules[$key]();
        }
    }
}
$errors = array_filter($errors);

if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)){
    $stmnt = $con -> prepare(
        "SELECT u.*,
            (SELECT GROUP_CONCAT(s.user SEPARATOR ' ')
            FROM Subscriptions s
            WHERE s.subscriber = u.id) subs, 
            (SELECT GROUP_CONCAT(l.post SEPARATOR ' ')
            FROM Likes l
            WHERE l.user = u.id) likes,
            (SELECT COUNT(*)
            FROM Messages m
            WHERE m.receipient = u.id 
            AND m.read = 0) unread_num
        
        FROM Users u 
        WHERE u.login=:login"
    );
    $stmnt -> execute(['login' => $user['login']]);

    if($stmnt -> rowCount() == 0){
        $errors['login'] = "Пользователь с данным логином не зарегистрирован";
    } else{
        $dbUser = $stmnt -> fetch();
        
        if(password_verify($user['password'], $dbUser['password'])){
            $_SESSION['user_id'] = $dbUser['id'];
            $_SESSION['login'] = $dbUser['login'];
            $_SESSION['profile_pic'] = $dbUser['profile_pic'];
            //$_SESSION['email'] = $dbUser['email'];
            $_SESSION['subs'] = explode(' ', $dbUser['subs']); //массив id пользователей, на которых подписан зарег пользователей
            $_SESSION['likes'] = explode(' ', $dbUser['likes']); //массив id постов, которые лайкнул зарег пользователей
            $_SESSION['unread_num'] = $dbUser['unread_num']; //количество непрочитанных сообщений у пользователя 
            $isAuth = true;
            
            header("Location: popular.php?page=0&par=views&con=default");

        }
        else{
            //если неверный пароль
            $errors['password'] = "Введите корректные данные";
        }
    }
}

$mainContent = include_template("pages/main-template.php", [
    "errors" => $errors
]);

$page = include_template("main-layout.php", [
    "content" => $mainContent,
    "isAuth" => $isAuth
]);

print($page);