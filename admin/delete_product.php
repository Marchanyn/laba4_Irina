<?php
require '../config.php';
require '../functions.php';

// Проверка авторизации администратора
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$productId = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$productId]);

header('Location: index.php');
exit;
?>