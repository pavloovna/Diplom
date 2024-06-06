<?php
include "../../path.php";
include "../../app/controllers/users.php";

$post = selectPostFromPostsOnSingle('paintings', 'materials', 'canvases', 'sizes', 'topics', 'accesses', $_GET['post']);
// Проверка сессии
if (!isset($_SESSION['Id'])) {
    // Если сессия не установлена, генерируем уникальный ID
    if (!isset($_SESSION['GuestId'])) {
        $_SESSION['GuestId'] = generateGuestId();
    }
    $guestId = $_SESSION['GuestId'];
} else {
    $guestId = null; // Не нужно для авторизованных пользователей
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Single</title>
    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Cтили-->
    <link rel='stylesheet' href='single-style.css'>
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
                                    <form action="single.php" name="f1" method="post">
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
                                    <form action="single.php" name="f1" method="post">
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
            <div class="photos col-md-6 col-12">
                <div class="photos-main row col-12">
                    <div class="image">
                        <img src="<?= BASE_URL . 'assets/images/posts/' . $post['Picture'] ?>" alt="<?= $post['Title'] ?>" class="images" id="ImgMain">
                    </div>

                    <div id="myModal" class="modal">
                        <span class="close">×</span>
                        <img class="modal-content" id="img01">
                        <div id="caption"></div>
                    </div>

                    <script>
                        var modal = document.getElementById('myModal');
                        var img = document.getElementById('ImgMain');
                        var modalImg = document.getElementById("img01");
                        var captionText = document.getElementById("caption");
                        img.onclick = function() {
                            modal.style.display = "block";
                            modalImg.src = this.src;
                            captionText.innerHTML = this.alt;
                        }
                        var span = document.getElementsByClassName("close")[0];
                        span.onclick = function() {
                            modal.style.display = "none";
                        }
                    </script>
                </div>
                <div class="photos-secondary row col-12">

                    <!-- Второе изображение -->
                    <div class="photos-first col-md-4 ">
                        <div class="image">
                            <img src="<?= BASE_URL . 'assets/images/posts/' . $post['PictureSecond'] ?>" alt="<?= $post['Title'] ?>" class="img-mx-auto d-block" id="ImgSecond">
                        </div>
                        <div id="myModal" class="modal">
                            <span class="close">×</span>
                            <img class="modal-content" id="img01">
                            <div id="caption"></div>
                        </div>

                        <script>
                            var modal = document.getElementById('myModal');
                            var img = document.getElementById('ImgSecond');
                            var modalImg = document.getElementById("img01");
                            var captionText = document.getElementById("caption");
                            img.onclick = function() {
                                modal.style.display = "block";
                                modalImg.src = this.src;
                                captionText.innerHTML = this.alt;
                            }
                            var span = document.getElementsByClassName("close")[0];
                            span.onclick = function() {
                                modal.style.display = "none";
                            }
                        </script>
                    </div>
                    <!-- Третье изображение -->
                    <div class="photos-second col-md-4 ">
                        <div class="image">
                            <img src="<?= BASE_URL . 'assets/images/posts/' . $post['PictureThird'] ?>" alt="<?= $post['Title'] ?>" class="img-mx-auto d-block" id="ImgThird">
                        </div>
                        <div id="myModal" class="modal">
                            <span class="close">×</span>
                            <img class="modal-content" id="img01">
                            <div id="caption"></div>
                        </div>
                        <script>
                            var modal = document.getElementById('myModal');
                            var img = document.getElementById('ImgThird');
                            var modalImg = document.getElementById("img01");
                            var captionText = document.getElementById("caption");
                            img.onclick = function() {
                                modal.style.display = "block";
                                modalImg.src = this.src;
                                captionText.innerHTML = this.alt;
                            }
                            var span = document.getElementsByClassName("close")[0];
                            span.onclick = function() {
                                modal.style.display = "none";
                            }
                        </script>
                    </div>

                    <!-- Четвертое изображение -->
                    <div class="photos-third col-md-4 ">
                        <div class="image">
                            <img src="<?= BASE_URL . 'assets/images/posts/' . $post['PictureFourth'] ?>" alt="<?= $post['Title'] ?>" class="img-mx-auto d-block" id="ImgFourth">
                        </div>
                        <div id="myModal" class="modal">
                            <span class="close">×</span>
                            <img class="modal-content" id="img01">
                            <div id="caption"></div>
                        </div>
                        <script>
                            var modal = document.getElementById('myModal');
                            var img = document.getElementById('ImgFourth');
                            var modalImg = document.getElementById("img01");
                            var captionText = document.getElementById("caption");
                            img.onclick = function() {
                                modal.style.display = "block";
                                modalImg.src = this.src;
                                captionText.innerHTML = this.alt;
                            }
                            var span = document.getElementsByClassName("close")[0];
                            span.onclick = function() {
                                modal.style.display = "none";
                            }
                        </script>
                    </div>
                </div>
            </div>
            <div class="description col-md-6 col-12">
                <div class="description-container ">
                    <div class="title">"<?= $post['Title']; ?>"</div>
                    <div class="textbox"><?= $post['Description']; ?></div>
                    <div class="textbox-price row col-12">
                        <div class="description-options col-md-6 col-12">
                            <div class="textbox_component">
                                <i class="far fa-title col">Материал:</i>
                                <i class="far fa-description col"><?= $post['TitleMaterial']; ?></i>
                            </div>
                            <div class="textbox_component">
                                <i class="far fa-title col">Размер:</i>
                                <i class="far fa-description col"><?= $post['TitleSize']; ?></i>
                            </div>
                            <div class="textbox_component">
                                <i class="far fa-title col">Холст:</i>
                                <i class="far fa-description col"><?= $post['TitleCanvas']; ?></i>
                            </div>
                        </div>
                        <div class="description-price col-md-6 col-12">
                            <div class="price-container">
                                <div class="title"><?= $post['Price']; ?>₽</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button-add">
                    <?php if ($post['TitleAccess'] == 'Актуально') : ?>
                        <button data-post-id="<?= $_GET['post']; ?>" class="add-to-basket">Добавить в корзину</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="stock">
            <div class="image-stock">
                <img src="../../assets/images/single.png" alt="" class="images">
            </div>
        </div>
    </div>
    <?php include("../footer.php"); ?>

    <script>
        const addToCartButtons = document.querySelectorAll('.add-to-basket');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', () => {
                const postId = button.dataset.postId;
                // Отправляем AJAX-запрос для проверки авторизации
                fetch('check_auth.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.auth === 'true') {
                            // Пользователь авторизован, отправляем AJAX-запрос на добавление в корзину
                            fetch('add_to_basket.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: 'post_id=' + postId
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        alert('Товар добавлен в корзину!');
                                    } else {
                                        alert('Ошибка добавления товара!');
                                    }
                                })
                                .catch(error => {
                                    console.error('Ошибка отправки запроса:', error);
                                });
                        } else {
                            // Пользователь не авторизован, модальное окно
                            authModal.style.display = "block";
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка отправки запроса:', error);
                    });
            });
        });
    </script>
</body>

</html>