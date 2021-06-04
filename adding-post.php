<?php
require_once("core/helpers.php");
require_once("core/init.php");

if(!isset($_POST['content_type'])){
    $_POST['content_type'] = "photo";
}


$errors = [];

$rules = [
    'photo-heading' => function(){
        return validateFilled('photo-heading');
    },
    'video-heading' => function(){
        return validateFilled('video-heading');
    },
    'quote-heading' => function(){
        return validateFilled('quote-heading');
    },
    'text-heading' => function(){
        return validateFilled('text-heading');
    },
    'link-heading' => function(){
        return validateFilled('link-heading');
    },
    "photo-url" => function(){
        if(!validateImage("userpic-file-photo") && empty($_POST["photo-url"])){
            return "Прикрепите фотографию в формате jpg, jpeg, или png";
        } elseif(!empty($_POST["photo-url"])){
            return validateURL('photo-url');
        }
    },
    "video-url" => function(){
        if(!empty($_POST['video-url'])){
            return check_youtube_url($_POST["video-url"]);
        } else{
            return "Это поле должно быть заполнено";
        }
    }, 
    "link-text" => function(){
        return validateURL("link-text");
    },
    "quote-text" => function(){
        return validateFilled("quote-text");
    },
    "quote-author" => function(){
        return validateFilled("quote-author");
    },
    "text-text" => function(){
        return validateFilled("text-text");
    },
    "userpic-file-photo" => function(){
        return validateImage("userpic-file-photo");
    }
];  

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //получение типа контента из тэга -heading
     /*$key = array_keys($_POST)[0];
     $_POST['content_type'] = explode("-", $key);
     $_POST['content_type'] = $_POST['content_type'][0];*/

    foreach($_POST as $key => $value){
        if (isset($rules[$key])){
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    }
    $errors = array_filter($errors);
}



if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)){
    //универсальный запрос 
    
    $stmnt = 'INSERT INTO Posts 
    SET title=:title, content=:content, author=:author, content_type=:content_type';
    
    //добавление поста в БД
    switch ($_POST['content_type']) {
        case "photo":
            $stmnt = $con->prepare($stmnt);
            //если есть только ссылка на фото
            if(isset($_POST['photo-url']) && empty($_FILES['userpic-file-photo']['name']) ){
                $stmnt ->execute([
                    'title' => $_POST[$_POST['content_type'].'-heading'],
                    'author' => $_SESSION['user_id'],
                    'content_type' => $_POST['content_type'],
                    'content' => $_POST['photo-url']
                ]);
            }
            //если есть только загруженное фото или загруженное фото и ссылка (->игнорируем ссылку)
            elseif(!empty($_FILES['userpic-file-photo']['name'])){
                $imageName = $_FILES['userpic-file-photo']['name'];
                $_POST['userpic-file-photo'] = 'uploads/'.uniqid().$imageName;
                move_uploaded_file($_FILES['userpic-file-photo']['tmp_name'], $_POST['userpic-file-photo']);
                $stmnt ->execute([
                    'title' => $_POST[$_POST['content_type'].'-heading'],
                    'author' => $_SESSION['user_id'],
                    'content_type' => $_POST['content_type'],
                    'content' => $_POST['userpic-file-photo']
                ]);
            } 
            break;

        case  "quote":
            
            $stmnt = $stmnt.', quote_author=:quote_author';
            $stmnt = $con->prepare($stmnt);
            $arr = [
                'title' => $_POST['quote-heading'],
                'content' => $_POST['quote-text'],
                'author' => $_SESSION['user_id'],
                'content_type' => $_POST['content_type'],
                'quote_author' => $_POST['quote-author'],   
            ];
            $stmnt ->execute($arr);
            break;

        case "video":
            $stmnt = $con->prepare($stmnt);

            $arr = [
                'title' => $_POST[$_POST['content_type'].'-heading'],
                'content' => $_POST[$_POST['content_type'].'-url'],
                'author' => $_SESSION['user_id'],
                'content_type' => $_POST['content_type']
            ];
    
            $stmnt->execute($arr);
            break;
        //для текста и ссылки
        default:
        $stmnt = $con->prepare($stmnt);

        $arr = [
            'title' => $_POST[$_POST['content_type'].'-heading'],
            'content' => $_POST[$_POST['content_type'].'-text'],
            'author' => $_SESSION['user_id'],
            'content_type' => $_POST['content_type']
        ];

        $stmnt->execute($arr);
        break;
    }
    //hashtags
    if (isset($_POST[$_POST['content_type'].'-tags'])){

        $postId = $con->lastInsertId();
        $tags = explode(" ", $_POST[$_POST['content_type'].'-tags']);

        foreach($tags as $tag){
            $stmnt = $con ->prepare("INSERT INTO hashtags SET
            post_id=:post_id,
            hashtag=:hashtag");

            $stmnt->execute([
                'post_id' => $postId,
                'hashtag' => $tag
            ]);
        }
    }
    header("Location: post-details.php?id=$postId");
} 

$addingPostcontent = include_template("pages/adding-post-template.php",[
    "errors" => $errors,
]);

$page = include_template("layout.php", [
    "content" => $addingPostcontent
]);

print($page);