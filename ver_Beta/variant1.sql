-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 07 2018 г., 08:45
-- Версия сервера: 10.1.36-MariaDB
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `variant1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `image_id` varchar(255) NOT NULL DEFAULT ''' ''',
  `ext` varchar(255) NOT NULL DEFAULT ''' ''',
  `click` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `image`
--

INSERT INTO `image` (`id`, `image_id`, `ext`, `click`) VALUES
(9, '5bfe31ed18692', 'jpg', 2),
(10, '5bfe33f97dcd9', 'jpg', 28),
(11, '5bfe827dbfaaa', 'jpg', 3),
(12, '5bfe8284e290c', 'jpg', 4),
(13, '5bfe828c2fed6', 'png', 5),
(14, '5bfe82945114d', 'jpg', 6),
(15, '5bfe829a753cb', 'jpg', 7),
(16, '5bfe82a993d0d', 'jpg', 8),
(17, '5bfe82adb4ad6', 'jpg', 11),
(18, '5bfe8308e5380', 'jpg', 36),
(19, '5c0131784b9ce', 'jpg', 1),
(20, '5c01317eaf551', 'jpg', 0),
(21, '5c013193186dd', 'jpg', 0),
(22, '5c075fb45ab1d', 'jpg', 1),
(23, '5c075fb9837d9', 'jpg', 0),
(24, '5c075fd8c322a', 'jpg', 0),
(25, '5c0760952d72d', 'jpg', 0),
(26, '5c0760a271e8b', 'jpg', 0),
(27, '5c0760a790531', 'jpg', 0),
(28, '5c08d97d9ecc0', 'jpg', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
