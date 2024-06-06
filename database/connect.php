<?php

$driver = 'mysql';
$host = 'localhost';
$db_name = 'korshikova_elvina';
$db_user = 'korshikova_elvina';
$db_pass = 'Elvina2001';
$charset = "utf8mb4";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

try{
    $pdo = new PDO(
        "$driver:host=$host;dbname=$db_name;charset=$charset", $db_user, $db_pass, $options
    );
}
catch (PDOException $i){
    die("Ошибка подключения к базе данных");
}