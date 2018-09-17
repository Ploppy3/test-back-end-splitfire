-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 17, 2018 at 03:19 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitter`
--

-- --------------------------------------------------------

--
-- Table structure for table `hashtags`
--

DROP TABLE IF EXISTS `hashtags`;
CREATE TABLE IF NOT EXISTS `hashtags` (
  `idTweet` int(11) NOT NULL,
  `hashtag` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hashtags`
--

INSERT INTO `hashtags` (`idTweet`, `hashtag`) VALUES
(9, 'hashtag1'),
(9, 'hashtag2'),
(10, 'hashtag1'),
(10, 'hashtag2'),
(11, 'hashtag1'),
(11, 'hashtag2'),
(12, 'badHashtag1'),
(12, 'badHashtag2'),
(13, 'bad1'),
(13, 'bad2'),
(14, 'test'),
(27, 'fleurs'),
(28, 'fleurs');

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
CREATE TABLE IF NOT EXISTS `tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` tinytext NOT NULL,
  `date` datetime NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tweets`
--

INSERT INTO `tweets` (`id`, `user`, `date`, `message`) VALUES
(1, 'a username', '2018-09-17 11:54:37', 'this is my message'),
(2, 'a username', '2018-09-17 11:58:47', 'this is my message'),
(3, 'a username', '2018-09-17 12:08:28', 'this is my message'),
(4, 'a username', '2018-09-17 12:09:40', 'this is my message'),
(5, 'a username', '2018-09-17 12:10:19', 'this is my message'),
(6, 'a username', '2018-09-17 12:10:38', 'this is my message'),
(7, 'a username', '2018-09-17 12:10:49', 'this is my message'),
(8, 'a username', '2018-09-17 12:11:34', 'this is my message'),
(9, 'a username', '2018-09-17 12:11:53', 'this is my message'),
(10, 'a username', '2018-09-17 12:13:03', 'this is my message'),
(11, 'Robin', '2018-09-17 13:34:13', 'this is my message'),
(12, 'Robin', '2018-09-17 13:43:29', 'this is my message'),
(13, 'Robin', '2018-09-17 13:44:07', 'this is my message'),
(14, 'Robin', '2018-09-17 14:16:18', 'this is my message'),
(15, 'Robin', '2018-09-17 14:16:44', 'this is my message'),
(16, 'Robin', '2018-09-17 14:21:53', 'this is my message'),
(17, 'Robin', '2018-09-17 14:22:50', 'this is my message'),
(18, 'Robin', '2018-09-17 14:27:21', 'this is my message'),
(19, 'Robin', '2018-09-17 14:27:35', 'this is my message'),
(20, 'Robin', '2018-09-17 14:29:34', 'this is my message'),
(21, 'Robin', '2018-09-17 14:29:48', 'this is my message'),
(22, 'Robin', '2018-09-17 14:29:55', 'this is my message'),
(23, 'Robin', '2018-09-17 14:30:48', 'this is my message'),
(24, 'Robin', '2018-09-17 14:31:01', 'this is my message'),
(25, 'Robin', '2018-09-17 14:51:31', 'this is my message'),
(26, 'Robin', '2018-09-17 14:54:49', 'this is my message'),
(27, 'Robin', '2018-09-17 14:54:56', 'this is my message'),
(28, 'Claire', '2018-09-17 15:05:10', 'lorem ipsum');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
