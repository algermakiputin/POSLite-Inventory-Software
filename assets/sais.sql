-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2018 at 02:24 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sais`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `active`) VALUES
(52, 'junkfoods', 1),
(71, 'Beverage', 1),
(81, 'soap', 1),
(91, 'yun', 1),
(121, 'dd', 1),
(131, '123', 1),
(141, 'sas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(55) NOT NULL,
  `address` varchar(99) NOT NULL,
  `city` varchar(22) NOT NULL,
  `state` varchar(11) NOT NULL,
  `zipcode` varchar(11) NOT NULL,
  `mobileNumber` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expiry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`id`, `supplier_id`, `date`, `expiry_date`) VALUES
(5, 8, '2018-11-06 07:34:24', '2018-11-07'),
(6, 8, '2018-11-06 07:35:03', '2018-11-05'),
(7, 8, '2018-11-06 07:35:14', '2018-11-01'),
(8, 8, '2018-11-09 01:57:21', '2018-11-08'),
(11, 9, '2018-12-12 13:27:31', '2018-12-13');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_details`
--

CREATE TABLE `delivery_details` (
  `id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `item` varchar(55) NOT NULL,
  `quantity` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_details`
--

INSERT INTO `delivery_details` (`id`, `price`, `item`, `quantity`, `delivery_id`) VALUES
(2, 2, 'test', 5, 6),
(3, 2, 'aa', 5, 7),
(4, 15, 'Huggies dry medium', 25, 8),
(11, 10, 'Cock', 100, 11);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `type` varchar(55) NOT NULL,
  `cost` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(150) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `barcode` varchar(55) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `barcode`, `name`, `category_id`, `description`, `supplier_id`, `status`, `created_at`) VALUES
(81, '5c0ff80', 'Glaxy Note', 91, 'test', 8, 1, '2018-12-11 17:47:40'),
(91, '5c11103', 'Fanta 1.5 Litr', 81, 'Fanta 1.5 liter', 8, 1, '2018-12-12 13:43:38'),
(101, '5c13d75', 'SWESTORLUV - DRESS ', 71, 'hhjhj', 8, 1, '2018-12-14 16:16:48'),
(111, '5c13e5b', 'a', 52, 'aaa', 8, 1, '2018-12-14 17:17:57'),
(121, '5c144b7', 'test', 52, 'asddsdsd', 8, 1, '2018-12-15 00:32:06'),
(161, '5c14bda', 'sad', 81, 'ssss', 9, 1, '2018-12-15 08:39:15'),
(171, '5c14f27', 'Piatos', 52, 'small', 8, 1, '2018-12-15 12:25:24'),
(181, '5c159de', 'Mang juan', 52, 'jack', 8, 1, '2018-12-16 00:36:00'),
(191, '5c174be', 'SAFEGUARD', 81, 'ASASAS', 8, 1, '2018-12-17 07:11:35'),
(201, '5c18a7e', 'test', 81, 'test', 8, 1, '2018-12-18 07:55:43'),
(211, '5c18c5d', 'Juice', 81, 'Really Testy', 9, 1, '2018-12-18 10:03:42'),
(221, '5c18c7d', 'Test 2', 71, 'Test', 8, 1, '2018-12-18 10:11:58'),
(231, '5c18c7f', 'Test 3', 71, 'Test', 9, 1, '2018-12-18 10:12:34'),
(241, '5c19adb', 'Hshsh', 81, 'Hdh', 8, 1, '2018-12-19 02:32:57'),
(251, '5c1ce8b', 'notebook', 52, 'sdvczdsvzdfv', 9, 1, '2018-12-21 13:21:26'),
(252, '5c255ec', 'pasta', 71, 'pasta\r\n', 8, 1, '2018-12-27 23:23:04');

-- --------------------------------------------------------

--
-- Table structure for table `ordering_level`
--

