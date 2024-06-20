<?php
session_start();
include '../../pages/system_files/db_connect.php';

if (isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_SESSION['user_id'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $userId = $_SESSION['user_id'];

    $checkQuery = "SELECT * FROM cart WHERE user_id = $userId AND product_id = $productId";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $updateQuery = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $userId AND product_id = $productId";
        $conn->query($updateQuery);
    } else {
        $insertQuery = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($userId, $productId, $quantity)";
        $conn->query($insertQuery);
    }
}
header('Location: ../../../index.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TacliteBay</title>
</head>

<body>

</body>

</html>