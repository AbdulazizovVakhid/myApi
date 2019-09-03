<?php

    header("Content-type: application/json");
    // в этой функции мы генерируем уникальный api-ключ
    function generateRandomString($length = 25) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)))),1,$length);
    }
    // пробегаемся по полученному объекту и выводим строки которые нас интересуют
    function retrieve($yourArray){
        foreach ($yourArray as $row){
            echo json_encode('Your ID: ' . $row['id']);
            echo json_encode(' Your Api: ' . $row['numbApi']);
        }
    }
    // генерируем значение
    $data = generateRandomString();
    // в формат json его
    $myJson = json_encode($data);
    // подключаемся к базе
    $conn = new mysqli("localhost", "root", "root", "api");
    // обрабатываем ошибку если что-то пошло не так
    // и выводим саму ошибку
    if ($conn->connect_error) {
        die("Ошибка: не удается подключиться: " . $conn->connect_error);
    } 

    echo 'Подключение к базе данных';
    // генерируем уникальный id вдруг когда нибудь понадобится
    //$key = md5(uniqid(rand(),1));
    // записываем полученое значение в базу
    $result = $conn->query("INSERT INTO `myapi`(`numbApi`) VALUES ($myJson)");
    
    // получаем значение по id
    $displayInfo = $conn->query("SELECT * FROM myapi WHERE id = 33");
    // вывод значений хранящихся под определенным id
    $display = retrieve($displayInfo);

    $result->close();

    $conn->close();

?>
