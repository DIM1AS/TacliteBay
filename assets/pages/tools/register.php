<?php
include "../system_files/db_connect.php";

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $surname = $conn->real_escape_string($_POST['surname']);
    $patronymic = $conn->real_escape_string($_POST['patronymic']);
    $login = $conn->real_escape_string($_POST['login']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkSql = "SELECT * FROM users WHERE login='$login' OR email='$email'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        $message = "Такой логин или email уже существует!";
    } else {
        $sql = "INSERT INTO users (name, surname, patronymic, login, email, password) 
                VALUES ('$name', '$surname', '$patronymic', '$login', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            $message = "Успешно зарегистрировано!";
            header("Location: ../tools/login.php");
        } else {
            $message = "Ошибка: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация | TacliteBay</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../css/register/register.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height:100vh;">
            <div class="col-md-6 col-lg-4">
                <div class="text-center mb-5">
                </div>
                <div class="card">
                    <div class="card-body">
                        <form class="form-signup" action="" method="POST" id="registration-form">
                            <div class="form-group">
                                <div class="text-center mb-4">
                                    <a href="../../../index.php">
                                        <img class="mb-4" src="../../img/index/header/logo.png" alt="Логотип TacliteBay"
                                            width="72" height="72">
                                    </a>
                                    <h1 class="h3 mb-3 font-weight-normal"> Регистрация</h1>
                                </div>
                                <form class="form-signup" action="" method="POST" id="registration-form">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="name">Имя:</label>
                                            <input type="text" id="name" name="name" class="form-control" required
                                                pattern="[А-Яа-яЁё\s\-]+">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="surname">Фамилия:</label>
                                            <input type="text" id="surname" name="surname" class="form-control" required
                                                pattern="[А-Яа-яЁё\s\-]+">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="patronymic">Отчество:</label>
                                            <input type="text" id="patronymic" name="patronymic" class="form-control"
                                                pattern="[А-Яа-яЁё\s\-]+">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="login">Логин:</label>
                                            <input type="text" id="login" name="login" class="form-control" required
                                                pattern="[a-zA-Z0-9\-]+">
                                        </div>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль:</label>
                                <input type="password" id="password" name="password" class="form-control" required
                                    minlength="6">
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="rules" data-toggle="modal"
                                    data-target="#termsModal">
                                <label class="form-check-label" for="rules">Я согласен с пользовательским
                                    соглашением</label>
                            </div>
                            <div class="modal fade" id="termsModal" tabindex="-1" role="dialog"
                                aria-labelledby="termsModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="termsModalLabel">
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Закрыть">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h2>Пользовательское соглашение:</h2>
                                            <p>1. Для совершения покупок необходимо зарегистрировать аккаунт в магазине.
                                            </p>
                                            <p>2. При регистрации предоставьте достоверную информацию о себе.</p>
                                            <p>3. Нельзя использовать данные других лиц.</p>
                                            <p>4. Интернет-магазин <b>НЕ</b> несет ответственность за финансовые
                                                гарантии. </p>
                                            <p>5. Интернет-магазин <b>НЕ</b> несет ответственность за предоставление
                                                товаров.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Закрыть</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
                        </form>
                        <?php if ($message): ?>
                            <div class="alert alert-info mt-3">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../js/register/register.js"></script>

</body>

</html>