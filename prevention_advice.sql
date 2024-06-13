-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 13 2024 г., 10:43
-- Версия сервера: 5.7.39
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
  `id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `pa_advices`
--

INSERT INTO `pa_advices` (`id`, `date`) VALUES
(1, '2024-06-20'),
(2, '2024-06-27'),
(3, '2024-07-04');

-- --------------------------------------------------------

--
-- Структура таблицы `pa_advices_students`
--

CREATE TABLE `pa_advices_students` (
  `id` int(11) NOT NULL,
  `advices_id` int(11) NOT NULL,
  `students_id` int(11) NOT NULL,
  `reason` text,
  `result` text,
  `protocol` text,
  `decree` text,
  `remark` text,
  `reprimand` text,
  `note` text,
  `liquidation_period` text,
  `memo` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `pa_advices_students`
--

INSERT INTO `pa_advices_students` (`id`, `advices_id`, `students_id`, `reason`, `result`, `protocol`, `decree`, `remark`, `reprimand`, `note`, `liquidation_period`, `memo`) VALUES
(1, 1, 1, 'Академическая задолженность', 'Дисциплинарное взыскание - выговор', '', '', '', '', '', '', ''),
(2, 1, 2, 'Систематические пропуски', 'Дисциплинарное взыскание - выговор', '', '', '', '', '', '', ''),
(3, 1, 3, 'Академическая задолженность, систематические пропуски', 'Дисциплинарное взыскание - выговор', '', '', '', '', '', '', ''),
(4, 2, 1, 'Систематические пропуски', 'Дисциплинарное взыскание - выговор', '', '', '', '', '', '', ''),
(5, 2, 4, 'Академическая задолженность, систематические пропуски', 'Дисциплинарное взыскание - выговор', '', '', '', '', '', '', ''),
(6, 3, 4, 'Систематические пропуски', 'Дисциплинарное взыскание - отчисление', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `pa_curators`
--

CREATE TABLE `pa_curators` (
  `id` int(11) NOT NULL,
  `fio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `pa_curators`
--

INSERT INTO `pa_curators` (`id`, `fio`) VALUES
(1, 'Соколов А.М.'),
(2, 'Озерова А.М.'),
(3, 'Богданов М.А.'),
(4, 'Романова С.Е.');

-- --------------------------------------------------------

--
-- Структура таблицы `pa_groups`
--

CREATE TABLE `pa_groups` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `curators_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `pa_groups`
--

INSERT INTO `pa_groups` (`id`, `title`, `curators_id`) VALUES
(1, 'ИВ1-23', 3),
(2, 'ИП1-23', 3),
(3, 'М1-23', 2),
(4, 'МТ1-23', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `pa_migration`
--

CREATE TABLE `pa_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `pa_migration`
--

INSERT INTO `pa_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1718262467),
('m240607_120532_create_advices_table', 1718262489),
('m240607_120904_create_curators_table', 1718262489),
('m240607_121125_create_groups_table', 1718262489),
('m240607_121758_create_students_table', 1718262489),
('m240607_122320_create_advices_students_table', 1718262489),
('m240611_083030_create_roles_table', 1718262489),
('m240611_083136_add_roles', 1718262489),
('m240611_083300_create_users_table', 1718262489);

-- --------------------------------------------------------

--
-- Структура таблицы `pa_roles`
--

CREATE TABLE `pa_roles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `pa_roles`
--

INSERT INTO `pa_roles` (`id`, `title`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Структура таблицы `pa_students`
--

CREATE TABLE `pa_students` (
  `id` int(11) NOT NULL,
  `fio` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `groups_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `pa_students`
--

INSERT INTO `pa_students` (`id`, `fio`, `birthday`, `groups_id`) VALUES
(1, 'Карпов Д.С.', '2006-04-30', 1),
(2, 'Тарасова В.Т.', '2007-09-12', 2),
(3, 'Пугачев А.В.', '2007-08-08', 4),
(4, 'Иванов Д.А.', '2008-09-05', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `pa_users`
--

CREATE TABLE `pa_users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `pa_users`
--

INSERT INTO `pa_users` (`id`, `login`, `password`, `roles_id`, `token`) VALUES
(1, 'Admin', '$2y$13$CW3So0MMk4m1cKYbocEh.u6KQAFBV0u3BKHHGm.t1L.KXCHS8wltC', 1, NULL);

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
-- Индексы таблицы `pa_roles`
--
ALTER TABLE `pa_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Индексы таблицы `pa_students`
--
ALTER TABLE `pa_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students-groups_id` (`groups_id`);

--
-- Индексы таблицы `pa_users`
--
ALTER TABLE `pa_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `users-roles_id` (`roles_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `pa_advices`
--
ALTER TABLE `pa_advices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `pa_advices_students`
--
ALTER TABLE `pa_advices_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `pa_curators`
--
ALTER TABLE `pa_curators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `pa_groups`
--
ALTER TABLE `pa_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `pa_roles`
--
ALTER TABLE `pa_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `pa_students`
--
ALTER TABLE `pa_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `pa_users`
--
ALTER TABLE `pa_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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

--
-- Ограничения внешнего ключа таблицы `pa_users`
--
ALTER TABLE `pa_users`
  ADD CONSTRAINT `fk-users-roles_id` FOREIGN KEY (`roles_id`) REFERENCES `pa_roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
