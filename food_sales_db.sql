-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 01:38 PM
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
-- Database: `food_sales_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `name`, `price`) VALUES
(1, 'Strawberry w/yakult', 39.00),
(2, 'Strawberry 12oz', 19.00),
(3, 'Strawberry 16oz', 29.00),
(4, 'Green Apple w/yakult', 39.00),
(5, 'Green Apple 12oz', 19.00),
(6, 'Green Apple 16oz', 29.00),
(7, 'Bubble Gum w/yakult', 39.00),
(8, 'Bubble Gum 12oz', 19.00),
(9, 'Bubble Gum 16oz', 29.00),
(10, 'Burger w/cheese', 35.00),
(11, 'Burger', 30.00),
(12, 'Fries 10', 10.00),
(13, 'Fries 20', 20.00),
(14, 'Fries 30', 30.00),
(15, 'Chuckie Float', 35.00);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `sale_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `day_of_week` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `food_id`, `quantity`, `total`, `sale_time`, `day_of_week`) VALUES
(3, 1, 2, 78.00, '2025-05-31 10:31:38', NULL),
(4, 4, 2, 78.00, '2025-05-31 10:34:51', NULL),
(5, 12, 2, 20.00, '2025-05-31 10:36:10', NULL),
(6, 8, 3, 57.00, '2025-05-31 10:41:42', NULL),
(14, 1, 2, 78.00, '2025-05-31 11:31:29', 'Saturday');

-- --------------------------------------------------------

--
-- Table structure for table `sales_archive`
--

CREATE TABLE `sales_archive` (
  `id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `sale_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_archive`
--

INSERT INTO `sales_archive` (`id`, `food_id`, `quantity`, `total`, `day_of_week`, `sale_time`, `archived_at`) VALUES
(1, 2, 1, 19.00, 'Saturday', '2025-05-31 10:50:01', '2025-05-31 11:07:30'),
(2, 15, 1, 35.00, 'Saturday', '2025-05-31 10:50:26', '2025-05-31 11:07:30'),
(3, 1, 2, 78.00, 'Saturday', '2025-05-31 10:53:28', '2025-05-31 11:07:30'),
(4, 1, 1, 39.00, 'Saturday', '2025-05-31 10:55:18', '2025-05-31 11:07:30'),
(5, 10, 2, 70.00, 'Saturday', '2025-05-31 11:02:54', '2025-05-31 11:07:30'),
(8, 2, 1, 19.00, 'Saturday', '2025-05-31 11:08:01', '2025-05-31 11:10:36'),
(9, 2, 1, 19.00, 'Saturday', '2025-05-31 11:18:58', '2025-05-31 11:19:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `sales_archive`
--
ALTER TABLE `sales_archive`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sales_archive`
--
ALTER TABLE `sales_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
