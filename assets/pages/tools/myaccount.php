<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include '../../pages/system_files/db_connect.php';

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../tools/login.php');
    exit;
}

$current_user_id = $_SESSION['user_id'];

$userQuery = "SELECT `name`, `surname`, `patronymic`, `email` FROM `users` WHERE `id` = '$current_user_id'";
$userResult = $conn->query($userQuery);
$user = $userResult->fetch_assoc();

$ordersQuery = "SELECT `p`.`name`, `o`.`quantity`, `o`.`total_price`, `o`.`order_date` FROM `orders` `o` JOIN `products` p ON `o`.`product_id` = `p`.`id` WHERE `o`.`user_id` = $current_user_id";
$ordersResult = $conn->query($ordersQuery);
$orders = $ordersResult->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $patronymic = $_POST['patronymic'];
    $email = $_POST['email'];

    $updateQuery = "UPDATE `users` SET `name` = '$name', `surname` = '$surname', `patronymic` = '$patronymic', `email` = '$email' WHERE `id` = '$current_user_id'";
    $conn->query($updateQuery);

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Личный кабинет | TacliteBay</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h2>Личный кабинет</h2>
            <a href="../../../index.php" class="btn btn-secondary">Назад</a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-body">
                <p>Привет, <strong>
                        <?= htmlspecialchars($user['name']) . ' ' . htmlspecialchars($user['surname']) ?>
                    </strong>!</p>
                <p>Ваш email: <strong>
                        <?= htmlspecialchars($user['email']) ?>
                    </strong></p>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">
                    Изменить данные
                </button>
            </div>
        </div>
        <div class="card shadow">
            <div class="card-header">
                <h3>История заказов</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Название товара</th>
                                <th>Количество</th>
                                <th>Цена</th>
                                <th>Дата заказа</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($order['name']) ?>
                                    </td>
                                    <td>
                                        <?= $order['quantity'] ?>
                                    </td>
                                    <td>
                                        <?= $order['total_price'] ?> руб.
                                    </td>
                                    <td>
                                        <?= $order['order_date'] ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Редактирование профиля</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editProfileForm" method="post">
                            <div class="form-group">
                                <label for="name">Имя</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?= htmlspecialchars($user['name']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="surname">Фамилия</label>
                                <input type="text" class="form-control" id="surname" name="surname"
                                    value="<?= htmlspecialchars($user['surname']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="patronymic">Отчество</label>
                                <input type="text" class="form-control" id="patronymic" name="patronymic"
                                    value="<?= htmlspecialchars($user['patronymic']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                <button type="submit" name="update_profile" class="btn btn-primary">Сохранить
                                    изменения</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>