-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 08 2024 г., 13:51
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `prevention_advice`
--

-- --------------------------------------------------------

--
-- Структура таблицы `pa_advices`
--

CREATE TABLE `pa_advices` (
  `id` int NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pa_advices_students`
--

CREATE TABLE `pa_advices_students` (
  `id` int NOT NULL,
  `advices_id` int NOT NULL,
  `students_id` int NOT NULL,
  `reason` text COLLATE utf8mb4_general_ci,
  `result` text COLLATE utf8mb4_general_ci,
  `protocol` text COLLATE utf8mb4_general_ci,
  `decree` text COLLATE utf8mb4_general_ci,
  `remark` text COLLATE utf8mb4_general_ci,
  `reprimand` text COLLATE utf8mb4_general_ci,
  `note` text COLLATE utf8mb4_general_ci,
  `liquidation_period` text COLLATE utf8mb4_general_ci,
  `memo` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pa_curators`
--

CREATE TABLE `pa_curators` (
  `id` int NOT NULL,
  `fio` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pa_groups`
--

CREATE TABLE `pa_groups` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `curators_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pa_migration`
--

CREATE TABLE `pa_migration` (
  `version` varchar(180) COLLATE utf8mb4_general_ci NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pa_migration`
--

INSERT INTO `pa_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1717841666),
('m240607_120532_create_advices_table', 1717841668),
('m240607_120904_create_curators_table', 1717841668),
('m240607_121125_create_groups_table', 1717841668),
('m240607_121758_create_students_table', 1717841668),
('m240607_122320_create_advices_students_table', 1717841668);

-- --------------------------------------------------------

--
-- Структура таблицы `pa_students`
--

CREATE TABLE `pa_students` (
  `id` int NOT NULL,
  `fio` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `birthday` date NOT NULL,
  `groups_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `pa_advices`
--
ALTER TABLE `pa_advices`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pa_advices_students`
--
ALTER TABLE `pa_advices_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advices_students-advices_id` (`advices_id`),
  ADD KEY `advices_students-students_id` (`students_id`);

--
-- Индексы таблицы `pa_curators`
--
ALTER TABLE `pa_curators`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pa_groups`
--
ALTER TABLE `pa_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups-curators_id` (`curators_id`);

--
-- Индексы таблицы `pa_migration`
--
ALTER TABLE `pa_migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `pa_students`
--
ALTER TABLE `pa_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students-groups_id` (`groups_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `pa_advices`
--
ALTER TABLE `pa_advices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `pa_advices_students`
--
ALTER TABLE `pa_advices_students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `pa_curators`
--
ALTER TABLE `pa_curators`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `pa_groups`
--
ALTER TABLE `pa_groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `pa_students`
--
ALTER TABLE `pa_students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `pa_advices_students`
--
ALTER TABLE `pa_advices_students`
  ADD CONSTRAINT `fk-advices_students-advices_id` FOREIGN KEY (`advices_id`) REFERENCES `pa_advices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-advices_students-students_id` FOREIGN KEY (`students_id`) REFERENCES `pa_students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pa_groups`
--
ALTER TABLE `pa_groups`
  ADD CONSTRAINT `fk-groups-curators_id` FOREIGN KEY (`curators_id`) REFERENCES `pa_curators` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ограничения внешнего ключа таблицы `pa_students`
--
ALTER TABLE `pa_students`
  ADD CONSTRAINT `fk-students-groups_id` FOREIGN KEY (`groups_id`) REFERENCES `pa_groups` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
