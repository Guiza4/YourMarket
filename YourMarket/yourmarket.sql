-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 18 juil. 2023 à 23:24
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `yourmarket`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `ID_Admin` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `firstname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateofbirth` date NOT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`ID_Admin`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=101002 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`ID_Admin`, `lastname`, `firstname`, `dateofbirth`, `phone`, `email`, `password`) VALUES
(101001, 'Guiza', 'Youssef', '0000-00-00', NULL, 'youssef.guiza@yahoo.com', '$2y$10$DdfbsCJJsPI3rQfJpkU0l.uMRwJNfU4lPlo0qPDH8tQS3aY/Hx0SC');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `ID_Article` int NOT NULL AUTO_INCREMENT,
  `ID_Seller` int DEFAULT NULL,
  `ID_Buyer` int DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` enum('Phone','Computer','Watch','Video Games') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `brand` enum('Apple','Samsung','Xiaomi','Sony','HP','Asus','Nintendo','Microsoft') DEFAULT NULL,
  `selling_type` enum('Buy Now','Best Offer','Auction') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `minimum_bid` decimal(10,2) DEFAULT NULL,
  `highest_bid` decimal(10,2) DEFAULT NULL,
  `image_1` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image_2` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image_3` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`ID_Article`),
  UNIQUE KEY `name` (`name`),
  KEY `ID_Seller` (`ID_Seller`),
  KEY `FK_article_buyer` (`ID_Buyer`),
  KEY `FK_article_auction_bids` (`highest_bid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`ID_Article`, `ID_Seller`, `ID_Buyer`, `name`, `details`, `price`, `category`, `brand`, `selling_type`, `start_date`, `end_date`, `minimum_bid`, `highest_bid`, `image_1`, `image_2`, `image_3`) VALUES
(1, 2, NULL, 'Mac 1', 'This is the new Mac', '1199.00', 'Computer', 'Apple', 'Buy Now', NULL, NULL, NULL, NULL, 'mac_ipad-removebg-preview.png', 'apple iphone.png', 'apple_iphone-removebg-preview.png'),
(4, 2, 3, 'Watch', 'This is my new apple watch', '499.00', 'Watch', 'Apple', 'Auction', '2023-07-19', '2023-07-21', '499.00', '570.00', 'iPhone_11_Y_1.png', 'Objets.jpg', 'mac_ipad.jpg'),
(5, 2, NULL, 'azerty', 'This is my hp', '449.00', 'Computer', 'HP', 'Buy Now', NULL, NULL, NULL, NULL, 'printer.png', 'item1.png', 'star.png');

-- --------------------------------------------------------

--
-- Structure de la table `auction_bids`
--

DROP TABLE IF EXISTS `auction_bids`;
CREATE TABLE IF NOT EXISTS `auction_bids` (
  `ID_Bid` int NOT NULL AUTO_INCREMENT,
  `ID_Article` int NOT NULL,
  `ID_Buyer` int NOT NULL,
  `bid_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ID_Bid`),
  KEY `ID_Article` (`ID_Article`),
  KEY `ID_Buyer` (`ID_Buyer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `buyer`
--

DROP TABLE IF EXISTS `buyer`;
CREATE TABLE IF NOT EXISTS `buyer` (
  `ID_Buyer` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `firstname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateofbirth` date NOT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`ID_Buyer`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `buyer`
--

INSERT INTO `buyer` (`ID_Buyer`, `lastname`, `firstname`, `dateofbirth`, `phone`, `email`, `password`) VALUES
(1, 'Labaille', 'Lucas', '2001-02-02', '0620871212', 'lucas.labaille@example.com', '$2y$10$JeZ.bzPgEZqkjVHkNB7tPetFu09u/13oNDCdEJJxk1PKEcHH7opla'),
(2, 'Mariejeane', 'Canabis', '2023-07-22', '2448920202', 'tonton@marie.jeanne', '$2y$10$T5CMc6dvOFsvDgNGjTkreefgGtfGD3X1U3vKvQ0vdkjKOa03OsGdu'),
(3, 'Tqt', 'Cedric', '2023-07-03', '', 'cedric.tqt@yahoo.com', '$2y$10$kWr1Dy.7RfOJKCuiShXSLecgHIXYtN5iqHrsbXuUB6o4Kfs/Z7Zg6'),
(4, 'test', 'test', '2023-06-30', '098765789', '2345678@mail.com', '$2y$10$OjXHSB9/7bZGcrSVu0Ts1eysWFBupi5lI3B7z27sW45v5B7gIUZGC');

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `ID_Article` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `image_1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `ID_Article`, `name`, `price`, `quantity`, `image_1`) VALUES
(18, 1, 5, 'azerty', '449.00', 1, 'printer.png'),
(12, 4, 5, 'Mac 1', '1199.00', 47, 'mac.png'),
(13, 2, 1, 'Mac 1', '1199.00', 1, 'mac_ipad-removebg-preview.png');

-- --------------------------------------------------------

--
-- Structure de la table `seller`
--

DROP TABLE IF EXISTS `seller`;
CREATE TABLE IF NOT EXISTS `seller` (
  `ID_Seller` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `firstname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `dateofbirth` date NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`ID_Seller`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `seller`
--

INSERT INTO `seller` (`ID_Seller`, `lastname`, `firstname`, `phone`, `dateofbirth`, `email`, `password`) VALUES
(1, 'Guiza', 'Youssef', '0620871212', '2023-06-14', 'hedi.o@example.com', '$2y$10$QJNcL/wi2noE4/xgMnL1xONKelQItz.u12z5bWrRe0HwX3QZHL8Gq'),
(2, 'Tqt', 'Cedric', '0620871212', '2023-06-27', 'ced@example.fr', '$2y$10$fJ3U5kP97m9kQcos7mh1He0dytwzTfPq1arB9O/xt2gBXbRLDHA.u'),
(3, 'caca', 'pipi', '2345634567', '2023-06-28', 'evvrbervre@gmail.com', '$2y$10$eNU90zx/WkFH2aX4QqmJcuTcwlGNzAKpHj19CSBdK9U3ofWNDRYQG'),
(4, 'lucas', 'labaille', '0304030303', '2002-10-27', 'lucaslabaille@gmail.com', '$2y$10$IKlrwm0RzPHKJi4thMi3tOE1oAla89gvSnC.l09770oiXFwjo9QqO');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
