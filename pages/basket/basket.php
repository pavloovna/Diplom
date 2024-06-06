<?php
include "../../path.php";
include "../../app/controllers/users.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../app/PHPMailer/src/Exception.php';
require '../../app/PHPMailer/src/PHPMailer.php';
require '../../app/PHPMailer/src/SMTP.php';


if (!isset($_SESSION['Id'])) {
    echo 'НУ КУДА ТЫ ЛЕЗЕШЬ, АВТОРИЗУЙСЯ СНАЧАЛА!!!!';
    exit;
}

/* $post = selectPostFromPostsOnSingle('paintings', 'materials', 'canvases', 'sizes', 'topics', 'accesses', $_GET['post']); */
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Корзина</title>
    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Cтили-->
    <link rel='stylesheet' href='basket.css'>
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
                            <a href="#">
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
                                if (isset($_SESSION['Role']) && $_SESSION['Role']) :
                                ?>
                                    <li> <a href="<?php echo BASE_URL . '/admin/posts/index-post.php'; ?>">Админка</a> </li>
                                <?php endif; ?>
                                <li> <a href="<?php echo BASE_URL . 'logout.php'; ?>">Выход</a> </li>
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
                                    <form action="basket.php" name="f1" method="post">
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
                                    <form action="basket.php" name="f1" method="post">
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













    <main class="container">
        <div class="content">
            <!-- <div class="title_image">
                <img src="../../assets/images/bascet.png" class="material" alt="">
            </div> -->

            <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            ?>
                <div class="cart-items col-12 row">
                    <?php foreach ($_SESSION['cart'] as $key => $item) : ?>
                        <div class="post col-6">
                            <div class="row  ">
                                <div class="image col-6">
                                    <img src="<?= BASE_URL . 'assets/images/posts/' . $item['Picture'] ?>" alt="<?= $item['Title'] ?>" class="img d-block">
                                </div>
                                <div class="information col-5">
                                    <div class="post_text  ">
                                        <i class="far fa-title ">Название:</i>
                                        <i class="far fa-description col" name="title"><?= $item['Title']; ?></i>
                                    </div>
                                    <div class="post_text  ">
                                        <i class="far fa-title ">Материал:</i>
                                        <i class="far fa-description col" name="material"><?= $item['TitleMaterial']; ?></i>
                                    </div>
                                    <div class="post_text  ">
                                        <i class="far fa-title ">Размер:</i>
                                        <i class="far fa-description col" name="size"><?= $item['TitleSize']; ?></i>
                                    </div>
                                    <div class="post_price  ">
                                        <i class="far fa-title ">Стоимость картины:</i>
                                        <i class="far fa-price " name="price"><?= mb_substr($item['Price'], 0, 20, 'UTF-8') . '₽' ?></i>
                                    </div>
                                </div>

                            </div>
                            <div class="delete col-1">
                                <button data-item-id="<?= $key; ?>" class="remove-from-cart">×</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Форма для отправки заказа -->
                <div class="order-form">
                    <div class="title_image">
                        <img src="../../assets/images/order.png" class="order" alt="">
                    </div>
                    <form method="POST" action="basket.php">
                        <div class="form-group">
                            <label class="form-label" for="name">Имя:</label>
                            <input type="text" name="name" id="name" placeholder="Введите имя" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email:</label>
                            <input type="email" name="email" id="email" placeholder="Введите адрес электронной почты" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Телефон:</label>
                            <input type="tel" name="phone" id="phone" placeholder="Введите номер телефона" class="form-control" required>
                        </div>
                        <input type="hidden" name="title" id="title" value="">
                        <input type="hidden" name="price" id="price" value="">
                        <div class="button-send">
                            <button value="Отправить" type="submit" class="btn btn-primary" name="send_button">Отправить</button>
                        </div>

                        <?php
                        if (isset($_POST['send_button'])) {
                            $name = $_POST['name'];
                            $email = $_POST['email'];
                            $phone = $_POST['phone'];
                            $title = $_POST['title'];
                            $price = $_POST['price'];
                            $mail = new PHPMailer(true);

                            try {
                                $mail->isSMTP();
                                $mail->Host       = 'smtp.gmail.com';
                                $mail->SMTPAuth   = true;
                                $mail->Username   = 'elvina.pavlovna@gmail.com';
                                $mail->Password   = 'wfwcdgjsdoqlzezj';
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                $mail->Port       = 465;

                                $mail->setFrom($email, $name);
                                $mail->addAddress('elvina.pavlovna@gmail.com', 'Elvina');

                                $mail->isHTML(true);
                                $mail->Subject = 'Message from Inna';
                                $mail->Body    = "Пользователь $name хочет приобрести 
                                картину под названием: $title
                                <br>По цене: $price

                                <br>E-mail: $email
                                <br>Телефон: $phone";

                                $mail->send();

                                // SweetAlert2 для вывода сообщения
                                echo "<script>
                                Swal.fire({
                                    title: 'Заявка отправлена!',
                                    text: 'С вами свяжутся в течении суток',                                    
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

                <script>
                    const removeButtons = document.querySelectorAll('.remove-from-cart');

                    removeButtons.forEach(button => {
                        button.addEventListener('click', () => {
                            const itemId = button.dataset.itemId;

                            fetch('remove_from_cart.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: 'item_id=' + itemId
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        button.closest('.post').remove(); // Удаляем элемент из DOM
                                        alert('Товар удален из корзины!');
                                    } else {
                                        alert('Ошибка удаления товара!');
                                    }
                                })
                                .catch(error => {
                                    console.error('Ошибка отправки запроса:', error);
                                });
                        });
                        // Заполнение скрытых полей
                        const cartItems = document.querySelectorAll('.post');
                        cartItems.forEach(item => {
                            const title = item.querySelector('.far.fa-description.col').textContent;
                            const price = item.querySelector('.far.fa-price').textContent.replace('₽', '');

                            // Устанавливаем значение, а не добавляем
                            document.getElementById('title').value = title;
                            document.getElementById('price').value = price;
                        });
                    });
                </script>
            <?php
            } else {
            ?>
                <div class="empty">
                    <img src="../../assets/images/cart.png" alt="" class="cart" style="width: 367px;">
                </div>
                <p style="font-size: 30px; text-align: center; color: #9e9e9e; font-weight: 800;">Ваша корзина пуста</p>
            <?php
            }
            ?>
        </div>
    </main>

    <?php include("../footer.php"); ?>

    <script>
        const cartItems = document.querySelectorAll('.cart-items .post');
        const footer = document.querySelector('footer');

        if (cartItems.length > 0) {
            footer.classList.add('footer');
        } else {
            footer.classList.add('footer-empty');
        }
    </script>
</body>

</html>