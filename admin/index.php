<?php
require '../config.php';
require '../functions.php';

// Проверка авторизации администратора
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Логика для отображения товаров и управления ими
$products = getProducts($pdo);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админка</title>
</head>
<body>
    <h1>Управление товарами</h1>
    <a href="add_product.php">Добавить товар</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Действия</th>
 </tr>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><?php echo $product['name']; ?></td>
            <td>
                <a href="edit_product.php?id=<?php echo $product['id']; ?>">Редактировать</a>
                <a href="delete_product.php?id=<?php echo $product['id']; ?>">Удалить</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>