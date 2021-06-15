<?php
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date): bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form(int $number, string $one, string $two, string $many): string
{
    $number = (int)$number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = [])
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        die('Файл с указанным шаблоном не найден. Проверь наличие файла: <span style="color:red; font-weight:bold; font-size: 30px">' . $name . '</span>');
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * Функция проверяет доступно ли видео по ссылке на youtube
 * @param string $url ссылка на видео
 *
 * @return string Ошибку если валидация не прошла
 */
function check_youtube_url($url)
{
    $id = extract_youtube_id($url);

    set_error_handler(function () {}, E_WARNING);
    $headers = get_headers('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=' . $id);
    restore_error_handler();

    if (!is_array($headers)) {
        return "Видео по такой ссылке не найдено. Проверьте ссылку на видео";
    }

    $err_flag = strpos($headers[0], '200') ? 200 : 404;

    if ($err_flag !== 200) {
        return "Видео по такой ссылке не найдено. Проверьте ссылку на видео";
    }

    return false;
}

/**
 * Возвращает код iframe для вставки youtube видео на страницу
 * @param string $youtube_url Ссылка на youtube видео
 * @return string
 */
function embed_youtube_video($youtube_url)
{
    $res = "";
    $id = extract_youtube_id($youtube_url);

    if ($id) {
        $src = "https://www.youtube.com/embed/" . $id;
        $res = '<iframe width="760" height="400" src="' . $src . '" frameborder="0"></iframe>';
    }

    return $res;
}

/**
 * Возвращает img-тег с обложкой видео для вставки на страницу
 * @param string $youtube_url Ссылка на youtube видео
 * @return string
 */
function embed_youtube_cover($youtube_url)
{
    $res = "";
    $id = extract_youtube_id($youtube_url);

    if ($id) {
        $src = sprintf("https://img.youtube.com/vi/%s/mqdefault.jpg", $id);
        $res = '<img alt="youtube cover" width="320" height="120" src="' . $src . '" />';
    }

    return $res;
}

/**
 * Извлекает из ссылки на youtube видео его уникальный ID
 * @param string $youtube_url Ссылка на youtube видео
 * @return array
 */
function extract_youtube_id($youtube_url)
{
    $id = false;

    $parts = parse_url($youtube_url);

    if ($parts) {
        if ($parts['path'] == '/watch') {
            parse_str($parts['query'], $vars);
            $id = $vars['v'] ?? null;
        } else {
            if ($parts['host'] == 'youtu.be') {
                $id = substr($parts['path'], 1);
            }
        }
    }

    return $id;
}

/**
 * @param $index
 * @return false|string
 */
function generate_random_date($index)
{
    $deltas = [['minutes' => 59], ['hours' => 23], ['days' => 6], ['weeks' => 4], ['months' => 11]];
    $dcnt = count($deltas);

    if ($index < 0) {
        $index = 0;
    }

    if ($index >= $dcnt) {
        $index = $dcnt - 1;
    }

    $delta = $deltas[$index];
    $timeval = rand(1, current($delta));
    $timename = key($delta);

    $ts = strtotime("$timeval $timename ago");
    $dt = date('Y-m-d H:i:s', $ts);

    return $dt;
}


//Функция проверяет заполненно ли поле
function validateFilled($name){
    if(empty($_POST[$name]) || ctype_space($_POST[$name])){
        return "Поле должно быть заполнено";
    }
}

//Функция проверяет соответствут ли email формату
function validateEmail($name) {
    if (!filter_input(INPUT_POST, $name, FILTER_VALIDATE_EMAIL)) {
        return "Введите корректный email";
    }
}

//Функция проверяет совпадают ли первый и второй введенные пароли в форме регистрации
function comparePasswords($password, $password_repeat) {
    if ($_POST[$password] != $_POST[$password_repeat]) {
        return "Пароли не совпадают";
    }
}

//Функция совпадает ли загруженное изображение требованиям
function validateImage($name) {
    if (!empty($_FILES[$name]['name'])) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $tmp_name = $_FILES[$name]['tmp_name'];
        $file_type = finfo_file($finfo, $tmp_name);
        //проверка совпадения формата изображения  с допустимыми(jpeg, png, jpg)
        if ($file_type !== "image/jpeg" && $file_type !== "image/png" && $file_type !== "image/jpg"){
            return false;
        }
    return true; //если поле не пустое и подходит по форматам
    } else {
        return false; //если поле пустое
    }
}

//Функция для сохранения данных из формы при её ошибочном заполнении
function getPostVal($name){
    return $_POST[$name] ?? "";
}

//
function validateURL($name){
    if(!empty($name)){
        if(!filter_input(INPUT_POST, $name, FILTER_VALIDATE_URL)){
            return "Введите корректную ссылку";
        }
    } else{
        return "Это поле должно быть заполнено";
    }
}

//функция для удобного выведения данных массива, перемнных и тд для разработчика
function dd($args){
    echo "<pre>";
    var_dump($args);
    echo "</pre>";
    die;
}

//для поиска в определенном ключе массива  типа [{"keyN"=>value}, {}, {}]
//если она находит элемент, то возвращает индекс массива, в котром он находится
function search_arr($arrname, $keyN, $value){

    foreach($arrname as $key=>$arr){
        if($arr[$keyN] == $value){
            return $key;
        }else{
            return false;
        }
    }
}

//array_unshift для массивов типа [{},{},{}]


//функция возвращает надпись о том, сколько времени назад была данная дата
function ago($date){
    //эквиваленты в секундах
    $minute = 60;
    $hour = 3600;
    $day = 86400;
    $week = 86400 * 7;
    $month = 31536000 / 12; //количество секунд в год деленное на 12
    $year = 31536000;

    $dif = time() - strtotime($date); //разница во времени в секундах

    //меньше минуты
    if($dif < $minute){
        return "совсем недавно";

    //меньше часа (но больше минуты)
    } elseif($dif < $hour){
        $dif = intval($dif/$minute);
        if($dif == 1){
            return "минуту";
        } elseif($dif < 5){
            return $dif." минуты";
        } else{
            return $dif." минут";
        }   

    //меньше дня (несколько часов назад)
    } elseif($dif < $day){
        $dif = intval($dif/$hour);
        if($dif == 1){
            return "час";
        } elseif($dif < 5){
            return $dif." часа";
        } else{
            return $dif." часов";
        }   

    //меньше недели (несколько дней назад)
    } elseif($dif < $week){
        $dif = intval($dif/$day);
        if($dif == 1){
            return "1 день";
        } elseif($dif < 5){
            return $dif." дня";
        } else{
            return $dif." дней";
        }   
    
    //меньше месяца (несколько недель назад)
    } elseif($dif < $month){
        $dif = intval($dif/$week);
        if($dif == 1){
            return "неделю";
        } elseif($dif < 5){
            return $dif." недели";
        } else{
            return $dif." недель";
        }   
    
    //меньше года (несколько месяцев назад)
    } elseif($dif < $year){
        $dif = intval($dif/$month);
        if($dif == 1){
            return "месяц";
        } elseif($dif < 5){
            return $dif." месяца";
        } else{
            return $dif." месяцев";
        }   

    //несколько лет назад 
    } else{
        $dif = intval($dif/$year);
        if($dif == 1){
            return "год";
        }elseif($dif < 5){
            return $dif." года";
        } else{
            return $dif." лет";
        }   
    }
    
}