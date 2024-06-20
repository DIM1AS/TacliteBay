<?php
session_start();
include '../../pages/system_files/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt === false) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $row['name'];
            $_SESSION['is_admin'] = $row['is_admin'];

            header("Location: ../../../index.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Неправильный пароль.";
        }
    } else {
        $_SESSION['login_error'] = "Пользователь с таким email не существует.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация | TacliteBay</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../css/login/login.css">
</head>

<body>
     <div class="login-container">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4 logo-section">
                    <a href="../../../index.php">
                        <img class="mb-4" src="../../img/index/header/logo.png" alt="Логотип TacliteBay">
                    </a>
                    <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
                </div>
                <form class="form-signin" action="" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block auth-btn" type="submit">Войти</button>
                </form>
                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger mt-2" role="alert">
                        <?php echo $_SESSION['login_error']; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>