-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 10, 2023 at 05:27 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int NOT NULL,
  `uuid` varchar(128) NOT NULL,
  `title` varchar(128) NOT NULL,
  `src` varchar(128) NOT NULL,
  `alt` varchar(128) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(128) DEFAULT NULL,
  `updated_by` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `uuid`, `title`, `src`, `alt`, `caption`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, '647f2f273ea26', 'Optio adipisci quis 1111156666', '647f2f27394b7_kitsoft.PNG', 'Possimus eiusmod ne', 'Quis tempora dolorib', '2023-06-06 13:05:43', '2023-06-08 18:12:49', NULL, NULL),
(4, '64821a356b9c1', 'Corrupti voluptatem', '64821a3569c17_prcs.png', 'Voluptatibus officia', 'Sit deleniti quisqu', '2023-06-08 18:13:09', '2023-06-08 18:13:09', 'created-sdf', 'created-sdf'),
(6, '64821de32aab8', 'In sint quia reicien', '64821de30fbd7_process.PNG', 'Adipisicing sunt dol', 'Velit quaerat dolore', '2023-06-08 18:28:51', '2023-06-08 18:28:51', 'created-sdf', 'created-sdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
