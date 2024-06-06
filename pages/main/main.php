<?php
include '../../path.php';
include "../../app/controllers/users.php";
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Главная</title>
    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Cтили-->
    <link rel='stylesheet' href='main-style.css'>
    <!--Шрифты-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

    <!-- Remixicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" crossorigin="">

    <!-- Swiper css -->
    <link rel="stylesheet" href="swiper-bundle.min.css">
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
                                <?php if (isset($_SESSION['Role']) && $_SESSION['Role']) : ?>
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


                                    <div class="error">
                                        <?php if (count($errMassage) > 0) : ?>
                                            <?php foreach ($errMassage as $error) : ?>
                                                <div><?= $error; ?></div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>


                                    <form <?php if (count($errMassage) < 0) : ?> action="main.php" <?php else : ?> action="#authModal" <?php endif; ?> name="f1" method="post">

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


                                    <div class="error">
                                        <!-- <p><?= $errMassage ?></p> -->
                                        <!-- <?php if (is_array($errMassage)) : ?>
                                            <p><?= implode('<br>', $errMassage) ?></p>
                                        <?php else : ?>
                                            <p><?= $errMassage ?></p>
                                        <?php endif; ?> -->
                                    </div>


                                    <form action="main.php" name="f1" method="post">
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
    <div class="container">
        <div class="content">
            <div class="all_cards">
                <div class="last_paint">
                    <div class="title_image">
                        <img src="../../assets/images/last.png" class="last" alt="">
                    </div>
                </div>

                <section class="container-card">
                    <div class="card_container swiper">
                        <div class="card_content">
                            <div class="swiper-wrapper">
                                <article class="card_article swiper-slide">
                                    <div class="card_image">
                                        <img src="../../assets/images/1.png" class="card_img" alt="">
                                    </div>
                                    <div class="card_data">
                                        <img src="../../assets/images/blur1.png" class="blur" alt="">
                                        <div class="card_text">
                                            <h3 class="card_name">Золотой час</h3>
                                            <p class="card_description">
                                                Безмятежную красота парусника, плывущего по...
                                            </p>
                                        </div>
                                    </div>
                                </article>

                                <article class="card_article swiper-slide">
                                    <div class="card_image">
                                        <img src="../../assets/images/2.png" class="card_img" alt="">
                                    </div>
                                    <div class="card_data">
                                        <img src="../../assets/images/blur2.png" class="blur" alt="">
                                        <div class="card_text">
                                            <h3 class="card_name">Прощальный свет</h3>
                                            <p class="card_description">
                                                Парусник, стоящий на якоре в спокойных водах на закате
                                            </p>
                                        </div>
                                    </div>
                                </article>

                                <article class="card_article swiper-slide">
                                    <div class="card_image">
                                        <img src="../../assets/images/3.png" class="card_img" alt="">
                                    </div>
                                    <div class="card_data">
                                        <img src="../../assets/images/blur3.png" class="blur" alt="">
                                        <div class="card_text">
                                            <h3 class="card_name">Встречая рассвет</h3>
                                            <p class="card_description">
                                                Солнце, только начинающее свой путь по небосклону...
                                            </p>
                                        </div>
                                    </div>
                                </article>

                                <article class="card_article swiper-slide">
                                    <div class="card_image">
                                        <img src="../../assets/images/4.png" class="card_img" alt="">
                                    </div>
                                    <div class="card_data">
                                        <img src="../../assets/images/blur4.png" class="blur" alt="">
                                        <div class="card_text">
                                            <h3 class="card_name">Море в тумане</h3>
                                            <p class="card_description">
                                                Небо окрашено в светло-серые тона, а море...
                                            </p>
                                        </div>
                                    </div>
                                </article>

                                <article class="card_article swiper-slide">
                                    <div class="card_image">
                                        <img src="../../assets/images/5.png" class="card_img" alt="">
                                    </div>
                                    <div class="card_data">
                                        <img src="../../assets/images/blur5.png" class="blur" alt="">
                                        <div class="card_text">
                                            <h3 class="card_name">Морской воин</h3>
                                            <p class="card_description">
                                                Парусник, бороздящий волны в вечернем свете...
                                            </p>
                                        </div>
                                    </div>
                                </article>

                                <article class="card_article swiper-slide">
                                    <div class="card_image">
                                        <img src="../../assets/images/6.png" class="card_img" alt="">
                                    </div>
                                    <div class="card_data">
                                        <img src="../../assets/images/blur6.png" class="blur" alt="">
                                        <div class="card_text">
                                            <h3 class="card_name">Нежность</h3>
                                            <p class="card_description">
                                                Цветы в тонких оттенках розового и кремового цвета...
                                            </p>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="pagination">
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                </section>
            </div>
        </div>

        <div class="all_cards">
            <div class="last_paint">
                <div class="title_image">
                    <img src="../../assets/images/material.png" class="material" alt="">
                </div>
            </div>
            <div class="row">
                <div class="materials col-6">
                    <input type="hidden" name="material" value="1" id="material-maslo">
                    <div class="image-maslo ">
                        <img src="../../assets/images/oil.png" alt="" class="images oil">
                        <div class="card_text">
                            <h3 class="card_name">Масло</h3>
                        </div>
                    </div>

                    <div class="image-aqva">
                        <input type="hidden" name="material" value="2" id="material-aqva">
                        <img src="../../assets/images/watercolour.png" alt="" class="images watercolour">
                        <div class="card_text">
                            <h3 class="card_name">Акварель</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="all_cards">
            <div class="last_paint">
                <div class="title_image">
                    <img src="../../assets/images/topic.png" class="topic" alt="">
                </div>
            </div>
            <div class="row">
                <div class="topics col">
                    <div class="topic-all ">
                        <div class="button-sort сol-1">
                            <button type="submit" value="Применить" name="button_7" class="input-topic">Цветы</button>
                        </div>
                        <div class="button-sort сol-1">
                            <button type="submit" value="Применить" name="button_1" class="input-topic">Природные пейзажи</button>
                        </div>
                        <div class="button-sort сol-1">
                            <button type="submit" value="Применить" name="button_2" class="input-topic">Морские пейзажи</button>
                        </div>
                        <div class="button-sort сol-1">
                            <button type="submit" value="Применить" name="button_3" class="input-topic">Реки и озера</button>
                        </div>
                        <div class="button-sort сol-1">
                            <button type="submit" value="Применить" name="button_4" class="input-topic">Горные пейзажи</button>
                        </div>
                        <div class="button-sort сol-1">
                            <button type="submit" value="Применить" name="button_5" class="input-topic">Лесные пейзажи</button>
                        </div>
                        <div class="button-sort сol-1">
                            <button type="submit" value="Применить" name="button_6" class="input-topic">Городские пейзажи</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="all_cards">
            <div class="last_paint">
                <div class="title_image">
                    <img src="../../assets/images/geograf.png" class="geograf" alt="">
                </div>
            </div>
            <div class="map">
                <div class="image-map">
                    <img src="../../assets/images/maps.jpg" alt="" class="images">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include("../footer.php"); ?>
    <!-- Swiper js -->
    <script src="slider/swiper-bundle.min.js" ;></script>
    <!-- Main js -->
    <script src="slider/main.js" ;></script>

</body>

</html>