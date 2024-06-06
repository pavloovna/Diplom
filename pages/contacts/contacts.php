<?php
include "../../path.php";
include  "../../app/controllers/users.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../app/PHPMailer/src/Exception.php';
require '../../app/PHPMailer/src/PHPMailer.php';
require '../../app/PHPMailer/src/SMTP.php';

/* include "app/controllers/posts.php"; */
//$post = selectPostFromPostsOnSingle('paintings', 'materials', 'canvases', 'sizes', 'topics', 'accesses', $_GET['post']);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Контакты</title>

    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Cтили-->
    <link rel='stylesheet' href='contacts-style.css'>
    <!--Шрифты-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

    <style>
        /* Стили для кнопки SweetAlert2 */
        .swal2-container button.swal2-confirm {
            border: 0;
            border-radius: 10px;
            background: initial;
            background-color: #f6f6f6;
            color: #606060;
            padding: 7px 67px;
            font-size: 1em;
            -webkit-box-shadow: 0px 12px 16px -16px rgba(34, 60, 80, 1);
            -moz-box-shadow: 0px 12px 16px -16px rgba(34, 60, 80, 1);
            box-shadow: 0px 12px 16px -16px rgba(34, 60, 80, 1);
            font-family: "Mulish", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;
            border: #f6f6f6;
        }

        .swal2-title {
            font-family: "Mulish", sans-serif;
            font-optical-sizing: auto;
            font-weight: 800;
            font-style: normal;
            color: #6d6d6d;
        }

        .swal2-text {
            font-family: "Mulish", sans-serif;
            font-optical-sizing: auto;
            font-weight: 800;
            font-style: normal;
            text-align: center; 
        }

        .swal2-popup {
            border-radius: 20px; 
        }
        
    </style>

