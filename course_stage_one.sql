-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 13 2022 г., 15:24
-- Версия сервера: 8.0.24
-- Версия PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `course_stage_one`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int NOT NULL DEFAULT '2' COMMENT '1-admin\r\n2-default user',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `job` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `vk` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `tg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `inst` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `username`, `job`, `phone`, `address`, `status`, `avatar`, `vk`, `tg`, `inst`) VALUES
(51, 'admin@admin', '$2y$10$lrMtH.I089yrbtJHEjh/u.uRxNlVlwTOAi0vphdscOd/R/JTOfWXm', 1, 'Админ', 'Сайт', '346735467346', 'Колпино', 3, NULL, NULL, NULL, NULL),
(52, 'vik@vv', '$2y$10$cl9xIrjSIF9CXnIy2uZadO9DtBwXyyqUUBIu6I88BXmarZsc0KBCC', 2, 'Викторg', 'Завод', '564364234', 'Москва ул.Мира', 2, '62a72be94f4b9.jpeg', '', 'tg', ''),
(53, 'ma@m', '$2y$10$1ca9pLAnjFHl92ORwLGvyOhsk8PrQOHTRCV2/AmvCrd9zbP9muprO', 2, 'Мария', 'Кофейня', '646342272', 'Колпино', 1, '62a72b5a4387d.jpeg', 'vk', '', 'inst');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
