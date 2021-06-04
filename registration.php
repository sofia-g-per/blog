<?php
require_once("core/init.php");
require_once("core/helpers.php");

$errors = [];
$rules = [
    'email' => function() {
        return validateEmail('email');
    },
    'login' =>  function() {
        return validateFilled('login');
    },
    'password' => function() {
        return validateFilled('password');
    },
    'password-repeat' => function() {
        return comparePasswords('password', 'password-repeat');
    },
    'userpic-file' =>function(){
        //проверка загружено ли фото и в правильном ли формате
        if(!validateImage('userpic-file')){
            return "Загрузите картинку в формате jpg, jpeg или png";
        }
    }
];



$user = $_POST;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    //проверка полей на ошибки
    foreach($user as $key=> $value ){
        if(isset($rules[$key])){
            $errors[$key] = $rules[$key]();
        };
    }    
}
$errors = array_filter($errors);


//если форма отправлена без ошибок
if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)){
    $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

    //проверка не зарегистрирован ли пользователь с данным email
    $stmnt = $con-> prepare('SELECT * FROM Users WHERE email=:email');
    $stmnt -> execute(['email' => $user["email"]]);
    if ($stmnt -> rowCount() != 0){
        $errors['email'] = 'Пользователь с этим email адресом уже зарегистрирован';
    }
    else{
        //подготовка изображения для загрузки в БД
        
        $file_name = $_FILES['userpic-file']['name'];
        $user['userpic-file'] = 'uploads/'.uniqid().$file_name; 
        move_uploaded_file($_FILES['userpic-file']['tmp_name'], $user['userpic-file']);
        $stmnt = $con -> prepare('INSERT INTO Users 
        SET email=:email, login=:login, password=:password, profile_pic=:profile_pic');
        $stmnt -> execute([
            'email' => $user['email'],
            'login' => $user['login'],
            'password' => $user['password'],
            'profile_pic' => $user['userpic-file']
        ]);
        header("Location: login.php");
    }
}


$registrationContent = include_template("pages/registration-template.php", [
    "errors" => $errors
]);

$page = include_template("reg-layout.php", [
    "content" => $registrationContent
    
]);

print($page);
