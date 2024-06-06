<?php
include '../../path.php';
include "../../app/controllers/users.php";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Обо мне</title>
    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Cтили-->
    <link rel='stylesheet' href='about_me-style.css'>
    <!--Шрифты-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
                                    <form action="about_me.php" name="f1" method="post">
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
                                    <form action="about_me.php" name="f1" method="post">
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
    
    <!-- Блок main -->
    <div class="container">
        <div class="content row">
            <div class="portrait-content col-md-3 col-12">
                <div class="section portrait">
                    <img src="../../assets/images/portrait.jpeg" class="img">
                </div>
            </div>
            <div class="mains-content col-md-9 col-12">
                <div class="section main">
                    <div class="title_image">
                        <img src="../../assets/images/bio.png" class="last" alt="">
                    </div>
                    <p>
                        Инна, уроженка Витебска – города, подарившего миру гениального Марка Шагала, - с детства увлекалась искусством. Ее талант раскрывался под чутким руководством преподавателей детской художественной школы Витебска, а затем на вечерних рисовальных курсах Академии художеств имени Репина в Санкт-Петербурге.
                    </p>
                    <p>
                        Помимо академического образования, Инна постигала мастерство у признанных художников: московского мариниста Дмитрия Розы и петербургского живописца Вугара Мамедова. Ее работы, полные жизненной энергии и глубокой чувственности, представлялись на многочисленных выставках в Санкт-Петербурге.
                    </p>
                    <p>
                        Творения Инны нашли отклик у ценителей искусства по всему миру, украшая частные коллекции в России, Беларуси, Абхазии, Германии, Швеции, США, Кипре и Израиле.
                    </p>
                    <p>
                        Используя акварель на бумаге и масло на холсте, Инна мастерски воплощает свои идеи в разных жанрах, но ее сердце отдает предпочтение импрессионизму и реализму. В ее работах ярко звучит любовь к жизни, красоте окружающего мира и неисчерпаемому источнику вдохновения.
                    </p>
                </div>
            </div>
        </div>
        <div class="content row">
            <div class="photo-content col-md-2 col-12">
                <div class="section photo">
                    <img src="../../assets/images/draw.jpg" class="img">
                </div>
            </div>
            <div class="photo-content col-md-2 col-12">
                <div class="section photo">
                    <img src="../../assets/images/draw6.jpeg" class="img">
                </div>
            </div>
            <div class="photo-content col-md-2 col-12">
                <div class="section photo">
                    <img src="../../assets/images/draw5.jpeg" class="img">
                </div>
            </div>
            <div class="photo-content col-md-2 col-12">
                <div class="section photo">
                    <img src="../../assets/images/draw2.jpeg" class="img">
                </div>
            </div>
            <div class="photo-content col-md-2 col-12">
                <div class="section photo">
                    <img src="../../assets/images/draw3.jpeg" class="img">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include("../footer.php"); ?>
</body>

</html>