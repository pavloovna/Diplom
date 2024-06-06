<?php
include '../database/function.php';

$errMassage = '';
//Код для формы регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sub_button'])) {
    $role = 0;
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $phone = trim($_POST['phone']);
    $mail = trim($_POST['email']);
    $mailR = trim($_POST['email_replay']);
    $pass = trim($_POST['password']);
    $passR = trim($_POST['password_replay']);

    if ($name === '' || $surname === '' || $phone === '' || $mail === '' || $pass === '') {
        $errMassage = "Не все поля заполнены!";
    } elseif (mb_strlen($pass, 'UTF8') < 4) {
        $errMassage = "Пароль должен быть не короче 4 символов!";
    } elseif ($mail !== $mailR) {
        $errMassage = "Логины в обоих полях должны совпадать!";
    } elseif ($pass !== $passR) {
        $errMassage = "Пароли в обоих полях должны совпадать!";
    } else {
        $existence = selectOne('users', ['email' => $mail]);
        if ($existence['email'] === $mail) {
            $errMassage = "Пользователь с такой почтой уже зарегистрирован!";
        } else {
            $password = password_hash($pass, PASSWORD_DEFAULT); //хеширование пароля 
            $post = [
                'Name' => $name,
                'Surname' => $surname,
                'Phone' => $phone,
                'Email' => $mail,
                'Password' => $password, //$password
                'Role' => $role,
            ];
            $id = insert('users', $post);
            $user = selectOne('users', ['Id' => $id]);
            $_SESSION['Id'] = $user['Id'];
            $_SESSION['Name'] = $user['Name'];
            $_SESSION['Role'] = $user['Role'];

            if ($_SESSION['Role']) {
                header('location: ' . BASE_URL . 'admin/posts/index-post.php');
            } else {
                header('location: ' . BASE_URL . 'pages/main/main.php');
            }
        }
    }
} else {
    $name = '';
    $surname = '';
    $phone = '';
    $mail = '';
}

//Код для формы авторизации
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button_aut'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === '' || $password === '') {
        $errMassage = "Не все поля заполнены!";
    } else {
        $existence = selectOne('users', ['email' => $email]);

        if ($existence && password_verify($password, $existence['Password'])) {
            $_SESSION['Id'] = $existence['Id'];
            $_SESSION['Name'] = $existence['Name'];
            $_SESSION['Role'] = $existence['Role'];

            if ($_SESSION['Role']) {
                header('location: ' . BASE_URL . 'admin/posts/index-post.php');
            } else {
                header('location: ' . BASE_URL . 'pages/main/main.php');
            }
        } else {
            $errMassage = "Почта или пароль введены неверно!";
        }
    }
} else {
    $email = '';
}
