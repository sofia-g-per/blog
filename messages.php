<?php
require_once('core/init.php');
require_once('core/helpers.php');

//переменная, отвечающая за id пользователя, диалог с которым открыт
//если страница была открыта через меню "мои сообщения", 
//а не через кнопку "отправить сообщение" на страницы пользователя,
//то значение равно 0
$rcpId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); //receipient id 

if(isset($_POST['active'])){
    $active = $_POST['active']; //переменная, указывающая индекс открытого диалога в массиве $convos
} else{
    $active = 0;
}

//fix dialogues ordered not by last message but by date created
//создание списка последних людей, с которыми общался пользователь
$stmnt = $con->prepare(
    'SELECT d.id as dialogue_id, d.user1, d.user2,
        (SELECT COUNT(*)
        FROM Messages m
        WHERE dialogue_id = d.id AND m.read = 0 AND sender != :id) unread_num
    FROM Dialogues d
    WHERE user1 = :id OR user2 =:id
    ORDER BY d.date_created DESC
    LIMIT 0, 8'
);  

$stmnt->execute(['id' => $_SESSION['user_id']]);
$convos = $stmnt->fetchAll();
//удаление информации о зарегистрированном пользователе и присваивание id другого пользователя под ключ id
foreach($convos as $key=>$row){
    if($row['user1'] != $_SESSION['user_id']){
        $id = $row['user1'];
    } else{
        $id= $row['user2'];
    }
    
    unset($convos[$key]['user1']);
    unset($convos[$key]['user2']);

    $stmnt = $con->prepare(
        "SELECT u.id, u.login, u.profile_pic
        FROM Users u
        WHERE id = :id"
    );
    $stmnt->execute(['id' => $id]);
    $temp = $stmnt->fetch();
    $convos[$key] = array_merge($convos[$key],$temp);
}

//Добавление в массив пользователя со страницы, которого был совершён переход на данную
//если страница была открыта не через меню "мои сообщения"
if($rcpId != 0){ 
    $rcpIndex = search_arr($convos, 'id', $rcpId);

    //если аккаунт, с которого пользователей перешёл уже входит в диалоги (массив $convos)
    if($rcpIndex !== false){ 
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
        $rcp['unread_num'] = 0;
        //dd($rcp);
        if(empty($convos)){
            $convos[0] = $rcp;
        }else{
            $convos = array_unshift($convos, $rcp);
        }
    }
}
//dd($convos);

//Не прочитанные сообщения в активном диалоге становятся прочитанными
$stmnt = $con->prepare(
    "UPDATE Messages m
    SET m.read = 1
    WHERE dialogue_id = :d_id AND m.read = 0"
);
$stmnt->execute(['d_id' => $convos[$active]['dialogue_id']]);

//Извлечение сообщений каждого из диалогов 
$dialogues = [];
foreach($convos as $convo){
    $stmnt = $con->prepare(
        'SELECT m.*, u.profile_pic, u.login
        FROM Messages m
        JOIN Users u on sender = u.id
        WHERE (sender = :id AND receipient = :rcp) OR (sender = :rcp AND receipient = :id)
        ORDER BY date_created ASC
        LIMIT 0, 20'
    );  
    $stmnt->execute([
        'id' => $_SESSION['user_id'],
        'rcp' => $convo['id']
    ]);
    $tempMessages = $stmnt->fetchAll();
    array_push($dialogues, $tempMessages);  
}
array_filter($dialogues);


//Отправка сообщения
$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $_POST['text'] = trim($_POST['text']);
    $error = validateFilled($_POST['text']);
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && $error != NULL){
    
    $message = $con->prepare(
        "INSERT INTO messages
        SET sender = :user_id, 
        receipient = :receipient,
        text = :text,
        dialogue_id = :d_id "
    );
    //Проерка есть ли у зарег пользователя диалог с этим пользователем
    $stmnt = $con->prepare(
        "SELECT id
        FROM dialogues
        WHERE (user1 = :user AND user2 = :rcp) OR (user1 = :rcp AND user2 = :user)"
    );
    $stmnt->execute([
        'user' => $_SESSION['user_id'],
        'rcp' => $_POST['receipient']
    ]);
    $d_id = $stmnt->fetch();

    if(Count($d_id) == 0){
        $stmnt = $con->prepare(
            "INSERT INTO dialogues 
            SET user1 = :user,
            user2 = :rcp"
        );
        $stmnt -> execute([
            'user' => $_SESSION['user_id'],
            'rcp' => $_POST['receipient']
        ]);
        $d_id = $con->lastInsertId();
    } else{
        $d_id = $d_id['id'];
    }
    
    $message->execute([
        'user_id' => $_SESSION['user_id'],
        'receipient' => $_POST['receipient'],
        'text' => $_POST['text'],
        'd_id' => $d_id
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

