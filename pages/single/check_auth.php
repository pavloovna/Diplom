<?php
include "../../path.php";
include "../../app/controllers/users.php";

if (isset($_SESSION['Id'])) { 
    // Пользователь авторизован
    echo json_encode(['auth' => 'true']);
} else {
    // Пользователь не авторизован
    echo json_encode(['auth' => 'false']);
}
?>