<?php
require '../config.php';
require '../functions.php';

$productId = $_GET['id'];
$product = getProducts($pdo, $productId)[0];
$comments = getComments($pdo, $productId);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $product['name']; ?></title>
</head>
<body>
    <h1><?php echo $product['name']; ?></h1>
    <img src="<?php echo $product['main_image']; ?>" alt="<?php echo $product['name']; ?>">
    <p><?php echo $product['description']; ?></p>

    <h2>Комментарии</h2>
    <form method="post">
        < ```php
        <label for="author">Ваше имя:</label>
        <input type="text" name="author" required>
        <br>
        <label for="content">Комментарий:</label>
        <textarea name="content" required></textarea>
        <br>
        <input type="submit" value="Добавить комментарий">
    </form>

    <div>
        <?php foreach ($comments as $comment): ?>
            <div>
                <strong><?php echo $comment['author']; ?></strong>
                <p><?php echo $comment['content']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>