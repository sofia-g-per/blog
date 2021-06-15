-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 13 2021 г., 11:17
-- Версия сервера: 8.0.19
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `practica_pervukhina`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` varchar(245) NOT NULL,
  `author` int NOT NULL,
  `post` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `date_created`, `text`, `author`, `post`) VALUES
(1, '2021-06-08 10:25:14', 'Love this picture of me!                                      ', 1, 8),
(2, '2021-06-08 10:26:30', 'Love this picture of me!                                      ', 1, 8),
(3, '2021-06-08 10:45:01', '                                      Really love this pic of me!', 1, 8),
(5, '2021-06-08 14:40:15', 'Wonderful!!!                                                                                            ', 1, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `content_type`
--

CREATE TABLE `content_type` (
  `class_name` varchar(145) NOT NULL,
  `name` varchar(145) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `content_type`
--

INSERT INTO `content_type` (`class_name`, `name`) VALUES
('video', 'Видео'),
('photo', 'Картинка'),
('link', 'Ссылка'),
('text', 'Текст'),
('quote', 'Цитата');

-- --------------------------------------------------------

--
-- Структура таблицы `hashtags`
--

CREATE TABLE `hashtags` (
  `post_id` int NOT NULL,
  `hashtag` varchar(145) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `hashtags`
--

INSERT INTO `hashtags` (`post_id`, `hashtag`) VALUES
(10, 'addpostlink'),
(10, 'newpost'),
(10, 'test'),
(11, ''),
(12, 'sad'),
(12, 'snek'),
(12, 'sadsnekissad'),
(13, 'hi');

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE `likes` (
  `user` int NOT NULL,
  `post` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `likes`
--

INSERT INTO `likes` (`user`, `post`) VALUES
(1, 10),
(1, 8),
(1, 9),
(3, 9),
(3, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `sender` int NOT NULL,
  `receipient` int NOT NULL,
  `text` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `date_created`, `sender`, `receipient`, `text`) VALUES
(1, '2021-06-11 12:55:50', 6, 1, 'Hi');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(245) NOT NULL,
  `content` varchar(1024) NOT NULL,
  `views` int NOT NULL DEFAULT '0',
  `author` int NOT NULL,
  `content_type` varchar(145) NOT NULL,
  `quote_author` varchar(245) DEFAULT NULL,
  `repost` tinyint(1) NOT NULL DEFAULT '0',
  `original_author` int DEFAULT NULL COMMENT 'Only if the post is a repost',
  `original_post_id` int DEFAULT NULL COMMENT 'Only if post is a repost',
  `likes_num` int NOT NULL DEFAULT '0',
  `repost_num` int NOT NULL DEFAULT '0',
  `comments_num` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `date_created`, `title`, `content`, `views`, `author`, `content_type`, `quote_author`, `repost`, `original_author`, `original_post_id`, `likes_num`, `repost_num`, `comments_num`) VALUES
(1, '2021-06-04 12:39:57', 'My first post', 'hello', 28, 1, 'text', NULL, 0, NULL, NULL, 0, 0, 0),
(2, '2021-06-04 12:41:52', 'My second post', 'Yay!', 1, 1, 'text', NULL, 0, NULL, NULL, 5, 0, 0),
(3, '2021-06-04 12:45:01', 'Pain', 'uploads/60b9f61d0adf3Снимок экрана 2021-05-14 111142.jpg', 5, 1, 'photo', NULL, 0, NULL, NULL, 0, 0, 0),
(6, '2021-06-04 12:48:52', 'sad snek', 'uploads/60b9f704aa3fdsad snek.jpg', 1, 1, 'photo', NULL, 0, NULL, NULL, 0, 0, 0),
(8, '2021-06-04 13:03:42', 'Фотография', 'uploads/60b9fa7e868basad snek.jpg', 109, 1, 'photo', NULL, 0, NULL, NULL, 6, 0, 0),
(9, '2021-06-04 13:16:48', 'Великие высказывания великих людей', 'Сложно жить, когда жить сложно', 56, 1, 'quote', 'Панфилова М.Ю.', 0, NULL, NULL, 2, 1, 0),
(10, '2021-06-04 13:32:58', 'Add a post!', 'http://practica/adding-post.php', 33, 1, 'link', NULL, 0, NULL, NULL, 2, 0, 0),
(12, '2021-06-04 14:45:03', 'Return of sad snek', 'uploads/60ba123f66abfsad snek.jpg', 7, 1, 'photo', NULL, 0, NULL, NULL, 2, 0, 0),
(13, '2021-06-04 15:16:51', 'Hello', 'uploads/60ba19b3a3bfbsad snek.jpg', 0, 1, 'photo', NULL, 0, NULL, NULL, 0, 0, 0),
(14, '2021-06-08 13:33:10', 'Великие высказывания великих людей', 'Сложно жить, когда жить сложно', 2, 3, 'quote', 'Панфилова М.Ю.', 1, 1, 9, 0, 0, 0),
(15, '2021-06-11 17:52:20', 'Alan! Alan!', 'https://www.youtube.com/watch?v=xaPepCVepCg&list=PLGy6F-Kml5BV4S0E8axqixqvVbL3hV27O&index=221', 9, 5, 'video', NULL, 0, NULL, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `subscriptions`
--

CREATE TABLE `subscriptions` (
  `user` int NOT NULL,
  `subscriber` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subscriptions`
