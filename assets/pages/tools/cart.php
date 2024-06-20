<?php
session_start();
include '../../pages/system_files/db_connect.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: ../tools/login.php');
  exit();
}

$userId = $_SESSION['user_id'];

$query = "SELECT p.id, p.name, p.price, c.quantity FROM products p INNER JOIN cart c ON p.id = c.product_id WHERE c.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>



<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Корзина | TacliteBay</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/cart/cart.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
  <main class="container mt-5">
    <div class="row">
      <div class="col">
        <a href="../../../index.php" class="btn btn-primary mb-3">Назад</a>
        <h1 class="mb-4">Ваша корзина</h1>
        <div class="table-responsive">
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
                <th>Действия</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total = 0;
              while ($row = $result->fetch_assoc()) {
                $subtotal = $row['price'] * $row['quantity'];
                $total += $subtotal;
                ?>
                <tr>
                  <td>
                    <?php echo htmlspecialchars($row['name']); ?>
                  </td>
                  <td>
                    <?php echo htmlspecialchars($row['price']); ?> руб.
                  </td>
                  <td>
                    <?php echo htmlspecialchars($row['quantity']); ?>
                  </td>
                  <td>
                    <?php echo htmlspecialchars($subtotal); ?> руб.
                  </td>
                  <td>
                    <a href="./remove_from_cart.php?product_id=<?php echo $row['id']; ?>"
                      class="btn btn-danger btn-sm">Удалить</a>
                  </td>
                </tr>
                <?php
              }
              ?>
              <tr>
                <td colspan="3" class="font-weight-bold">Итого:</td>
                <td colspan="2" class="font-weight-bold">
                  <?php echo htmlspecialchars($total); ?> руб.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#checkoutModal">Оформить заказ</a>
      </div>
    </div>
  </main>
  <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content custom-modal-content">
        <div class="modal-header custom-modal-header">
          <h5 class="modal-title" id="checkoutModalLabel">Подтверждение заказа</h5>
          <button type="button" class="close custom-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body custom-modal-body">
          <div class="order-summary">
            <div id="modal-cart-items"></div>
            <div class="order-total">
              <span>Итого к оплате:</span>
              <span id="modal-total-price" class="order-price"></span>
            </div>
            <div class="payment-method">
              <label for="paymentMethod">Выберите метод оплаты</label>
              <select id="paymentMethod" class="form-control custom-select">
                <option>Банковская карта</option>
                <option>PayPal</option>
                <option>Биткоин</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer custom-modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Отменить</button>
          <button type="button" class="btn btn-primary" id="confirmPayment">Подтвердить оплату</button>
          <script>
            document.getElementById("confirmPayment").addEventListener("click", function () {
              var xhr = new XMLHttpRequest();
              xhr.open("POST", "./clear_cart.php", true);
              xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                  if (xhr.status === 200) {
                    alert("Заказ успешно оформлен и корзина очищена.");
                    window.location.reload();
                  } else {
                    alert("Произошла ошибка при оформлении заказа: " + xhr.statusText);
                  }
                }
              };
              xhr.send();
            });
          </script>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function () {
      $('#checkoutModal').on('show.bs.modal', function (event) {
        $('#modal-cart-items').empty();
        var total = 0;
        <?php
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
          ?>
          var itemName = "<?php echo htmlspecialchars($row['name']); ?>";
          var itemPrice = "<?php echo htmlspecialchars($row['price']); ?>";
          var itemQuantity = "<?php echo htmlspecialchars($row['quantity']); ?>";
          var itemSubtotal = itemPrice * itemQuantity;
          var itemHtml = '<div class="order-item">' +
            '<span>' + itemName + ' x ' + itemQuantity + '</span>' +
            '<span class="order-price">' + itemSubtotal.toFixed(2) + ' руб.</span>' +
            '</div>';
          $('#modal-cart-items').append(itemHtml);
          total += itemSubtotal;
        <?php } ?>
        $('#modal-total-price').text(total.toFixed(2) + ' руб.');
      });
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>