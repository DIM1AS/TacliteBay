-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 19 2024 г., 23:30
-- Версия сервера: 5.7.27-30
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `u2662377_taclitebay`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `date_added`) VALUES
(24, 2, 1, 1, '2024-03-22 06:43:21');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `total_price`, `order_date`) VALUES
(1, 3, 2, 1, NULL, '2024-06-05 10:31:39'),
(2, 1, 7, 1, NULL, '2024-06-17 06:43:08'),
(3, 1, 2, 1, NULL, '2024-06-17 06:43:08'),
(4, 1, 6, 1, NULL, '2024-06-17 06:43:08'),
(5, 5, 1, 1, NULL, '2024-06-17 06:52:15'),
(6, 4, 1, 5, NULL, '2024-06-17 07:35:07'),
(7, 4, 1, 1, NULL, '2024-06-17 10:13:57');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) VALUES
(1, 'Ð¢Ð°ÐºÑ‚Ð¸Ñ‡ÐµÑÐºÐ¸Ð¹ Ñ€ÑŽÐºÐ·Ð°Ðº \"Ð‘Ð¾ÐµÑ†\"', 'Ð’Ð¼ÐµÑÑ‚Ð¸Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ð¹ Ñ€ÑŽÐºÐ·Ð°Ðº Ð¸Ð· Ð¿Ñ€Ð¾Ñ‡Ð½Ð¾Ð³Ð¾ Ð²Ð¾Ð´Ð¾Ð¾Ñ‚Ñ‚Ð°Ð»ÐºÐ¸Ð²Ð°ÑŽÑ‰ÐµÐ³Ð¾ Ð¼Ð°Ñ‚ÐµÑ€Ð¸Ð°Ð»Ð°, Ð¾Ð±ÑŠÐµÐ¼ 50 Ð»Ð¸Ñ‚Ñ€Ð¾Ð², Ñ Ð¼Ð½Ð¾Ð¶ÐµÑÑ‚Ð²Ð¾Ð¼ ÐºÐ°Ñ€Ð¼Ð°Ð½Ð¾Ð² Ð¸ Ð¾Ñ‚Ð´ÐµÐ»ÐµÐ½Ð¸Ð¹ Ð´Ð»Ñ ÑƒÐ´Ð¾Ð±Ð½Ð¾Ð³Ð¾ Ñ…Ñ€Ð°Ð½ÐµÐ½Ð¸Ñ ÑÐ½Ð°Ñ€ÑÐ¶ÐµÐ½Ð¸Ñ.', '4500.00', '../../../assets/img/index/catalog/1716880307_sk_00000451_1-899x1199.jpg'),
(2, 'ÐšÐ°Ð¼ÑƒÑ„Ð»ÑÐ¶Ð½Ñ‹Ð¹ ÐºÐ¾ÑÑ‚ÑŽÐ¼ \"ÐŸÐ°Ñ€Ñ‚Ð¸Ð·Ð°Ð½\"', 'ÐšÐ¾ÑÑ‚ÑŽÐ¼ Ð¸Ð· Ð´Ñ‹ÑˆÐ°Ñ‰ÐµÐ³Ð¾ Ð¸ Ð¸Ð·Ð½Ð¾ÑÐ¾ÑÑ‚Ð¾Ð¹ÐºÐ¾Ð³Ð¾ Ð¼Ð°Ñ‚ÐµÑ€Ð¸Ð°Ð»Ð°, Ð¾Ð±ÐµÑÐ¿ÐµÑ‡Ð¸Ð²Ð°ÐµÑ‚ Ð¾Ñ‚Ð»Ð¸Ñ‡Ð½ÑƒÑŽ Ð¼Ð°ÑÐºÐ¸Ñ€Ð¾Ð²ÐºÑƒ Ð² Ð»ÐµÑÐ¸ÑÑ‚Ð¾Ð¹ Ð¼ÐµÑÑ‚Ð½Ð¾ÑÑ‚Ð¸. Ð’ ÐºÐ¾Ð¼Ð¿Ð»ÐµÐºÑ‚Ðµ ÐºÑƒÑ€Ñ‚ÐºÐ° Ð¸ ÑˆÑ‚Ð°Ð½Ñ‹.', '3200.00', '../../../assets/img/index/catalog/1716880390_partizan-suit-sso-specter-5.jpg'),
(3, 'Ð¢Ð°ÐºÑ‚Ð¸Ñ‡ÐµÑÐºÐ¸Ðµ Ð¿ÐµÑ€Ñ‡Ð°Ñ‚ÐºÐ¸ \"ÐÑ‚Ð°ÐºÐ°\"', 'ÐŸÐµÑ€Ñ‡Ð°Ñ‚ÐºÐ¸ Ñ Ð·Ð°Ñ‰Ð¸Ñ‚Ð½Ñ‹Ð¼Ð¸ Ð²ÑÑ‚Ð°Ð²ÐºÐ°Ð¼Ð¸ Ð½Ð° ÐºÐ¾ÑÑ‚ÑÑˆÐºÐ°Ñ…, Ð¾Ð±ÐµÑÐ¿ÐµÑ‡Ð¸Ð²Ð°ÑŽÑ‚ Ð½Ð°Ð´ÐµÐ¶Ð½Ñ‹Ð¹ Ñ…Ð²Ð°Ñ‚ Ð¸ Ð·Ð°Ñ‰Ð¸Ñ‚Ñƒ Ñ€ÑƒÐº Ð² Ð»ÑŽÐ±Ñ‹Ñ… ÑƒÑÐ»Ð¾Ð²Ð¸ÑÑ….', '1200.00', '../../../assets/img/index/catalog/1716880435_13388f7a55f57b6af7ed66fb208bf084.jpg'),
(4, 'ÐÑ€Ð¼ÐµÐ¹ÑÐºÐ¸Ðµ Ð±Ð¾Ñ‚Ð¸Ð½ÐºÐ¸ \"Ð”ÐµÑÐ°Ð½Ñ‚\"', 'Ð’Ñ‹ÑÐ¾ÐºÐ¸Ðµ ÐºÐ¾Ð¶Ð°Ð½Ñ‹Ðµ Ð±Ð¾Ñ‚Ð¸Ð½ÐºÐ¸ Ñ ÑƒÑÐ¸Ð»ÐµÐ½Ð½Ð¾Ð¹ Ð¿Ð¾Ð´Ð¾ÑˆÐ²Ð¾Ð¹, Ð¾Ð±ÐµÑÐ¿ÐµÑ‡Ð¸Ð²Ð°ÑŽÑ‚ ÐºÐ¾Ð¼Ñ„Ð¾Ñ€Ñ‚ Ð¸ Ð·Ð°Ñ‰Ð¸Ñ‚Ñƒ Ð½Ð¾Ð³ Ð² ÑÐºÑÑ‚Ñ€ÐµÐ¼Ð°Ð»ÑŒÐ½Ñ‹Ñ… ÑƒÑÐ»Ð¾Ð²Ð¸ÑÑ….', '5000.00', '../../../assets/img/index/catalog/1716880580_s-l1600.jpg'),
(5, 'ÐœÐ½Ð¾Ð³Ð¾Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ð¹ Ð½Ð¾Ð¶ \"Ð¡Ð¿ÐµÑ†Ð½Ð°Ð·\"', 'ÐšÐ¾Ð¼Ð¿Ð°ÐºÑ‚Ð½Ñ‹Ð¹ Ð½Ð¾Ð¶ Ñ Ð½ÐµÑÐºÐ¾Ð»ÑŒÐºÐ¸Ð¼Ð¸ Ð»ÐµÐ·Ð²Ð¸ÑÐ¼Ð¸ Ð¸ Ð¸Ð½ÑÑ‚Ñ€ÑƒÐ¼ÐµÐ½Ñ‚Ð°Ð¼Ð¸, Ð¸Ð´ÐµÐ°Ð»ÑŒÐ½Ð¾ Ð¿Ð¾Ð´Ñ…Ð¾Ð´Ð¸Ñ‚ Ð´Ð»Ñ Ð²Ñ‹Ð¶Ð¸Ð²Ð°Ð½Ð¸Ñ Ð¸ Ñ‚Ð°ÐºÑ‚Ð¸Ñ‡ÐµÑÐºÐ¸Ñ… Ð·Ð°Ð´Ð°Ñ‡.', '1800.00', '../../../assets/img/index/catalog/1716880630_1557747500189418683.jpg'),
(7, 'ccc', 'ccc', '100.00', '');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patronymic` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `patronymic`, `login`, `email`, `password`, `is_admin`) VALUES
(1, 'ÐšÐ¸Ñ€Ð¸Ð»Ð» ', 'Ð›Ð°Ð²Ñ€Ð¾Ð² ', 'ÐœÐ°ÐºÑÐ¸Ð¼Ð¾Ð²Ð¸Ñ‡', 'GREM', 'd1ima.kostiasev@mail.ru', '$2y$10$X0lG4BFtWEYhQ0WbXdIvOuXDP2b1QpIN02PNOV7lus.XtWUhlXwoW', 1),
(3, 'ÐÑ€Ñ‚ÐµÐ¼', 'Ð•Ð³Ð¾Ñ€Ð¾Ð²', 'ÐŸÐ°Ð²Ð»Ð¾Ð²Ð¸Ñ‡', 'jkj', 'ssss@test', '$2y$10$RLbA1VQDPFcCeyGjQOdRe.xg7bAjYBeUQ6bMo5SHkgZh3wgY/UzRK', 0),
(4, 'Ð”Ð¼Ð¸Ñ‚Ñ€Ð¸Ð¹', 'ÐšÐ¾ÑÑ‚ÑÑˆÐµÐ²', 'ÐžÐ»ÐµÐ³Ð¾Ð²Ð¸Ñ‡', 'dim1as', 'dima.kostiasev@mail.ru', '$2y$10$XXjCAYXalE75V8SVNg3v0O9KncDD6kIEJ6uC0HALNKb4qP5KUK8Q6', 0),
(5, 'Ð¡ÐµÑ€Ð³ÐµÐ¹ ', 'Ð›Ð°Ð²Ñ€Ð¾Ð²', 'ÐÐ¸ÐºÐ¾Ð»Ð°ÐµÐ²Ð¸Ñ‡ ', 'admin', 'admin@mail.ru', '$2y$10$B8rcRl1XpqZPR4chMSCFPukRwnbj/yN4H7Afj2tVGJkwKUpHlS02q', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
