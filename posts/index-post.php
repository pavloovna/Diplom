<?php
session_start();
include "../../path.php";
include "../controllers/posts.php";
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>POSTS INDEX</title>

    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Cтили-->
    <link rel='stylesheet' href='posts-style.css'>
    <!--Шрифты-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <?php include("../include/header.php"); ?>
    <div class="container">
        <div class="row">
            <div class="posts col">
                <div class="row title-table">
                    <h3>Уравление записями</h3>
                    <div class="heading-all row">
                        <div class="heading col-1">ID</div>
                        <div class="heading col-1">Название</div>
                        <div class="heading col-1">Описание</div>
                        <div class="heading col-1">Материал</div>
                        <div class="heading col-1">Картина</div>
                        <div class="heading col-1">Размер</div>
                        <div class="heading col-1">Тема</div>
                        <div class="heading col-1">Доступность</div>
                        <div class="heading col-1">Цена</div>
                        <div class="heading col-1">Изменить</div>
                        <div class="heading col-1">Удалить</div>
                    </div>
                </div>
                <div class="content-all row">
                    <?php foreach ($postsId as $key => $post) : ?>
                        <div class="row post">
                            <div class="id col-1"><?= $key + 1; ?></div>
                            <div class="title col-1"><?= $post['Title']; ?></div>
                            <div class="price col-1">
                                <?php
                                if (strlen($post['Description']) > 25) {
                                    $description = mb_substr($post['Description'], 0, 25, 'UTF-8') . '...';
                                } else {
                                    $description = $post['Description'];
                                }
                                echo $description;
                                ?>
                            </div>
                            <div class="price col-1"><?= $post['TitleMaterial']; ?></div>
                            <div class="picture col-1">
                                <?php if ($post['Picture']) : ?>
                                    <img src="<?php echo BASE_URL . '/assets/images/posts/' . $post['Picture']; ?>" alt="Картина">
                                <?php else : ?>
                                    <p>Изображение отсутствует</p>
                                <?php endif; ?>
                            </div>
                            <div class="price col-1"><?= $post['TitleSize']; ?></div>
                            <div class="price col-1"><?= $post['TitleTopic']; ?></div>
                            <div class="price col-1"><?= $post['TitleAccess']; ?></div>
                            <div class="price col-1"><?= $post['Price']; ?></div>
                            <div class="red col-1"><a href="edit-post.php?id=<?= $post['Id'] ?>"><img src="../../assets/images/edit.png" alt=""></a></div>
                            <div class="del col-1"><a href="edit-post.php?delete_id=<?= $post['Id'] ?>"><img src="../../assets/images/delete.png" alt=""></a></div>
                            <hr>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include("../include/footer.php"); ?>
</body>

</html>