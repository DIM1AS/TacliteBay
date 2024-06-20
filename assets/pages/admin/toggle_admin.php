<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../../assets/pages/login.php');
    exit;
}

include '../../assets/pages/db_connect.php';

if (isset($_GET['id']) && isset($_GET['admin'])) {
    $userId = $_GET['id'];
    $isAdmin = $_GET['admin'];

    $stmt = $conn->prepare("UPDATE users SET is_admin = ? WHERE id = ?");
    $stmt->bind_param("ii", $isAdmin, $userId);
    $stmt->execute();

    if ($stmt->error) {
    }

    header('Location: manage_users.php');
    exit;
}

?>