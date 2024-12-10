-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 05:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `metal_detector`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_ID` int(10) UNSIGNED NOT NULL,
  `post_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `likes` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_ID`, `post_ID`, `user_ID`, `username`, `content`, `timestamp`, `likes`) VALUES
(7, 101, 5, 'you', 'yygib', '2024-12-10 03:31:44', 2),
(8, 101, 5, 'you', 'k kj bhyjvyuvuvo', '2024-12-10 03:31:51', 2),
(9, 101, 4, 'me', 'Hello', '2024-12-10 03:51:48', 1),
(10, 105, 4, 'me', 'This is a really good review', '2024-12-10 03:57:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `comment_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment_likes`
--

INSERT INTO `comment_likes` (`comment_ID`, `user_ID`) VALUES
(7, 4),
(7, 5),
(8, 4),
(8, 5),
(9, 4),
(10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` int(10) UNSIGNED NOT NULL,
  `title` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `picture` varchar(2048) NOT NULL,
  `band` varchar(32) NOT NULL,
  `album` varchar(32) NOT NULL,
  `song` varchar(32) NOT NULL,
  `likes` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_ID`, `user_ID`, `title`, `content`, `picture`, `band`, `album`, `song`, `likes`, `date`, `timestamp`) VALUES
(101, 4, 'me', '                    moo', '', 'ma', 'mi', 'mu', 1, '0000-00-00', '2024-12-10 03:52:27'),
(103, 5, 'u', 'uibi', '', 'o', 'a', 'o', 0, '0000-00-00', '2024-12-10 03:28:14'),
(104, 5, 'vf wkj', 'ihjknbkbuj', '', 'buyv', 'bj', 'hvbi', 0, '0000-00-00', '2024-12-10 03:28:30'),
(105, 4, 'Machinist review', 'My favorite song by this band.', 'https://f4.bcbits.com/img/a1786535961_5.jpg', 'The Machinist', 'All is Not Well', 'Lysergic Lullaby', 1, '0000-00-00', '2024-12-10 03:57:31'),
(106, 5, 'Erra\'s Self titled is amazing!!', 'This album is spectacular, I literally have never listened to such a good album before in my life!', 'https://upload.wikimedia.org/wikipedia/en/0/01/Erra_Self-Titled_cover.jpg', 'Erra', 'Erra', 'Gungrave', 0, '0000-00-00', '2024-12-10 04:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `post_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`post_ID`, `user_ID`) VALUES
(101, 4),
(105, 4);

-- --------------------------------------------------------

--
-- Table structure for table `post_tag`
--

CREATE TABLE `post_tag` (
  `post_ID` int(11) UNSIGNED NOT NULL,
  `tag_ID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_tag`
--

INSERT INTO `post_tag` (`post_ID`, `tag_ID`) VALUES
(101, 40),
(103, 42),
(104, 43),
(105, 44),
(105, 45),
(106, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_ID` int(10) UNSIGNED NOT NULL,
  `tag_title` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_ID`, `tag_title`) VALUES
(37, '# yo'),
(27, '#1'),
(22, '#123'),
(24, '#1234'),
(6, '#bonJovi'),
(44, '#deathMetal'),
(5, '#Drift'),
(14, '#dumb'),
(4, '#ERRA'),
(18, '#IA '),
(19, '#IAFore'),
(20, '#IAForever'),
(43, '#ihbuib'),
(17, '#InventAnimate '),
(45, '#metalcore'),
(40, '#my'),
(2, '#post'),
(39, '#se'),
(36, '#sel'),
(34, '#self'),
(21, '#selft'),
(38, '#selftitl'),
(35, '#selftitle'),
(16, '#selftitled'),
(1, '#tag'),
(42, '#ybdhjvb'),
(41, '#yi'),
(29, '#yo'),
(30, '#yoy'),
(32, '#yoyo'),
(31, '#yoyoy'),
(33, '#yoyoyo');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(10) UNSIGNED NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `role` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `email`, `password`, `firstname`, `lastname`, `role`) VALUES
(1, 'bobjones123445@gmail.com', '$2y$10$qpFs7UDK8tslTcZNusv2j.c2od9Rcrapsd.1g3KsA9WE0iR7JyLXy', 'Nate', 'Brewer', 0),
(2, 'joe@mama.com', '$2y$10$t.mZqHzvMxYvWZGZu8Oz/u2PiQx56UanHFoT1qwOo8GwD4qgln13m', 'joe', 'mama', 0),
(3, 'joe@schmoe.com', '$2y$10$soqNuNu3pH87FYUYNwB0K.BgBC37aY50oDoauhTDffeiN2eRNBnsu', 'Joeseph', 'Schmoseph', 0),
(4, 'me@me.com', '$2y$10$v9WSxzpWsUoJmoWRiPBrEeLFGFvma4GLrzVKSeBSQvi5cF5QUX9fW', 'me', 'me', 1),
(5, 'you@you.com', '$2y$10$nFrlib2Qht4GP/e2G.80Ce/BzAxJQVabFCJaxPkwT0ryjilIaqq.K', 'you', 'ou', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_ID`,`post_ID`),
  ADD KEY `post_ID` (`post_ID`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`comment_ID`,`user_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_ID`),
  ADD UNIQUE KEY `post_ID` (`post_ID`,`user_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`post_ID`,`user_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`post_ID`,`tag_ID`),
  ADD KEY `tag_ID` (`tag_ID`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_ID`),
  ADD UNIQUE KEY `tag_title` (`tag_title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_ID`) REFERENCES `posts` (`post_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD CONSTRAINT `comment_likes_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_likes_ibfk_2` FOREIGN KEY (`comment_ID`) REFERENCES `comments` (`comment_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`post_ID`) REFERENCES `posts` (`post_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_ibfk_1` FOREIGN KEY (`post_ID`) REFERENCES `posts` (`post_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_tag_ibfk_2` FOREIGN KEY (`tag_ID`) REFERENCES `tags` (`tag_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
