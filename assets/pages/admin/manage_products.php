<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../tools/login.php');
    exit;
}

include '../../pages/system_files/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $imagePath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../../../assets/img/index/catalog/';

        // Создаем директорию, если она не существует
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagePath = '../../../assets/img/index/catalog/' . $fileName;
        } else {
            echo "<p>Произошла ошибка при загрузке файла.</p>";
        }
    }

    if (isset($_POST['add_product'])) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $description, $price, $imagePath);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "";
        } else {
            echo "<p>Ошибка при добавлении товара.</p>";
        }

        $stmt->close();
    } elseif (isset($_POST['edit_product'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?" . ($imagePath ? ", image = ?" : "") . " WHERE id = ?");
        if ($imagePath) {
            $stmt->bind_param("ssdsi", $name, $description, $price, $imagePath, $id);
        } else {
            $stmt->bind_param("ssdi", $name, $description, $price, $id);
        }
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "";
        } else {
            echo "<p>Ошибка при обновлении товара.</p>";
        }

        $stmt->close();
    }
}

$query = "SELECT * FROM products";
$result = $conn->query($query);

?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление товарами | TacliteBay</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../../../favicon.ico" type="image/x-icon">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Управление товарами</a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ml-auto">
            <a class="nav-link" href="../admin/admin.php">&larr; Назад в админ-панель</a>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Существующие товары</h2>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProductModal">
            Добавить товар
        </button>
    </div>
    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th>Название</th>
            <th>Описание</th>
            <th>Цена</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td>
                    <button class="btn btn-primary btn-sm btn-edit" data-id="<?php echo $row['id']; ?>"
                            data-name="<?php echo htmlspecialchars($row['name']); ?>"
                            data-description="<?php echo htmlspecialchars($row['description']); ?>"
                            data-price="<?php echo htmlspecialchars($row['price']); ?>"
                            data-image="<?php echo htmlspecialchars($row['image']); ?>">Редактировать</button>
                    <a href="../tools/delete_product.php?id=<?php echo $row['id']; ?>"
                       class="btn btn-danger btn-sm">Удалить</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<div class="container mt-4">
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Добавить новый товар</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="productName">Название товара</label>
                            <input type="text" class="form-control" id="productName" name="name"
                                   placeholder="Введите название" required>
                        </div>
                        <div class="form-group">
                            <label for="productDescription">Описание товара</label>
                            <textarea class="form-control" id="productDescription" name="description"
                                      placeholder="Введите описание" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Цена</label>
                            <input type="number" class="form-control" id="productPrice" name="price"
                                   placeholder="Укажите цену" required>
                        </div>
                        <div class="form-group">
                            <label for="productImage">Изображение товара</label>
                            <input type="file" class="form-control-file" id="productImage" name="image">
                        </div>
                        <button type="submit" name="add_product" class="btn btn-primary">Добавить товар</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Редактировать товар</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="editProductId" name="id">
                    <div class="form-group">
                        <label for="editProductName">Название товара</label>
                        <input type="text" class="form-control" id="editProductName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editProductDescription">Описание товара</label>
                        <textarea class="form-control" id="editProductDescription" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editProductPrice">Цена</label>
                        <input type="number" class="form-control" id="editProductPrice" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="editProductImage">Изображение товара</label>
                        <input type="file" class="form-control-file" id="editProductImage" name="image">
                    </div>
                    <button type="submit" name="edit_product" class="btn btn-primary">Сохранить изменения</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('.btn-edit').on('click', function () {
            var productId = $(this).data('id');
            var productName = $(this).data('name');
            var productDescription = $(this).data('description');
            var productPrice = $(this).data('price');
            var productImage = $(this).data('image');
            $('#editProductId').val(productId);
            $('#editProductName').val(productName);
            $('#editProductDescription').val(productDescription);
            $('#editProductPrice').val(productPrice);
            $('#editProductCurrentImage').attr('src', productImage);
            $('#editProductModal').modal('show');
        });
    });
</script>
</body>

</html>