--

INSERT INTO `subscriptions` (`user`, `subscriber`) VALUES
(3, 1),
(1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(245) NOT NULL,
  `email` varchar(100) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_pic` varchar(245) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `reg_date`, `profile_pic`) VALUES
(1, 'user1', '$2y$10$K8v4sXh2F5WsMITSxSc8Cup/mlugOmTwwgrRy71nE2/1Lx0eiZkTO', 'user1@gmail.com', '2021-06-04 11:06:47', 'uploads/60b9df1706a19sad snek.jpg'),
(3, 'user2', '$2y$10$7Ix3SrIuwLnOipE09rMnPurMjjLpxyv39BQ4VQrD.LwoDyGlUkFYC', 'user2@gmail.com', '2021-06-08 13:03:24', 'uploads/60bf406cddc0eСнимок экрана 2021-05-14 111142.jpg'),
(4, 'user3', '$2y$10$NLU/AlTqpvBb/wMpenfYMOQxL3FVvYTsWdLJifA0rVGh1i4gPcAQ2', 'user3@gmail.com', '2021-06-11 09:49:05', 'uploads/60c30761ca30fзагружено (1).jpg'),
(5, 'user4', '$2y$10$2.zHgcxduBURI3wFDwONlOBSs3PNYcaiCRBzupWryhoNcSRmeNndy', 'user4@gmail.com', '2021-06-11 09:51:09', 'uploads/60c307dd295d8загружено.jpg'),
(6, 'user5', '$2y$10$9fp6kISlgQJFxtvLAWWqQuPYqqW8JxUooBKHo0PhN10WtofTPYuum', 'user5@gmail.com', '2021-06-11 09:51:30', 'uploads/60c307f2832e1загружено.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_Comments_Users1_idx` (`author`),
  ADD KEY `fk_Comments_Posts1_idx` (`post`);

--
-- Индексы таблицы `content_type`
--
ALTER TABLE `content_type`
  ADD PRIMARY KEY (`class_name`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`),
  ADD UNIQUE KEY `class_name_UNIQUE` (`class_name`);

--
-- Индексы таблицы `hashtags`
--
ALTER TABLE `hashtags`
  ADD KEY `fk_Hashtags_Posts1_idx` (`post_id`);

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD KEY `fk_Likes_Posts1_idx` (`post`),
  ADD KEY `fk_Likes_Users1` (`user`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender` (`sender`),
  ADD KEY `receipient` (`receipient`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_Posts_Users_idx` (`author`),
  ADD KEY `fk_Posts_Users1_idx` (`original_author`),
  ADD KEY `fk_Posts_Content_type1_idx` (`content_type`);

--
-- Индексы таблицы `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD KEY `fk_Subscriptions_Users1_idx` (`user`),
  ADD KEY `fk_Subscriptions_Users2_idx` (`subscriber`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id_UNIQUE` (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`login`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_Comments_Posts1` FOREIGN KEY (`post`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `fk_Comments_Users1` FOREIGN KEY (`author`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `hashtags`
--
ALTER TABLE `hashtags`
  ADD CONSTRAINT `fk_Hashtags_Posts1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Ограничения внешнего ключа таблицы `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_Likes_Posts1` FOREIGN KEY (`post`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `fk_Likes_Users1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receipient`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_Posts_Content_type1` FOREIGN KEY (`content_type`) REFERENCES `content_type` (`class_name`),
  ADD CONSTRAINT `fk_Posts_Users` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_Posts_Users1` FOREIGN KEY (`original_author`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `fk_Subscriptions_Users1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_Subscriptions_Users2` FOREIGN KEY (`subscriber`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
