<?php
/* include SITE_ROOT . "/app/database/function.php"; */
include '../database/function.php';

$errMassage = [];
$id = '';
$title = '';
$picture = '';
$picture_second = '';
$picture_third = '';
$picture_fourth = '';
$description = '';
$material = '';
$canvas = '';
$size = '';
$topic = '';
$access = '';
$price = '';

$materials = selectAll('materials');
$canvases = selectAll('canvases');
$sizes = selectAll('sizes');
$topics = selectAll('topics');
$accesses = selectAll('accesses');

$posts = selectAll('paintings');
$postsId = selectAllFromPostsWithId('paintings', 'materials', 'canvases', 'sizes', 'topics', 'accesses');


//Код для формы создания записи
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_post'])) {
    //Загрузка первого изображения
    if (!empty($_FILES['picture']['name'])) {
        $imageName = time() . "_" . $_FILES['picture']['name'];
        $fileTmpName = $_FILES['picture']['tmp_name'];
        $fileType = $_FILES['picture']['type'];
        $destination = ROOT_PATH . "/assets/images/posts/" . $imageName;

        if (strpos($fileType, 'image') === false) {
            array_push($errMassage, "Подгружаемый файл не является изображением!");
        } else {
            $result = move_uploaded_file($fileTmpName, $destination);

            if ($result) {
                $_POST['picture'] = $imageName;
            } else {
                array_push($errMassage, "Ошибка загрузки первого изображения на сервер");
            }
        }
    } else {
        array_push($errMassage, "Ошибка получения первого изображения");
    }
    //Загрузка второго изображения
    if (!empty($_FILES['picture_second']['name'])) {
        $imageName = time() . "_" . $_FILES['picture_second']['name'];
        $fileTmpName = $_FILES['picture_second']['tmp_name'];
        $fileType = $_FILES['picture_second']['type'];
        $destination = ROOT_PATH . "/assets/images/posts/" . $imageName;

        if (strpos($fileType, 'image') === false) {
            array_push($errMassage, "Подгружаемый файл не является изображением!");
        } else {
            $result = move_uploaded_file($fileTmpName, $destination);

            if ($result) {
                $_POST['picture_second'] = $imageName;
            } else {
                array_push($errMassage, "Ошибка загрузки второго изображения на сервер");
            }
        }
    } else {
        array_push($errMassage, "Ошибка получения второго изображения");
    }
    //Загрузка третьего изображения
    if (!empty($_FILES['picture_third']['name'])) {
        $imageName = time() . "_" . $_FILES['picture_third']['name'];
        $fileTmpName = $_FILES['picture_third']['tmp_name'];
        $fileType = $_FILES['picture_third']['type'];
        $destination = ROOT_PATH . "/assets/images/posts/" . $imageName;

        if (strpos($fileType, 'image') === false) {
            array_push($errMassage, "Подгружаемый файл не является изображением!");
        } else {
            $result = move_uploaded_file($fileTmpName, $destination);

            if ($result) {
                $_POST['picture_third'] = $imageName;
            } else {
                array_push($errMassage, "Ошибка загрузки третьего изображения на сервер");
            }
        }
    } else {
        array_push($errMassage, "Ошибка получения третьего изображения");
    }
    //Загрузка четвертого изображения
    if (!empty($_FILES['picture_fourth']['name'])) {
        $imageName = time() . "_" . $_FILES['picture_fourth']['name'];
        $fileTmpName = $_FILES['picture_fourth']['tmp_name'];
        $fileType = $_FILES['picture_fourth']['type'];
        $destination = ROOT_PATH . "/assets/images/posts/" . $imageName;

        if (strpos($fileType, 'image') === false) {
            array_push($errMassage, "Подгружаемый файл не является изображением!");
        } else {
            $result = move_uploaded_file($fileTmpName, $destination);

            if ($result) {
                $_POST['picture_fourth'] = $imageName;
            } else {
                array_push($errMassage, "Ошибка загрузки четвертого изображения на сервер");
            }
        }
    } else {
        array_push($errMassage, "Ошибка получения четвертого изображения");
    }

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $material = trim($_POST['material']);
    $canvas = trim($_POST['canvas']);
    $size = trim($_POST['size']);
    $topic = trim($_POST['topic']);
    $access = trim($_POST['access']);
    $price = trim($_POST['price']);
   /*  $picture = trim($_POST['picture']); */

    if (
        $title === '' || $description === '' || $material === '' || $canvas === ''
        || $size === '' || $topic === '' || $access === '' || $price === '' /* ||  $picture === '' */
    ) {
        array_push($errMassage, "Не все поля заполнены!");
    } else {
        $existence = selectOne('paintings', ['title' => $title]);

            $post = [
                'Title' => $title,
                'Picture' => $_POST['picture'],
                'PictureSecond' => $_POST['picture_second'],
                'PictureThird' => $_POST['picture_third'],
                'PictureFourth' => $_POST['picture_fourth'],
                'Description' => $description,
                'MaterialId' => $material,
                'CanvasId' => $canvas,
                'SizeId' => $size,
                'TopicId' => $topic,
                'AccessId' => $access,
                'Price' => $price
            ];
            $post = insert('paintings', $post);
            $post = selectOne('paintings', ['Id' => $id]);
            header('location: ' . BASE_URL . 'admin/posts/index-post.php');

    }
} else {
    $id = '';
    $title = '';
    $picture = '';
    $picture_second = '';
    $picture_third = '';
    $picture_fourth = '';
    $description = '';
    $material = '';
    $canvas = '';
    $size = '';
    $topic = '';
    $access = '';
    $price = '';
}

