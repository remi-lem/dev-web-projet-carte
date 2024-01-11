-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-remi-lem.alwaysdata.net
-- Generation Time: Jan 11, 2024 at 02:12 PM
-- Server version: 10.11.6-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `remi-lem_projet_carte`
--
CREATE DATABASE IF NOT EXISTS `remi-lem_projet_carte` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `remi-lem_projet_carte`;

-- --------------------------------------------------------

--
-- Table structure for table `favourite_stations`
--

CREATE TABLE `favourite_stations` (
  `id_station` int(11) NOT NULL,
  `id_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favourite_stations`
--

INSERT INTO `favourite_stations` (`id_station`, `id_user_id`) VALUES
(87001479, 1),
(87116293, 4),
(87382218, 1),
(87393322, 1),
(87491803, 1),
(87756338, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `password`, `address`) VALUES
(1, 'Rémi', 'SuperUser', 'SuperPassword', 'IUT Paris Rives de Seine'),
(2, 'Esteban', 'EstebanCRz', 'EstebanCRz', 'porette'),
(3, 'code de carte bleue', 'clo', 'clo', NULL),
(4, 'Thon', 'Friand', 'FiandTheThon123', NULL),
(5, 'Thipose', 'Pranla', 'Prenlathipose123', NULL),
(12, 'La plus grande fan des fabrications', 'J', 'j', '8 rue paix');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favourite_stations`
--
ALTER TABLE `favourite_stations`
  ADD PRIMARY KEY (`id_station`,`id_user_id`),
  ADD KEY `IDX_F73AF34A79F37AE5` (`id_user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D6495E237E06` (`name`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7769B0F` (`surname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favourite_stations`
--
ALTER TABLE `favourite_stations`
  ADD CONSTRAINT `FK_F73AF34A79F37AE5` FOREIGN KEY (`id_user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
