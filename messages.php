<?php
require_once('core/init.php');
require_once('core/helpers.php');

//переменная, отвечающая за id пользователя, диалог с которым открыт
//если страница была открыта через меню "мои сообщения", 
//а не через кнопку "отправить сообщение" на страницы пользователя,
//то значение равно 0
$rcpId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); //receipient id 

if(isset($_POST['active'])){
    $active = $_POST['active']; //переменная указывающая индекс открытого диалога в массиве $convos
} else{
    $active = 0;
}

//создание списка последних людей, с которыми общался пользователь
$stmnt = $con->prepare(
    'SELECT DISTINCT(receipient), u.login, u.profile_pic
    FROM Messages m
    JOIN Users u on u.id = receipient
    WHERE sender = :id
    LIMIT 0, 8'
);  
//ORDER BY date_created ASC
$stmnt->execute(['id' => $_SESSION['user_id']]);
$convos = $stmnt->fetchAll();


//если страница была открыта не через меню "мои сообщения"
if($rcpId != 0){ 
    $rcpIndex = search_arr($convos, 'receipient', $rcpId);
    //если аккаунт, с которого пользователей перешёл уже входит в диалоги (массив $convos)

    if($rcpIndex !== false){  //check if will work for users who do not have convos since ==0 and false might be the same thing
        var_dump('why');
        $rcp = $convos[$rcpIndex];
        unset($convos[$rcpIndex]);
        //ставим его на первое место 
        $convosTemp = [$rcp];
        $i = 1;
        foreach($convos as $convo){
            $convosTemp[$i] = $convo;
            $i++;
        }
        $convos = $convosTemp;
    } else{
        $stmnt = $con->prepare(
            'SELECT u.id, u.login, u.profile_pic
            FROM Users u 
            WHERE u.id = :rcpId'
        );  
        //ORDER BY date_created ASC
        $stmnt->execute(compact('rcpId'));
        $rcp = $stmnt->fetch();
        //dd($rcp);
        if(empty($convos)){
            $convos[0] = $rcp;
        }else{
            $convos = array_unshift($convos, $rcp);
        }
    }
}

//Извлечение сообщений активного диалога
$dialogues = [];
foreach($convos as $convo){
    $stmnt = $con->prepare(
        'SELECT *
        FROM Messages m
        JOIN Users u on u.id = receipient
        WHERE (sender = :id AND receipient = :rcp) AND (sender = :rcp AND receipient = :id)
        ORDER BY date_created ASC
        LIMIT 0, 20'
    );  
    $stmnt->execute([
        'id' => $_SESSION['user_id'],
        'rcp' => $convo['receipient']
    ]);
    $tempMessages = $stmnt->fetchAll();
    array_push($dialogues, $tempMessages);  
}
//dd($messages);

//Отправка сообщения
$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $_POST['text'] = trim($_POST['text']);
    $error = validateFilled($_POST['text']);
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && $error != NULL){
    $stmnt = $con->prepare(
        "INSERT INTO messages
        SET sender = :user_id, 
        receipient = :receipient,
        text = :text "
    );
    //dd($_POST);
    $stmnt->execute([
        'user_id' => $_SESSION['user_id'],
        'receipient' => $_POST['receipient'],
        'text' => $_POST['text'] 
    ]);
    
    header('Location: '.$_SERVER['HTTP_REFERER']);
}

$messagesContent = include_template("pages/messages-template.php", [
    'convos' => $convos,
    'active' => $active,
    'dialogues' => $dialogues,
    'error' => $error
]);

$page = include_template("layout.php",[
    'content' => $messagesContent,
    "pgTitle" => 'сообщения'
]);

print($page);

