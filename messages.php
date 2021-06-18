<?php
require_once('core/init.php');
require_once('core/helpers.php');

//переменная, отвечающая за id пользователя, диалог с которым открыт
//если страница была открыта через меню "мои сообщения", 
//а не через кнопку "отправить сообщение" на страницы пользователя,
//то значение равно 0
$rcpId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); //receipient id 

$active = filter_input(INPUT_GET, 'active', FILTER_SANITIZE_NUMBER_INT); //id of active dialogue in convos 

if(isset($_POST['active'])){
    $active = $_POST['active']; //переменная, указывающая индекс открытого диалога в массиве $convos
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
//dd($convos);
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
//dd($convos);

$dialogueExists = true; //обозначает существует ли в БД диалог с этим пользователем (используется при отправки сообщения)

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
        $dialogueExists = false; //обозначает существует ли в БД диалог с этим пользователем (используется при отправки сообщения)
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
            array_unshift($convos, []);
            $convos[0] = $rcp + $convos[0];
        }
    }

    //если страница открывается с профиля другого пользователя(нажатием кнопки сообщение),
    //то активный становится диалог с этим пользователем
    if($active === NULL){
        $active = 0;
    }
}
//dd($convos);

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

//если на экране отображается диалог 

if($active !== NULL && !empty($dialogues[$active])){

    $unread = search_arr($dialogues[$active], "read", 0); //индекс первого не прочитанного сообщения в мссиве диалога с данным пользователем
    
    //если в активном диалоге есть непрочитанные сообщения не от самого пользователя,
    //они становятся прочитанными
    if($unread !==NULL && $dialogues[$active][$unread]['sender']!= $_SESSION['user_id']){
        //подсчёт количества непрочитанных сообщений от данного пользователя
        $stmnt = $con->prepare(
            "SELECT COUNT(*) as num
            FROM Messages m
            WHERE dialogue_id = :d_id  AND m.read = 0 AND m.sender != :id;"
        );
        $stmnt->execute([
            'id' => $_SESSION['user_id'],
            'd_id' => $convos[$active]['dialogue_id']
        ]);
        $num = $stmnt->fetch();
        $num = $num['num'];
        $_SESSION['unread_num'] -= $num;

        $stmnt = $con->prepare(
            "UPDATE Messages m
            SET m.read = 1
            WHERE dialogue_id = :d_id AND m.read = 0"
        );
        $stmnt->execute(['d_id' => $convos[$active]['dialogue_id']]);

        
    }
}

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
    //Если у пользователя нет диалога с данным аккаунтом, то он создаётся
    if(!$dialogueExists){
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
        $d_id = $convos[$active]['dialogue_id'];
    }
    
    $message->execute([
        'user_id' => $_SESSION['user_id'],
        'receipient' => $_POST['receipient'],
        'text' => $_POST['text'],
        'd_id' => $d_id
    ]);
    
    header('Location: '.$_SERVER['HTTP_REFERER']);
}

//Формирование страницы
$messagesContent = include_template("pages/messages-template.php", [
    'convos' => $convos,
    'active' => $active,
    'rcpId'=> $rcpId,
    'dialogues' => $dialogues,
    'error' => $error
]);

$page = include_template("layout.php",[
    'content' => $messagesContent,
    "pgTitle" => 'сообщения'
]);

print($page);

