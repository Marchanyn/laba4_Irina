<?php
require '../config.php';
require '../functions.php';

// Проверка авторизации администратора
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $main_image = uploadImage($_FILES['main_image']);
    addWatermark($main_image);

    $stmt = $pdo->prepare("INSERT INTO products (name, description, main_image, category_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $description, $main_image, $category_id]);

    header('Location: index.php');
    exit;
}

$categories = getCategories($pdo);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить товар</title>
</head>
<body>
    <h1>Добавить товар</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="name">Название:</label>
        <input type="text" name="name" required>
        <br>
        <label for="description">Описание:</label>
        <textarea name="description" required></textarea>
        <br>
        <label for="category_id">Категория:</label>
        <select name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="main_image">Основное изображение:</label>
        <input type="file" name="main_image" required>
        <br>
        <input type="submit" value="Добавить">
    </form>
</body>
</html>