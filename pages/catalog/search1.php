<?php
include "../../path.php";
include "../../app/controllers/users.php";



/* if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search-term'])) {
    $posts = searchInTitleAndPrice($_POST['search-term'], 'paintings', 'materials', 'canvases', 'sizes', 'topics', 'accesses');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button_filter'])) {
    $filter = filterAll($_POST['material'], $_POST['topic'], $_POST['size'], 'paintings', 'materials', 'canvases', 'sizes', 'topics', 'accesses');
    $posts = $filter; 
}
$orderBy = isset($_POST['orderBy']) ? $_POST['orderBy'] : null;
$access = isset($_POST['access']) ? $_POST['access'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button_sort'])) {
    $posts = sortAndFilterByAccessAndPrice($access, $orderBy, 'paintings', 'materials', 'canvases', 'sizes', 'topics', 'accesses');
} */

$material = isset($_SESSION['filter_material']) ? $_SESSION['filter_material'] : 'all';
$topic = isset($_SESSION['filter_topic']) ? $_SESSION['filter_topic'] : 'all';
$size = isset($_SESSION['filter_size']) ? $_SESSION['filter_size'] : null;
$orderBy = isset($_SESSION['sort_order']) ? $_SESSION['sort_order'] : null;
$access = isset($_SESSION['sort_access']) ? $_SESSION['sort_access'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['search-term'])) {
        $posts = searchInTitleAndPrice($_POST['search-term'], 'paintings', 'materials', 'canvases', 'sizes', 'topics', 'accesses');
    } 
    if (isset($_POST['button_filter'])) {
        $filter = filterAll($_POST['material'], $_POST['topic'], $_POST['size'], 'paintings', 'materials', 'canvases', 'sizes', 'topics', 'accesses');
        $posts = $filter; 

        // Переопределяем значения
        $material = $_POST['material'];
        $topic = $_POST['topic'];
        $size = $_POST['size']; 

        // Сохраняем значения в сессию
        $_SESSION['filter_material'] = $material;
        $_SESSION['filter_topic'] = $topic;
        $_SESSION['filter_size'] = $size;
    }
    if (isset($_POST['button_sort'])) {
        $posts = sortAndFilterByAccessAndPrice($access, $orderBy, 'paintings', 'materials', 'canvases', 'sizes', 'topics', 'accesses');

        // Сохраняем значения сортировки в сессию
        $_SESSION['sort_order'] = $orderBy;
        $_SESSION['sort_access'] = $access;
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Catalog</title>

    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Cтили-->
    <link rel='stylesheet' href='catalog-style.css'>
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
                        <a href="#"><img src="../../assets/images/basket.png" alt=""></a>
                        <?php if (isset($_SESSION['Id'])) : ?>
                            <!-- Если пользователь авторизован -->
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
                                    <!-- <div class="error">
                                        <p><?= $errMassage ?></p>
                                    </div> -->
                                    <form action="catalog.php" name="f1" method="post">
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
                                    <form action="catalog.php" name="f1" method="post">
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
        <div class="content">

            <!-- Sidebar content -->
            <div class="sidebar col-md-3 col-12">
                <div class="section search">
                    <h3>Поиск</h3>
                    <form action="search.php" method="post">
                        <input type="text" name="search-term" class="form-control" placeholder="Введите искомое значение...">
                    </form>
                </div>

                <div class="section filter">
                    <h3>Фильтрация</h3>
                    <form action="search.php" method="post">
                        <div class="filter-option row">
                            <div class="section-left">
                                <a class="title">Материал:</a>
                            </div>
                            <div class="section-right">
                                <select value="<?= $material; ?>" name="material" id="material" class="form-select">
                                    <option value="all">Все</option>
                                    <?php foreach ($materials as $key => $material) : ?>
                                        <option value="<?= $material['IdMaterial'] ?>"><?= $material['TitleMaterial']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter-option row">
                            <div class="section-left">
                                <a class="title">Тематика:</a>
                            </div>
                            <div class="section-right">
                                <select value="<?= $topic; ?>" name="topic" id="topic" class="form-select">
                                    <option value="all">Все</option>
                                    <?php foreach ($topics as $key => $topic) : ?>
                                        <option value="<?= $topic['IdTopic'] ?>"><?= $topic['TitleTopic']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter-option row">
                            <div class="section-left-size">
                                <a class="title">Размер:</a>
                            </div>
                            <div class="section-right-size">
                                <select value="<?= $size; ?>" name="size" id="size" class="form-select">
                                    <option value="">Все</option>
                                    <?php foreach ($sizes as $key => $size) : ?>
                                        <option value="<?= $size['IdSize'] ?>"><?= $size['TitleSize']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="button-filter">
                            <button type="submit" value="Применить" name="button_filter" class="input-filter">Применить</button>
                        </div>
                    </form>
                </div>
                <div class="section sort">
                    <h3>Cортировка</h3>
                    <form action="search.php" method="post">
                        <div class="filter-option row">
                            <div class="section-left-price">
                                <a class="title">Стоимость:</a>
                            </div>
                            <div class="section-right-price">
                                <select id="material" class="form-select">
                                    <option value="all">Все</option>
                                    <option value="wood">По возрастанию</option>
                                    <option value="metal">По убыванию</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter-option row ">
                            <div class="section-left-access">
                                <a class="title">Доступность:</a>
                            </div>
                            <div class="section-right-access">
                                <select value="<?= $access; ?>" name="access" id="access" class="form-select">
                                    <option value="all">Все</option>
                                    <?php foreach ($accesses as $key => $access) : ?>
                                        <option value="<?= $access['IdAccess'] ?>"><?= $access['TitleAccess']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="button-sort">
                            <button type="submit" value="Применить" name="button_sort" class="input-sort">Применить</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main content -->
            <div class="main-content col-md-9 col-12">
                <?php foreach ($posts as $post) : ?>
                    <div class="post">
                        <a href="<?= BASE_URL . 'pages/single/single.php?post=' . $post['Id']; ?>">
                            <div class="col-md-3">
                                <div class="image">
                                    <img src="<?= BASE_URL . 'assets/images/posts/' . $post['Picture'] ?>" alt="<?= $post['Title'] ?>" class="img d-block">
                                </div>
                                <div class="title-price row col-12">
                                    <div class="post_title col-md-8 ">
                                        <?php
                                        if (strlen($post['Title']) > 16) {
                                            $title = mb_substr($post['Title'], 0, 16, 'UTF-8') . '...';
                                        } else {
                                            $title = $post['Title'];
                                        }
                                        echo $title;
                                        ?>
                                    </div>
                                    <div class="post_price col-md-4 ">
                                        <i class="far fa-price"><?= mb_substr($post['Price'], 0, 20, 'UTF-8') . '₽' ?></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <!-- Пагинация -->
        <?php include("pagination.php"); ?>
    </div>

    <!-- Footer-->
    <?php include("../footer.php"); ?>
</body>

</html>