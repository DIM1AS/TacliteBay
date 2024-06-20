<?php
session_start();
function checkUserLoggedIn()
{
    return isset($_SESSION['name']);
}

$userLoggedIn = checkUserLoggedIn();

?>
<?php
include 'assets/pages/system_files/db_connect.php';

$query = "SELECT * FROM products";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
    <title>Главная | TacliteBay</title>
    <link rel="stylesheet" href="assets/css/index/index.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</head>

<body>
<header>
    <div class="logo-section">
        <img src="assets/img/index/header/logo.png" alt="Логотип TacliteBay">
        <h1>| TacliteBay - надёжный выбор мужчин!</h1>
    </div>
    <nav class="menu">
        <a href="#about-us">О нас</a>
        <a href="#catalog-section">Каталог</a>
        <a href="#contact-section">Где нас найти</a>
        <?php if ($userLoggedIn) : ?>
            <span>Привет,
                    <?php echo htmlspecialchars($_SESSION['name']); ?>
                </span>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) : ?>
                <a href="assets/pages/admin/admin.php"><i class="fas fa-cog"></i></a>
            <?php else : ?>
                <a href="assets/pages/tools/myaccount.php"><i class="fas fa-user"></i></a>
            <?php endif; ?>
            <a href="assets/pages/tools/cart.php"><i class="fas fa-shopping-cart"></i></a>
            <a href="assets/pages/tools/logout.php"><i class="fas fa-sign-out-alt"></i></a>
        <?php else : ?>
            <button class="auth-btn"><a href="assets/pages/tools/login.php">Войти</a></button>
            <button class="auth-btn"><a href="assets/pages/tools/register.php">Регистрация</a></button>
        <?php endif; ?>
    </nav>
</header>
<section class="about-us" id="about-us">
    <h2 class="about_o">О нас</h2>
    <div class="about-content">
        <div class="about-description">
            <p>TacliteBay – это ведущий магазин по продаже военных товаров, созданный для удовлетворения потребностей
                профессионалов и энтузиастов в области тактического снаряжения. Мы предлагаем широкий ассортимент
                продукции, включающий военную форму, экипировку, аксессуары и снаряжение для активного отдыха.</p>
        </div>
        <div class="about-slider">
            <script src="assets/js/index/index.js"></script>
            <p class="call_0">Наши новинки:</p>
            <div class="about-slide" id="aboutSlide1">
                <img src="assets/img/index/slider/one.jpg" alt="Фото_1">
            </div>
            <div class="about-slide" id="aboutSlide2">
                <img src="assets/img/index/slider/one.jpg" alt="Фото_2">
            </div>
            <div class="call_1">
                <button class="slider-btn slider-prev">❮</button>
                <button class="slider-btn slider-next">❯</button>
            </div>
        </div>
    </div>
</section>
<section class="catalog-section" id="catalog-section">
    <h2 class="catalog-title">Каталог товаров:</h2>
    <div class="products-wrapper">
        <div class="products-container">
            <?php while ($product = $result->fetch_assoc()) : ?>
                <div class="product">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>"
                         alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3>
                        <?php echo htmlspecialchars($product['name']); ?>
                    </h3>
                    <p>
                        <?php echo htmlspecialchars($product['description']); ?>
                    </p>
                    <p>Цена:
                        <?php echo htmlspecialchars($product['price']); ?> руб.
                    </p>
                    <form action="assets/pages/tools/add_to_cart.php" method="post" style="margin-top: auto;">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit">Добавить в корзину</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<section class="contact-section" id="contact-section">
    <div class="contact-map" id="map">
        <iframe class="contact-map"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2341.5072906739533!2d38.47353957611988!3d54.06474657250634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x413684e59ea00ce3%3A0x16be51fb21b7dbfd!2z0KHQsdC10YDQkdCw0L3Qug!5e0!3m2!1sru!2sru!4v1699777048409!5m2!1sru!2sru"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="contact-info">
        <h2>Где нас найти</h2>
        <p><strong>Адрес:</strong> Г. Новомосковск, мкр. Сокольники, ул. Шахтреская, д.17</p>
        <p><strong>Телефон:</strong> +7 (993) 538-08-20</p>
        <p><strong>Email:</strong> D.I.M.1.A.S@yandex.ru</p>
        <p><strong>Часы работы:</strong> Пн-Пт: 9:00 - 18:00, Сб-Вс: выходной</p>
    </div>
</section>
<footer class="footer-section">
    <div class="footer-logo-section">
        <img src="assets/img/index/header/logo.png" alt="Логотип TacliteBay">
        <h1>| TacliteBay </h1>
    </div>
    <nav class="footer-menu">
        <a href="#about-us">О нас</a>
        <a href="#catalog-section">Каталог</a>
        <a href="#contact-section">Где нас найти</a>
    </nav>
</footer>

</body>

</html>