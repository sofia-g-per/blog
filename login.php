<?php
require_once("core/helpers.php");
require_once("core/init.php");

$errors = [];
$rules = [
    'email' => function(){
        return validateEmail('email');
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
        WHERE subscriber = u.id) subs, 
        (SELECT GROUP_CONCAT(l.post SEPARATOR ' ')
        FROM Likes l
        WHERE l.user = u.id) likes
        
        FROM Users u 
        WHERE email=:email"
    );
    $stmnt -> execute(['email' => $user['email']]);

    if($stmnt -> rowCount() == 0){
        $errors['email'] = "Пользователь с данным email адресом не зарегистрирован";
    } else{
        $dbUser = $stmnt -> fetch();

        if(password_verify($user['password'], $dbUser['password'])){
            $_SESSION['user_id'] = $dbUser['id'];
            $_SESSION['login'] = $dbUser['login'];
            $_SESSION['profile_pic'] = $dbUser['profile_pic'];
            $_SESSION['subs'] = explode(' ', $dbUser['subs']); //массив id пользователей, на которых подписан зарег пользователей
            $_SESSION['likes'] = explode(' ', $dbUser['likes']); //массив id постов, которые лайкнул зарег пользователей
            header("Location: popular.php?page=0&par=views&con=default");
        }
        else{
            //если неверный пароль
            $errors['password'] = "Введите корректные данные";
        }
    }
}

$loginContent = include_template("pages/login-template.php", [
    "errors" => $errors
]);

$page = include_template("login-layout.php", [
    "content" => $loginContent
]);

print($page);