<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../tools/login.php');
    exit;
}

include '../../pages/system_files/db_connect.php';

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Товар удален.";
    } else {
        echo "Ошибка при удалении товара.";
    }
}
header('Location: ../admin/manage_products.php');
exit;
?>