//Update картины
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $post = selectOne('paintings', ['Id' => $_GET['id']]);

    $id = $post['Id'];
    $title = $post['Title'];
    $description = $post['Description'];
    $material = $post['MaterialId'];
    $canvas = $post['CanvasId'];
    $size = $post['SizeId'];
    $topic = $post['TopicId'];
    $access = $post['AccessId'];
    $price = $post['Price'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_post'])) {
    $id = $_POST['id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $material = trim($_POST['material']);
    $canvas = trim($_POST['canvas']);
    $size = trim($_POST['size']);
    $topic = trim($_POST['topic']);
    $access = trim($_POST['access']);
    $price = trim($_POST['price']);
    /* $picture = trim($_POST['picture']); */

    //Загрузка главного изображения 
    if (!empty($_FILES['picture']['name'])) {
        $imageName = time() . "_" . $_FILES['picture']['name'];
        $fileTmpName = $_FILES['picture']['tmp_name'];
        $fileType = $_FILES['picture']['type'];
        $destination = ROOT_PATH . "/assets/images/posts/" . $imageName;

        if (strpos($fileType, 'image') === false) {
            array_push($errMassage, "Подгружаемый файл не является изображением!");
        } else {
            $result = move_uploaded_file($fileTmpName, $destination);

            if ($result) {
                $_POST['picture'] = $imageName;
            } else {
                array_push($errMassage, "Ошибка загрузки изображения на сервер");
            }
        }
    } else {
        array_push($errMassage, "Ошибка получения изображения");
    }

    //Загрузка второго изображения
    if (!empty($_FILES['picture_second']['name'])) {
        $imageName = time() . "_" . $_FILES['picture_second']['name'];
        $fileTmpName = $_FILES['picture_second']['tmp_name'];
        $fileType = $_FILES['picture_second']['type'];
        $destination = ROOT_PATH . "/assets/images/posts/" . $imageName;

        if (strpos($fileType, 'image') === false) {
            array_push($errMassage, "Подгружаемый файл не является изображением!");
        } else {
            $result = move_uploaded_file($fileTmpName, $destination);

            if ($result) {
                $_POST['picture_second'] = $imageName;
            } else {
                array_push($errMassage, "Ошибка загрузки второго изображения на сервер");
            }
        }
    } else {
        array_push($errMassage, "Ошибка получения второго изображения");
    }
    //Загрузка третьего изображения
    if (!empty($_FILES['picture_third']['name'])) {
        $imageName = time() . "_" . $_FILES['picture_third']['name'];
        $fileTmpName = $_FILES['picture_third']['tmp_name'];
        $fileType = $_FILES['picture_third']['type'];
        $destination = ROOT_PATH . "/assets/images/posts/" . $imageName;

        if (strpos($fileType, 'image') === false) {
            array_push($errMassage, "Подгружаемый файл не является изображением!");
        } else {
            $result = move_uploaded_file($fileTmpName, $destination);

            if ($result) {
                $_POST['picture_third'] = $imageName;
            } else {
                array_push($errMassage, "Ошибка загрузки третьего изображения на сервер");
            }
        }
    } else {
        array_push($errMassage, "Ошибка получения третьего изображения");
    }
    //Загрузка четвертого изображения
    if (!empty($_FILES['picture_fourth']['name'])) {
        $imageName = time() . "_" . $_FILES['picture_fourth']['name'];
        $fileTmpName = $_FILES['picture_fourth']['tmp_name'];
        $fileType = $_FILES['picture_fourth']['type'];
        $destination = ROOT_PATH . "/assets/images/posts/" . $imageName;

        if (strpos($fileType, 'image') === false) {
            array_push($errMassage, "Подгружаемый файл не является изображением!");
        } else {
            $result = move_uploaded_file($fileTmpName, $destination);

            if ($result) {
                $_POST['picture_fourth'] = $imageName;
            } else {
                array_push($errMassage, "Ошибка загрузки четвертого изображения на сервер");
            }
        }
    } else {
        array_push($errMassage, "Ошибка получения четвертого изображения");
    }


    if ($title === '' || $description === '' || $material === '' || $canvas === ''
        || $size === '' || $topic === '' || $access === '' || $price === '' /* || $picture ==='' */
    ) {
        array_push($errMassage, "Не все поля заполнены!");
    } else {
        $post = [
            'Title' => $title,
            'Picture' => $_POST['picture'],
            'PictureSecond' => $_POST['picture_second'],
            'PictureThird' => $_POST['picture_third'],
            'PictureFourth' => $_POST['picture_fourth'],
            'Description' => $description,
            'MaterialId' => $material,
            'CanvasId' => $canvas,
            'SizeId' => $size,
            'TopicId' => $topic,
            'AccessId' => $access,
            'Price' => $price
        ];
        $post = update('paintings', $id, $post);
        header('location: ' . BASE_URL . 'admin/posts/index-post.php');
    }
} else {
}

//Удаление картины
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    delete('paintings', $id);
    header('location: ' . BASE_URL . 'admin/posts/index-post.php');
}
