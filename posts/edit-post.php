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

    <title>POSTS CREATE</title>

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
            <div class="posts">
                <div class="row title-table">
                    <h3>Редактирование картины</h3>
                </div>
                <div class="row add-post">
                    <div class="error">
                        <?php include("../../app/helps/errorInfo.php"); ?>
                    </div>
                    <form action="edit-post.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $id; ?>">
                        <label for="editor" class="form-label">Название</label>
                        <div class="col">
                            <input value="<?= $post['Title']; ?>" name="title" type="text" class="form-control" placeholder="Название картины" aria-label="Название картины">
                        </div>
                        <label for="editor" class="form-label">Главное изображение</label>
                        <div class="input-group col">
                            <input name="picture" type="file" class="form-control" id="inputGroupFile02">
                            <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
                        </div>
                        <label for="editor" class="form-label">Второе изображение</label>
                        <div class="input-group col">
                            <input name="picture_second" type="file" class="form-control" id="inputGroupFile02">
                            <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
                        </div>
                        <label for="editor" class="form-label">Третье изображение</label>
                        <div class="input-group col">
                            <input name="picture_third" type="file" class="form-control" id="inputGroupFile02">
                            <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
                        </div>
                        <label for="editor" class="form-label">Четвертое изображение</label>
                        <div class="input-group col">
                            <input name="picture_fourth" type="file" class="form-control" id="inputGroupFile02">
                            <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
                        </div>
                        <div class="col">
                            <label for="editor" class="form-label">Описание</label>
                            <textarea name="description" class="form-control" id="content" rows="6"><?= $post['Description']; ?></textarea>
                        </div>

                        <select value="<?= $post['MaterialId']; ?>" name="material" class="form-select" aria-label="Материал">
                            <option disabled>Материал</option>
                            <?php foreach ($materials as $key => $material) : ?>
                                <option value="<?= $material['IdMaterial'] ?>">
                                    <?= $material['TitleMaterial']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select name="size" class="form-select" aria-label="Размер">
                            <option disabled>Размер</option>
                            <?php foreach ($sizes as $key => $size) : ?>
                                <option value="<?= $size['IdSize'] ?>">
                                <?= $size['TitleSize']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select name="canvas" class="form-select" aria-label="Холст">
                            <option disabled>Холст</option>
                            <?php foreach ($canvases as $key => $canvas) : ?>
                                <option value="<?= $canvas['IdCanvas'] ?>">
                                <?= $canvas['TitleCanvas']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select name="topic" class="form-select" aria-label="Тематика">
                            <option disabled>Тематика</option>
                            <?php foreach ($topics as $key => $topic) : ?>
                                <option value="<?= $topic['IdTopic'] ?>">
                                <?= $topic['TitleTopic']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select name="access" class="form-select" aria-label="Доступность">
                            <option disabled>Доступность</option>
                            <?php foreach ($accesses as $key => $access) : ?>
                                <option value="<?= $access['IdAccess'] ?>">
                                <?= $access['TitleAccess']; ?>
                                   
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="editor" class="form-label">Стоимость</label>
                        <div class="col">
                            <input value="<?= $post['Price']; ?>" name="price" type="text" class="form-control" placeholder="Стоимость" aria-label="Стоимость">
                        </div>
                        <div class="col">
                            <div class="button-add">
                                <button href="#" name="edit_post" type="input" class="btn btn-white btn-animate">Сохранить изменения</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include("../include/footer.php"); ?>
</body>

</html>