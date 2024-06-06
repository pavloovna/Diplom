<?php
session_start();

// Проверяем, есть ли ID товара в запросе
if (isset($_POST['item_id'])) {
    $itemId = $_POST['item_id'];

    // Удаляем товар из сессии
    if (isset($_SESSION['cart'][$itemId])) {
        unset($_SESSION['cart'][$itemId]);
        // Можно добавить логику для обновления стоимости корзины и т.д.
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
} else {
    echo json_encode(['status' => 'error']);
}
?>