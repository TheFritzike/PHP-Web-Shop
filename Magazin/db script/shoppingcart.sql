-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 05, 2021 at 05:03 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoppingcart`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `uname` varchar(30) DEFAULT NULL,
  `upass` varchar(50) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `uemail` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `desc` text NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `rrp` decimal(7,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) NOT NULL,
  `img` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `desc`, `price`, `rrp`, `quantity`, `img`, `date_added`) VALUES
(1, 'Smart Watch', '<p>Watch GT 2  este un ceas sport de 46mm, rezistent la apa pana la 50 metri, cu o durata de viata a bateriei de aproape doua saptamani.</p>\r\n<h3>Descriere</h3>\r\n<ul>\r\n<li>Masurarea stresului.</li>\r\n<li>Exercitii pentru respiratie.</li>\r\n<li>Monitorizarea somnului.</li>\r\n<li>O baterie puternicat.</li>\r\n</ul>', '29.99', '0.00', 10, 'watch.jpg', '2019-03-13 17:55:22'),
(2, 'Portofel', '<p>Portofel de marime medie din colectia KAPTEN & SON. Model confectionat din piele naturala.</p>\r\n<li> Buzunar pentru monede incheiat cu fermoar.</li>\r\n<li> Compartiment pentru bancnote.</li>\r\n<li> Material neted.</li>\r\n<p> Compoziție:\r\n100% Piele naturala</p>', '14.99', '19.99', 34, 'wallet.jpg', '2019-03-13 18:52:49'),
(3, 'Casti audio On-ear', '<p>Usoare si confortabile, datorita pernelor moi si a benzii captusite, iti permit si conexiunea cu Siri sau Google Now, fara a folosi mobilul.</p>\r\n<p>Solutia perfecta pentru deplasare, permitandu-ti sa aduci muzica in toate aspectele vietii tale aglomerate.</p>\r\n<p>Continut pachet:</p>\r\n<li> 1 x Cablu USB;</li>\r\n<li> 1 x casti audio.</li>', '19.99', '0.00', 23, 'headphones.jpg', '2019-03-13 18:47:56'),
(4, 'Camera digitala', '<p>Aparat foto digital Canon SX530 HS, 16MP, Black</p>\r\n<p>Beneficii:</p>\r\n<li> O camera compacta cu zoom de 50x pentru fiecare situatie de fotografie </li>\r\n<li> Rezultate de calitate superioara pe care le veti impartasi cu mandrie </li>\r\n<li> Conectati-va simplu prin Wi-Fi cu NFC </li>\r\n<li> Experimentati cu modurile creative si controlul manual</li>', '69.99', '0.00', 7, 'camera.jpg', '2019-03-13 17:42:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uname` varchar(30) NOT NULL,
  `upass` varchar(60) NOT NULL,
  `fullname` varchar(100) NOT NULL DEFAULT '',
  `uemail` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uname` (`uname`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `uname`, `upass`, `fullname`, `uemail`) VALUES
(2, 'Levente2020', '$2y$10$UpMrKYbmZdaGHjE5hPnZuODPOgDuIrzCi1475nJ2sOZsAd/7dja6u', '', NULL),
(3, 'levente2021', '$2y$10$bWjVCj6amJTePheyxeXRgeY3x/7I3jP72YHlPd3e26S5lpL9r3HJS', '', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
