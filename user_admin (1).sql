-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 04, 2020 at 08:43 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `roles`, `username`, `password`, `avatar`, `active`, `country`, `pcode`, `city`, `address`) VALUES
(1, 'Remy Randolph', 'remy@.gmail.com', 'admin', 'testuser1', 'testuser1', '', 0, '', '', '', ''),
(2, 'Anushka Eastwood', 'and@gmai.com', 'admin', 'testuser2', 'testuser2', '', 0, '', '', '', ''),
(3, 'Milana Sharma', 'mili@gmai.com', 'admin', 'testuser3', 'testuser3', '', 0, '', '', '', ''),
(4, 'Oluwatobiloba Daugherty', 'olulu@testmail.com', 'admin', 'testuser4', 'testuser4', '', 0, '', '', '', ''),
(5, 'Zane Gibbs', 'zaa@test.com', 'admin', 'testuser5', 'testuser5', '', 0, '', '', '', ''),
(6, 'Mahir Phan', 'mah@gmail.com', 'admin', 'testuser6', 'testuser6', '', 0, '', '', '', ''),
(7, 'Corey Beattie', 'cor@gmail.com', 'admin', 'testuser7', 'testuser7', '', 0, '', '', '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
