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
    $stmnt = $con -> prepare('SELECT * FROM Users WHERE login=:login');
    $stmnt -> execute(['login' => $user['login']]);

    if($stmnt -> rowCount() == 0){
        $errors['login'] = "Пользователь с данным login адресом не зарегистрирован";
    } else{
        $dbUser = $stmnt -> fetch();

        if(password_verify($user['password'], $dbUser['password'])){
            $_SESSION['user_id'] = $dbUser['id'];
            $_SESSION['login'] = $dbUser['login'];
            $_SESSION['profile_pic'] = $dbUser['profile_pic'];
            $isAuth = true;
            header("Location: popular.php");
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