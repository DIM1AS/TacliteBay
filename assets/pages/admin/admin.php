<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../tools/login.php');
    exit;
}
include '../../pages/system_files/db_connect.php';

// Получение количества пользователей
$result = $conn->query("SELECT COUNT(*) as total_users FROM users");
$total_users = $result->fetch_object()->total_users;

// Исправление SQL-запроса для получения количества товаров
$result = $conn->query("SELECT COUNT(*) as total_products FROM products");
$total_products = $result->fetch_object()->total_products;

// Получение количества товаров в корзинах
$result = $conn->query("SELECT SUM(quantity) as cart_quantity FROM cart");
$cart_quantity = $result->fetch_object()->cart_quantity;

// Получение последних заказов
$recent_orders = $conn->query("
    SELECT o.id, o.order_date, CONCAT(u.name, ' ', u.surname) AS user_name, 
    SUM(p.price * o.quantity) AS total_price
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN products p ON o.product_id = p.id
    GROUP BY o.id
    ORDER BY o.order_date DESC
    LIMIT 500
");

$conn->close();
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель | TacliteBay</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../../../favicon.ico" type="image/x-icon">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">TacliteBay Админка</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../../pages/admin/manage_users.php">Управление пользователями</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../pages/admin/manage_products.php">Управление товарами</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="../../../index.php">&larr; Назад на главную</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <h1>Добро пожаловать в админ-панель,
                    <?php echo htmlspecialchars($_SESSION['name']); ?>!
                </h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Пользователей всего</h5>
                    <p class="card-text">
                        <?php echo $total_users; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Товаров в наличии</h5>
                    <p class="card-text">
                        <?php echo $total_products; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Товаров в корзинах</h5>
                    <p class="card-text">
                    <p class="card-text">
                        <?php echo ($cart_quantity > 0) ? $cart_quantity : '0'; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h2 class="mb-3">Последние заказы</h2>
            <table class="table table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Пользователь</th>
                    <th scope="col">Сумма</th>
                    <th scope="col">Статус</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $order_number = 1;
                while ($order = $recent_orders->fetch_assoc()):
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $order_number; ?>
                        </th>
                        <td>
                            <?php echo $order['order_date']; ?>
                        </td>
                        <td>
                            <?php echo $order['user_name']; ?>
                        </td>
                        <td>
                            <?php echo number_format($order['total_price'], 2, '.', ' '); ?> ₽
                        </td>
                        <td>В обработке</td>
                    </tr>
                    <?php
                    $order_number++;
                endwhile;
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.9/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
