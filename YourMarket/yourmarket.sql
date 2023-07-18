-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 18 juil. 2023 à 11:08
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
  `name` varchar(100) NOT NULL,
  `details` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` enum('Phone','Computer','Watch','Video Games') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stock` int DEFAULT NULL,
  `image_1` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image_2` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image_3` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`ID_Article`),
  UNIQUE KEY `name` (`name`),
  KEY `ID_Seller` (`ID_Seller`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`ID_Article`, `ID_Seller`, `name`, `details`, `price`, `category`, `stock`, `image_1`, `image_2`, `image_3`) VALUES
(5, 2, 'Mac 1', 'This is a Mac', '1199.00', 'Computer', 1, 'mac.png', 'refurb-macbook-air-silver-m1-202010.jpg', 'mac_ipad.jpg'),
(7, 1, 'Apple Watch', 'I sell 3 Apple Watches 7', '399.00', 'Watch', 3, 'iPhone_11_Y_1.png', 'Objets.jpg', 'iPhone_11_Y_1.png'),
(9, 4, 'phone', 'a vendre', '1232.00', 'Phone', 6, 'item-2.png', 'Iphone.png', 'item-1.png'),
(12, 3, 'TEST', 'Cest un test', '12345.00', 'Phone', 6, 'item-1.png', 'Iphone.png', 'item-2.png');

-- --------------------------------------------------------

--
-- Structure de la table `auction`
--

DROP TABLE IF EXISTS `auction`;
CREATE TABLE IF NOT EXISTS `auction` (
  `ID_Auction` int NOT NULL,
  `Starting_date` date NOT NULL,
  `Ending_date` date NOT NULL,
  `Initial_Price` float NOT NULL,
  `Final_Price` float NOT NULL,
  PRIMARY KEY (`ID_Auction`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bestoffer`
--

DROP TABLE IF EXISTS `bestoffer`;
CREATE TABLE IF NOT EXISTS `bestoffer` (
  `ID_Bestoffer` int NOT NULL,
  `Offer_date` date NOT NULL,
  `Offer` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`ID_Bestoffer`)
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
-- Structure de la table `buynow`
--

DROP TABLE IF EXISTS `buynow`;
CREATE TABLE IF NOT EXISTS `buynow` (
  `ID_BuyNow` int NOT NULL,
  PRIMARY KEY (`ID_BuyNow`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `ID_Article`, `name`, `price`, `quantity`, `image_1`) VALUES
(10, 3, 5, 'Mac 1', '1199.00', 82, 'mac.png'),
(12, 4, 5, 'Mac 1', '1199.00', 47, 'mac.png');

-- --------------------------------------------------------

--
-- Structure de la table `my_order`
--

DROP TABLE IF EXISTS `my_order`;
CREATE TABLE IF NOT EXISTS `my_order` (
  `ID_order` int NOT NULL,
  `ID_Article` int NOT NULL,
  `ID_Buyer` int NOT NULL,
  `ID_OrderType` int NOT NULL,
  `Order_date` date NOT NULL,
  `Promo_Code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ID_order`),
  KEY `ID_Article` (`ID_Article`),
  KEY `ID_Buyer` (`ID_Buyer`),
  KEY `ID_OrderType` (`ID_OrderType`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ordertype`
--

DROP TABLE IF EXISTS `ordertype`;
CREATE TABLE IF NOT EXISTS `ordertype` (
  `ID_OrderType` int NOT NULL,
  `ID_bestoffer` int DEFAULT NULL,
  `ID_BuyNow` int DEFAULT NULL,
  `ID_Auction` int DEFAULT NULL,
  PRIMARY KEY (`ID_OrderType`),
  KEY `ID_bestoffer` (`ID_bestoffer`),
  KEY `ID_BuyNow` (`ID_BuyNow`),
  KEY `ID_Auction` (`ID_Auction`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
