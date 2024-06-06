<?php
include "../../path.php";
include "../../app/controllers/users.php";

if (isset($_SESSION['Id']) && isset($_POST['post_id'])) {
    // Проверка авторизации (пользователь авторизован)
    $postId = $_POST['post_id'];
    $post = selectPostFromPostsOnSingle('paintings', 'materials', 'canvases', 'sizes', 'topics', 'accesses', $postId);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Добавляем товар в корзину
    $_SESSION['cart'][] = $post;

    echo json_encode(['status' => 'success']);
} else {
    // Пользователь не авторизован, не добавили товар
    echo json_encode(['status' => 'not_authorized']);
}
?>