CREATE TABLE `ordering_level` (
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordering_level`
--

INSERT INTO `ordering_level` (`id`, `quantity`, `item_id`) VALUES
(61, 29, 81),
(71, 23, 91),
(81, 25, 101),
(91, 29, 111),
(101, 25, 121),
(141, 28, 161),
(151, 18, 171),
(161, 28, 181),
(171, 28, 191),
(181, 27, 201),
(191, 25, 211),
(201, 29, 221),
(211, 27, 231),
(221, 27, 241),
(231, 27, 251),
(232, 24, 252);

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `price` double NOT NULL,
  `item_id` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `price`, `item_id`, `date_time`, `status`) VALUES
(81, 900, 81, '2018-12-11 17:47:40', 1),
(91, 70, 91, '2018-12-12 13:43:38', 0),
(101, 14, 101, '2018-12-14 16:16:49', 0),
(111, 1, 111, '2018-12-14 17:17:57', 0),
(121, 149.51111111111112, 121, '2018-12-15 00:32:06', 1),
(161, 23, 161, '2018-12-15 08:39:15', 0),
(171, 13, 171, '2018-12-15 12:25:24', 1),
(181, 50, 181, '2018-12-16 00:36:00', 0),
(191, 18, 191, '2018-12-17 07:11:35', 0),
(201, 300, 201, '2018-12-18 07:55:43', 0),
(211, 90, 211, '2018-12-18 10:03:42', 0),
(221, 20, 221, '2018-12-18 10:11:58', 0),
(231, 20, 231, '2018-12-18 10:12:34', 0),
(241, 10, 241, '2018-12-19 02:32:57', 0),
(251, 19991, 251, '2018-12-21 13:21:26', 0),
(252, 80.5, 252, '2018-12-27 23:23:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_description`
--

CREATE TABLE `sales_description` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` float NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `address`, `contact`, `email`) VALUES
(8, 'Jack & Jill', 'test', 'test', 'algerzxc@gmail.com'),
(9, 'coco', 'davao city', '0959291', 'dev.algermakiputin@gmail.com'),
(31, 'uyuiyu', 'kjhiuhi', 'iju', 'freshsodarashy01@yhg.biz');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `date_created` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `account_type`, `date_created`, `created_by`) VALUES
(6, 'admin', '$2y$10$D5EzAbSDqhvdailkxdcMAunK0cs5Icipga.9v9Tu.oG9JKgO671Fa', 'Admin', '2017-07-07 02:10:21 am', 'admin'),
(15, 'test1', '$2y$10$ZS6c1NCEhKjJ8eJksnr1QeXMcUu250AzO65dUgzgb7lJY8HQLQuIm', 'Admin', '2018-11-26 02:01:48 am', 'admin'),
(17, 'clerk', '$2y$10$xLKWUjWUFcbTd7AffHw4ouS364/lWHAjc6u6k6dnfSb6Iic03eJXW', 'Clerk', '2018-12-03 02:48:14 am', 'admin'),
(18, 'cashier', '$2y$10$EzhhCbeXVmNiSz17kW1WZudVBDewDNivWYaB9k3WfYRHe2jYARphK', 'Cashier', '2018-12-10 03:38:24 am', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `delivery_details`
--
ALTER TABLE `delivery_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_id` (`delivery_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode_2` (`barcode`),
  ADD KEY `barcode` (`barcode`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `ordering_level`
--
ALTER TABLE `ordering_level`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_description`
--
ALTER TABLE `sales_description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `delivery_details`
--
ALTER TABLE `delivery_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `ordering_level`
--
ALTER TABLE `ordering_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_description`
--
ALTER TABLE `sales_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

--
-- Constraints for table `delivery_details`
--
ALTER TABLE `delivery_details`
  ADD CONSTRAINT `delivery_details_ibfk_1` FOREIGN KEY (`delivery_id`) REFERENCES `delivery` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `ordering_level`
--
ALTER TABLE `ordering_level`
  ADD CONSTRAINT `ordering_level_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
