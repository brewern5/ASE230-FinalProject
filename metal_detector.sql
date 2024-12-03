-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 04:35 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_ID` int(10) UNSIGNED NOT NULL,
  `post_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `likes` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_ID`, `post_ID`, `user_ID`, `content`, `timestamp`, `likes`) VALUES
(2, 96, 2, 'this is my comment', '2024-12-03 00:25:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `comment_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` int(10) UNSIGNED NOT NULL,
  `title` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `picture` varchar(32) NOT NULL,
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
(8, 1, 'Irreversible Rules', 'This song goes way too hard!', 'https://en.wikipedia.org/wiki/Dr', 'ERRA', 'Drift', 'Irreversible', 0, '0000-00-00', '2024-11-26 19:42:56'),
(9, 2, 'Living on a Prayer is Cool', '                    This has been a great song with a phenomenal chorus!                ', 'https://m.media-amazon.com/image', 'Bon Jovi', 'Slippery When Wet', 'Living on a Prayer', 0, '0000-00-00', '2024-11-27 22:50:45'),
(95, 2, 'Erra\'s Self titled is amazing!!!', 'This album is spectacular, I literally have never listened to such a good album before in my life!', '', 'ERRA', 'ERRA', 'Gungrave', 0, '0000-00-00', '2024-12-02 21:25:49'),
(96, 2, 'Greyview Is goated', 'Woah I am shocked by their guitar and drum work. Love the new singer as well', '', 'Invent, Animate', 'Greyview', 'Hollow Light', 0, '0000-00-00', '2024-12-03 00:28:52');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `post_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1),
(1, 2),
(1, 3),
(6, 2),
(6, 3),
(8, 3),
(8, 4),
(8, 5),
(9, 3),
(9, 6),
(9, 7),
(9, 8),
(10, 0),
(10, 9),
(10, 10),
(11, 0),
(11, 9),
(11, 10),
(12, 0),
(12, 9),
(12, 10),
(13, 0),
(13, 1),
(13, 9),
(13, 10),
(13, 11),
(15, 0),
(15, 9),
(15, 11),
(21, 9),
(21, 12),
(21, 13),
(52, 12),
(52, 13),
(53, 12),
(53, 13),
(53, 14),
(95, 4),
(95, 15),
(95, 16),
(96, 17),
(96, 18),
(96, 19),
(96, 20);

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
(6, '#bonJovi'),
(5, '#Drift'),
(14, '#dumb'),
(4, '#ERRA'),
(18, '#IA '),
(19, '#IAFore'),
(20, '#IAForever'),
(17, '#InventAnimate '),
(2, '#post'),
(16, '#selftitled'),
(1, '#tag');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(10) UNSIGNED NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `email`, `password`, `firstname`, `lastname`) VALUES
(1, 'bobjones123445@gmail.com', '$2y$10$qpFs7UDK8tslTcZNusv2j.c2od9Rcrapsd.1g3KsA9WE0iR7JyLXy', 'Nate', 'Brewer'),
(2, 'joe@mama.com', '$2y$10$t.mZqHzvMxYvWZGZu8Oz/u2PiQx56UanHFoT1qwOo8GwD4qgln13m', 'joe', 'mama');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_ID`,`post_ID`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`comment_ID`,`user_ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_ID`),
  ADD UNIQUE KEY `post_ID` (`post_ID`,`user_ID`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`post_ID`,`user_ID`);

--
-- Indexes for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`post_ID`,`tag_ID`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
