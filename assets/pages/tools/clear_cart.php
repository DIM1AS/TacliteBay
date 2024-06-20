<?php
session_start();
include '../../pages/system_files/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo "Пользователь не авторизован";
    exit();
}

$userId = $_SESSION['user_id'];

$selectQuery = "SELECT product_id, quantity FROM cart WHERE user_id = ?";
$stmtSelect = $conn->prepare($selectQuery);
$stmtSelect->bind_param("i", $userId);

if ($stmtSelect->execute()) {
    $result = $stmtSelect->get_result();

    $insertQuery = "INSERT INTO orders (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($insertQuery);
    $stmtInsert->bind_param("iii", $userId, $productId, $quantity);

    while ($row = $result->fetch_assoc()) {
        $productId = $row['product_id'];
        $quantity = $row['quantity'];
        $stmtInsert->execute();
    }

    $stmtInsert->close();
    $stmtSelect->close();
}

$deleteQuery = "DELETE FROM cart WHERE user_id = ?";
$stmtDelete = $conn->prepare($deleteQuery);
$stmtDelete->bind_param("i", $userId);

if ($stmtDelete->execute()) {
    echo "Заказ успешно оформлен и корзина очищена";
} else {
    echo "Произошла ошибка: " . $conn->error;
}

$stmtDelete->close();
$conn->close();
?>