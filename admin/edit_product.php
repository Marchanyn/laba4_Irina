<?php
require '../config.php';
require '../functions.php';

// Проверка авторизации администратора
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$productId = $_GET['id'];
$product = getProducts($pdo, $productId)[0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    if ($_FILES['main_image']['name']) {
        $main_image = uploadImage($_FILES['main_image']);
        addWatermark($main_image);
    } else {
        $main_image = $product['main_image'];
    }

    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, main_image = ?, category_id = ? WHERE id = ?");
    $stmt->execute([$name, $description, $main_image, $category_id, $productId]);

    header('Location: index.php');
    exit;
}

$categories = getCategories($pdo);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать товар</title>
</head>
<body>
    <h1>Редактировать товар</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="name">Название:</label>
        <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
        <br>
        <label for="description">Описание:</label>
        <textarea name="description" required><?php echo $product['description']; ?></textarea>
        <br>
        <label for="category_id">Категория:</label>
        <select name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $product['category_id']) echo 'selected'; ?>><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="main_image">Основное изображение:</label>
        <input type="file" name="main_image">
        <br>
        <input type="submit" value="Сохранить">
    </form>
</body>
</html>