</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!--Выплывающие окна-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Header -->
    <header class="container-xxl">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <div class="logo">
                        <img src="../../assets/images/logotype.png" alt="" onclick="window.location.href='<?php echo BASE_URL . 'pages/main/main.php'; ?>'">
                    </div>
                </div>
                <nav class="col-6">
                    <ul>
                        <li><a href="<?php echo BASE_URL . 'pages/main/main.php' ?>">Главная</a></li>
                        <li><a href="<?php echo BASE_URL . 'pages/catalog/catalog.php' ?>">Каталог</a></li>
                        <li><a href="<?php echo BASE_URL . 'pages/about_me/about_me.php' ?>">Обо мне</a></li>
                        <li><a href="<?php echo BASE_URL . 'pages/contacts/contacts.php' ?>">Контакты</a></li>
                    </ul>
                </nav>
                <div class="col-2">
                    <div class="icons">
                        <?php if (isset($_SESSION['Id'])) : ?>
                            <!-- Если пользователь авторизован -->
                            <a class="bascket" href="<?php echo BASE_URL . 'pages/basket/basket.php' ?>"><img src="../../assets/images/basket.png" alt=""></a>
                            <a href="#" class="user-dropdown">
                                <?php
                                if (isset($_SESSION['Name'])) {
                                    echo '<img src="../../assets/images/user.png" alt="">';
                                    echo $_SESSION['Name'];
                                } else {
                                    echo '<img src="../../assets/images/user.png" alt="" data-bs-toggle="modal" id="authorization">';
                                }
                                ?>
                            </a>
                            <ul class="submenu">
                                <?php
                                if (isset($_SESSION['Role']) && $_SESSION['Role']) : ?>
                                    <li> <a href="<?php echo BASE_URL . '/admin/posts/index-post.php'; ?>">Админка</a> </li>
                                <?php endif; ?>
                                <li> <a class="exit" href="<?php echo BASE_URL . 'logout.php'; ?>">Выход</a> </li>
                            </ul>
                        <?php else : ?>
                            <!-- Если пользователь не авторизован -->
                            <a href="#">
                                <img src="../../assets/images/user.png" alt="" data-bs-toggle="modal" id="authorization">
                            </a>
                        <?php endif; ?>
                        <div id="authModal" class="modal">
                            <div class="window">
                                <div class="form">
                                    <div class="close-span">
                                        <span class="close-auth">×</span>
                                    </div>
                                    <h2>Вход</h2>
                                    <!-- <div class="error">
                                        <p><?= $errMassage ?></p>
                                    </div> -->
                                    <form action="contacts.php" name="f1" method="post">
                                        <input type="email" placeholder="Почта" name="email" class="input">
                                        <input type="password" placeholder="Пароль" name="password" class="input">
                                        <div class="button-auth">
                                            <button type="submit" value="Войти" name="button_aut" class="input">Войти</button>
                                        </div>
                                        <div class="button-reg">
                                            <button href="registrations.php" type="submit" class="input">Регистрация</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script>
                            var authModal = document.getElementById('authModal');
                            var span = document.getElementsByClassName("close-auth")[0];
                            span.onclick = function() {
                                authModal.style.display = "none";
                            }
                            document.getElementById('authorization').addEventListener('click', function() {
                                authModal.style.display = "block";
                            });
                        </script>
                        <!-- Окно регистрации -->
                        <div id="regModal" class="modal">
                            <div class="window">
                                <div class="form">
                                    <div class="close-span">
                                        <span class="close-reg">×</span>
                                    </div>
                                    <h2>Регистрация</h2>
                                    <!-- <div class="error">
                                        <p><?= $errMassage ?></p>
                                    </div> -->
                                    <form action="contacts.php" name="f1" method="post">
                                        <input type="text" value="<?= $name ?>" placeholder="Имя" name="name" class="input">
                                        <input type="text" value="<?= $surname ?>" placeholder="Фамилия" name="surname" class="input">
                                        <input type="phone" value="<?= $phone ?>" placeholder="Мобильный телефон" name="phone" class="input">
                                        <input type="email" value="<?= $mail ?>" placeholder="Почта" name="email" class="input">
                                        <input type="email" placeholder="Подтвердите адрес электронной почты" name="email_replay" class="input">
                                        <input type="password" placeholder="Пароль" name="password" class="input">
                                        <input type="password" placeholder="Подтвердите пароль" name="password_replay" class="input">
                                        <div class="button-zareg">
                                            <button value="Войти" type="submit" class="input" name="sub_button">Зарегистрироваться</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script>
                            var regModal = document.getElementById('regModal');
                            var closeReg = document.getElementsByClassName("close-reg")[0];
                            closeReg.onclick = function() {
                                regModal.style.display = "none";
                            }
                            var regButton = document.querySelector(".button-reg button");
                            regButton.addEventListener('click', function(event) {
                                event.preventDefault();
                                authModal.style.display = "none";
                                regModal.style.display = "block";
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main -->
    <div class="container">
        <div class="content row">
            <div class="stock">
                <div class="image-stock">
                    <img src="../../assets/images/duo.png" alt="" class="images">
                </div>
            </div>
            <div class="feedback col-md-8 col-12">
                <div class="section feedback">
                    <form method="POST">
                        <div class="title_image">
                            <img src="../../assets/images/svauz.png" class="last" alt="">
                        </div>
                        <label for="editor" class="form-label">Имя</label>
                        <input type="text" name="name-feedback" class="input" placeholder="Введите имя">
                        <label for="editor" class="form-label">Почта</label>
                        <input type="email" placeholder="Введите адрес электронной почты" name="email-feedback" class="input">
                        <div class="col">
                            <label for="editor" class="form-label">Сообщение</label>
                            <textarea placeholder="Введите сообщение" name="message-feedback" class="form-control" id="content" rows="4"></textarea>
                        </div>
                        <div class="button-send">
                            <button value="Отправить" type="submit" class="input" name="send_button">Отправить</button>
                        </div>
                        <?php
                        if (isset($_POST['send_button'])) {
                            $name = $_POST['name-feedback'];
                            $email = $_POST['email-feedback'];
                            $message = $_POST['message-feedback'];
                            $mail = new PHPMailer(true);

                            try {
                                $mail->isSMTP();
                                $mail->Host       = 'smtp.gmail.com';
                                $mail->SMTPAuth   = true;
                                $mail->Username   = 'elvina.pavlovna@gmail.com';
                                $mail->Password   = 'wfwcdgjsdoqlzezj';
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                $mail->Port       = 465;

                                $mail->setFrom('elvina.pavlovna@gmail.com', 'Elvina');
                                $mail->addAddress('elvina.pavlovna@gmail.com', 'Elvina');

                                $mail->isHTML(true);
                                $mail->Subject = 'Message from Inna';
                                $mail->Body    = "Имя пользователя: $name<br>E-mail: $email<br>Сообщение: $message";

                                $mail->send();

                                // SweetAlert2 для вывода сообщения
                                echo "<script>
                                Swal.fire({
                                    title: 'Успешно!',
                                    text: 'Сообщение успешно отправлено!',                                    
                                    confirmButtonText: 'OK',
                                    confirmButtonClass: 'my-swal2-confirm'
                                });
                            </script>";
                            } catch (Exception $e) {
                                echo "<script>
                                Swal.fire({
                                    title: 'Ошибка!',
                                    text: 'Ошибка при отправке сообщения: " . $mail->ErrorInfo . "',
                                    confirmButtonText: 'OK',
                                    confirmButtonClass: 'my-swal2-confirm'
                                });
                            </script>";
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>
            <!-- /* ($email, $name) */ -->
            <div class="social col-md-4 col-12">
                <div class="section-social">
                    <form class="social-form row">
                        <img src="../../assets/images/tel.png" alt="" class="social-image col-md-2 col-12"></img>
                        <div class="social-labels col-md-8 col-12">
                            <label for="editor" class="soc-first">Телефон:</label>
                            <div> </div>
                            <label for="editor" class="soc">+79112749328</label>
                        </div>
                    </form>
                </div>
                <div class="section-social">
                    <form class="social-form row">
                        <img src="../../assets/images/mail.png" alt="" class="social-image col-md-2 col-12"></img>
                        <div class="social-labels col-md-8 col-12">
                            <label for="editor" class="soc-first">Почта:</label>
                            <div> </div>
                            <label for="editor" class="soc">inna.korshikova@mail.ru</label>
                        </div>
                    </form>
                </div>
                <div class="section-social">
                    <form class="social-form row">
                        <img src="../../assets/images/map.png" alt="" class="social-image col-md-2 col-12"></img>
                        <div class="social-labels col-md-8 col-12">
                            <label for="editor" class="soc-first">Местоположение:</label>
                            <div> </div>
                            <label for="editor" class="soc">г. Санкт-Петербург</label>
                        </div>
                    </form>
                </div>
                <div class="section-social">
                    <form class="social-form row">
                        <img src="../../assets/images/clock.png" alt="" class="social-image col-md-2 col-12"></img>
                        <div class="social-labels col-md-8 col-12">
                            <label for="editor" class="soc-first">Часы работы:</label>
                            <div> </div>
                            <label for="editor" class="soc">Ежедневно с 10:00 до 20:00</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="stock">
                <div class="image-stock">
                    <img src="../../assets/images/trip.png" alt="" class="images">
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include("../footer.php"); ?>
</body>

</html>