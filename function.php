<?php
function uploadImage($file) {
    $targetDir = "uploads/images/";
    $targetFile = $targetDir . basename($file["name"]);
    move_uploaded_file($file["tmp_name"], $targetFile);
    return $targetFile;
}

function addWatermark($imagePath) {
    $watermark = "uploads/watermarks/watermark.png"; // Путь к ватермарке
    $image = imagecreatefrompng($imagePath);
    $watermarkImage = imagecreatefrompng($watermark);
    
    $sx = imagesx($watermarkImage);
    $sy = imagesy($watermarkImage);
    
    imagecopy($image, $watermarkImage, imagesx($image) - $sx, imagesy($image) - $sy, 0, 0, $sx, $sy);
    imagepng($image, $imagePath);
    imagedestroy($image);
    imagedestroy($watermarkImage);
}

function getCategories($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProducts($pdo, $categoryId = null) {
    if ($categoryId) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->execute([$categoryId]);
    } else {
        $stmt = $pdo->query("SELECT * FROM products");
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getComments($pdo, $productId) {
    $stmt = $pdo->prepare("SELECT * FROM comments WHERE product_id = ?");
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>