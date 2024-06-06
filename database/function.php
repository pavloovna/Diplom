<?php

require('connect.php');

function tt($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}

//Проверка выполнения запроса к БД
function dbCheckError($query)
{
    $errInfo = $query->errorInfo();
    if ($errInfo[0] !== PDO::ERR_NONE) {
        echo $errInfo[2];
        exit();
    }
    return true;
}

//Запрос на получение данных с одной таблицы
function selectAll($table, $params = [])
{
    global $pdo;
    $sql = "SELECT * FROM $table";
    if (!empty($params)) {
        $i = 0;
        foreach ($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key=$value";
            } else {
                $sql = $sql . " AND $key=$value";
            }
            $i++;
        }
    }

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

//Запрос на получение одной строки с выбранной таблицы 
function selectOne($table, $params = [])
{
    global $pdo;
    $sql = "SELECT * FROM $table";
    if (!empty($params)) {
        $i = 0;
        foreach ($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key=$value";
            } else {
                $sql = $sql . " AND $key=$value";
            }
            $i++;
        }
    }
    $sql = $sql . " LIMIT 1";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch();
}

// Добавление записи
function insert($table, $params) {
    global $pdo;
    $keys = array_keys($params); // Получаем ключи массива $params
    $placeholders = implode(',', array_fill(0, count($keys), '?')); 

    $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES ($placeholders)";

    $query = $pdo->prepare($sql);
    $query->execute(array_values($params)); 
    dbCheckError($query);
    return $pdo->lastInsertId();
}

// Обновление строки в таблице
function update($table, $id, $params) {
    global $pdo;
    $set_parts = [];
    foreach ($params as $key => $value) {
        $set_parts[] = "$key = ?"; // Добавляем "?" для подстановки значения
    }
    $set_clause = implode(', ', $set_parts);

    $sql = "UPDATE $table SET $set_clause WHERE Id = ?";

    $query = $pdo->prepare($sql);
    $values = array_values($params); 
    $values[] = $id; 
    $query->execute($values); 
    dbCheckError($query);
}

// Удаление строки из таблицы
function delete($table, $id)
{
    global $pdo;
    $sql = "DELETE FROM $table WHERE Id = ?";
    $query = $pdo->prepare($sql);
    $query->execute([$id]); 
    dbCheckError($query);
}

// Выборка записей (posts) с айдишниками в админку
function selectAllFromPostsWithId($table1, $table2, $table3,$table4,$table5,$table6){
    global $pdo;
    $sql = "
    SELECT 
    paintings.Id,
    paintings.Picture,
    paintings.PictureSecond,
    paintings.PictureThird,
    paintings.PictureFourth,
    paintings.Title,
    paintings.Description,
    materials.TitleMaterial,
    canvases.TitleCanvas,
    sizes.TitleSize,
    topics.TitleTopic,
    accesses.TitleAccess,
    paintings.Price
    FROM $table1 AS paintings 
    JOIN $table2 AS materials ON paintings.MaterialId = materials.IdMaterial
    JOIN $table3 AS canvases ON paintings.CanvasId = canvases.IdCanvas
    JOIN $table4 AS sizes ON paintings.SizeId = sizes.IdSize
    JOIN $table5 AS topics ON paintings.TopicId = topics.IdTopic
    JOIN $table6 AS accesses ON paintings.AccessId = accesses.IdAccess
    ";

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll(); 
}

//Поиск по загаловкам и ценам //ДОБИТЬ ПОЛНЫЙ ПОИСК
function searchInTitleAndPrice($text, $table1, $table2, $table3,$table4,$table5,$table6){
    $text = trim(strip_tags(stripcslashes(htmlspecialchars($text))));
    global $pdo;
    $sql = "
    SELECT 
    paintings.Id,
    paintings.Picture,
    paintings.PictureSecond,
    paintings.PictureThird,
    paintings.PictureFourth,
    paintings.Title,
    paintings.Description,
    materials.TitleMaterial,
    canvases.TitleCanvas,
    sizes.TitleSize,
    topics.TitleTopic,
    accesses.TitleAccess,
    paintings.Price
    FROM $table1 AS paintings 
    JOIN $table2 AS materials ON paintings.MaterialId = materials.IdMaterial
    JOIN $table3 AS canvases ON paintings.CanvasId = canvases.IdCanvas
    JOIN $table4 AS sizes ON paintings.SizeId = sizes.IdSize
    JOIN $table5 AS topics ON paintings.TopicId = topics.IdTopic
    JOIN $table6 AS accesses ON paintings.AccessId = accesses.IdAccess
    AND paintings.Title LIKE '%$text%' OR paintings.Price LIKE '%$text%'";

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll(); 
}

//Выборка записи для single
function selectPostFromPostsOnSingle($table1, $table2, $table3,$table4,$table5,$table6,$id){
    global $pdo;
    $sql = "
    SELECT 
    paintings.Id,
    paintings.Picture,
    paintings.PictureSecond,
    paintings.PictureThird,
    paintings.PictureFourth,
    paintings.Title,
    paintings.Description,
    materials.TitleMaterial,
    canvases.TitleCanvas,
    sizes.TitleSize,
    topics.TitleTopic,
    accesses.TitleAccess,
    paintings.Price
    FROM $table1 AS paintings 
    JOIN $table2 AS materials ON paintings.MaterialId = materials.IdMaterial
    JOIN $table3 AS canvases ON paintings.CanvasId = canvases.IdCanvas
    JOIN $table4 AS sizes ON paintings.SizeId = sizes.IdSize
    JOIN $table5 AS topics ON paintings.TopicId = topics.IdTopic
    JOIN $table6 AS accesses ON paintings.AccessId = accesses.IdAccess
    WHERE paintings.Id = $id
    ";

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch(); 
}