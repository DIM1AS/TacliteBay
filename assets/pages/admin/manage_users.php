<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../tools/login.php../tools/login.php');
    exit;
}

include '../../pages/system_files/db_connect.php';

if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Пользователь удален.";
    } else {
        $_SESSION['error'] = "Ошибка при удалении пользователя: " . $stmt->error;
    }
    $stmt->close();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['toggle_admin']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $is_admin = $_GET['toggle_admin'] == '1' ? 1 : 0;

    $stmt = $conn->prepare("UPDATE users SET is_admin = ? WHERE id = ?");
    $stmt->bind_param("ii", $is_admin, $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Статус пользователя изменен.";
    } else {
        $_SESSION['error'] = "Ошибка при изменении статуса пользователя: " . $stmt->error;
    }
    $stmt->close();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $patronymic = $_POST['patronymic'];
    $login = $_POST['login'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, surname = ?, patronymic = ?, login = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $name, $surname, $patronymic, $login, $email, $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Пользователь обновлен.";
    } else {
        $_SESSION['error'] = "Ошибка при обновлении пользователя: " . $stmt->error;
    }
    $stmt->close();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$result = $conn->query("SELECT * FROM users");
?>



<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Управление пользователями | TacliteBay</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../../../favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Управление пользователями</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../admin/admin.php">&larr; Назад в админ-панель</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <h1 class="my-4">Список пользователей</h1>
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php echo $row['id']; ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($row['name']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($row['email']); ?>
                        </td>
                        <td>
                            <?php echo $row['is_admin'] == 1 ? 'Админ' : 'Пользователь'; ?>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal"
                                data-id="<?php echo $row['id']; ?>"
                                data-name="<?php echo htmlspecialchars($row['name']); ?>"
                                data-surname="<?php echo htmlspecialchars($row['surname']); ?>"
                                data-patronymic="<?php echo htmlspecialchars($row['patronymic']); ?>"
                                data-login="<?php echo htmlspecialchars($row['login']); ?>"
                                data-email="<?php echo htmlspecialchars($row['email']); ?>">Редактировать</button>
                            <a href="?delete=1&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?');">Удалить</a>
                            <a href="?toggle_admin=<?php echo $row['is_admin'] ? '0' : '1'; ?>&id=<?php echo $row['id']; ?>"
                                class="btn btn-<?php echo $row['is_admin'] ? 'secondary' : 'success'; ?> btn-sm"
                                onclick="return confirm('Вы уверены, что хотите <?php echo $row['is_admin'] ? 'снять администратора' : 'назначить администратором'; ?> этого пользователя?');">
                                <?php echo $row['is_admin'] ? 'Снять администратора' : 'Назначить админом'; ?>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Редактировать пользователя</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="post" action="">
                        <input type="hidden" id="editUserId" name="id">
                        <div class="form-group">
                            <label for="editUserName">Имя</label>
                            <input type="text" class="form-control" id="editUserName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editUserSurname">Фамилия</label>
                            <input type="text" class="form-control" id="editUserSurname" name="surname" required>
                        </div>
                        <div class="form-group">
                            <label for="editUserPatronymic">Отчество</label>
                            <input type="text" class="form-control" id="editUserPatronymic" name="patronymic">
                        </div>
                        <div class="form-group">
                            <label for="editUserLogin">Логин</label>
                            <input type="text" class="form-control" id="editUserLogin" name="login" required>
                        </div>
                        <div class="form-group">
                            <label for="editUserEmail">Email</label>
                            <input type="email" class="form-control" id="editUserEmail" name="email" required>
                        </div>
                        <button type="submit" name="edit_user" class="btn btn-primary">Сохранить изменения</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#editUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#editUserId').val(button.data('id'));
            modal.find('#editUserName').val(button.data('name'));
            modal.find('#editUserSurname').val(button.data('surname'));
            modal.find('#editUserPatronymic').val(button.data('patronymic'));
            modal.find('#editUserLogin').val(button.data('login'));
            modal.find('#editUserEmail').val(button.data('email'));
        });
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>