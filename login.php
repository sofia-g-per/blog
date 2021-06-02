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
    $stmnt = $con -> prepare('SELECT * FROM Users WHERE email=:email');
    $stmnt -> execute(['email' => $user['email']]);

    if($stmnt -> rowCount() == 0){
        $errors['email'] = "Пользователь с данным email адресом не зарегистрирован";
    } else{
        $dbUser = $stmnt -> fetch();

        if(password_verify($user['password'], $dbUser['password'])){
            $_SESSION['user_id'] = $dbUser['id'];
            $_SESSION['login'] = $dbUser['login'];
            header("Location: popular.php");
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