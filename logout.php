<?php
session_start();

include "path.php";

unset($_SESSION['Id']);
unset($_SESSION['Name']);
unset($_SESSION['Role']);
unset($_SESSION['cart']);

header('location: ' . BASE_URL . 'pages/main/main.php');
