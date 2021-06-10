<?php
require_once('core/init.php');
require_once('core/helpers.php');

$rcp = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); 
//создание списка всех пользователей, с которыми зарегистрированный переписывался
$stmnt = $con->prepare(
    'SELECT DISTINCT(reciepient), date_created, message  
    FROM Messages
    WHERE sender =: id
    ORDER BY date_created ASC
    LIMIT 0, 8'
);
$stmnt->execute(['id' => $_SESSION['user_id']]);
$
dd();