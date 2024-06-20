<?php
session_start();
include '../../pages/system_files/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../tools/login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$productId = $_GET['product_id'] ?? 0;

$query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $userId, $productId);
$stmt->execute();

header('Location: ../tools/cart.php');
?>