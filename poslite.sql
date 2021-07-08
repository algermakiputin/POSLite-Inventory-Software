-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 17, 2021 at 10:02 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poslite`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE `backup` (
  `id` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `backup`
--

INSERT INTO `backup` (`id`, `date_time`, `filename`) VALUES
(2, '2021-05-17 08:02:02', './backup/backup2021-05-17-04-02-02.txt'),
(3, '2021-05-17 08:02:07', './backup/backup2021-05-17-04-02-07.txt');

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
(1, 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `gender` varchar(55) NOT NULL,
  `home_address` varchar(99) NOT NULL,
  `outlet_location` varchar(100) NOT NULL,
  `outlet_address` varchar(100) NOT NULL,
  `contact_number` varchar(25) NOT NULL,
  `membership` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(55) DEFAULT NULL,
  `zipcode` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `received_by` varchar(255) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_details`
--

CREATE TABLE `delivery_details` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantities` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `defectives` int(11) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `name` varchar(55) NOT NULL,
  `capital` float NOT NULL,
  `delivery_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `type` varchar(55) NOT NULL,
  `cost` float NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expiries`
--

CREATE TABLE `expiries` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantities` int(11) NOT NULL,
  `price` float NOT NULL,
  `barcode` varchar(99) NOT NULL,
  `name` varchar(99) NOT NULL,
  `capital` float NOT NULL,
  `expiry_date` datetime NOT NULL,
  `expired` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(150) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `action`, `date`) VALUES
(1, 6, 'Log in', '2021-04-28 12:44:44'),
(2, 6, 'Log in', '2021-04-29 12:19:43'),
(3, 6, 'Register Category: test', '2021-04-29 12:20:01'),
(4, 6, 'Register new item: 123123', '2021-04-29 12:20:18'),
(5, 6, 'Log in', '2021-05-01 05:37:41'),
(6, 6, 'Change 123123 Price: 0 to 123', '2021-05-01 05:37:52'),
(7, 6, 'Log in', '2021-05-14 11:24:47'),
(8, 6, 'Change 123123 Price: 0 to 50000', '2021-05-14 11:41:38'),
(9, 6, 'Log in', '2021-05-17 07:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_adjustment`
--

CREATE TABLE `inventory_adjustment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `date_time` varchar(255) NOT NULL,
  `quantities` int(11) NOT NULL,
  `capital` float NOT NULL,
  `sign` varchar(55) NOT NULL,
  `staff` varchar(55) NOT NULL,
  `item_id` int(11) NOT NULL,
  `remaining_stocks` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `barcode` varchar(55) NOT NULL,
  `name` varchar(99) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `capital` float NOT NULL,
  `main_unit` varchar(55) NOT NULL,
  `location` varchar(55) NOT NULL,
  `condition_status` varchar(55) NOT NULL,
  `warranty` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `barcode`, `name`, `category_id`, `description`, `supplier_id`, `status`, `created_at`, `image`, `price`, `capital`, `main_unit`, `location`, `condition_status`, `warranty`) VALUES
(1, '480000000017', '123123', 1, '123', 1, 1, '2021-04-29 12:20:18', '', 50000, 25000, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int(11) NOT NULL,
  `date_open` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `expiry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ordering_level`
--

CREATE TABLE `ordering_level` (
  `id` int(11) NOT NULL,
  `quantity` double UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `barcode` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordering_level`
--

INSERT INTO `ordering_level` (`id`, `quantity`, `item_id`, `barcode`) VALUES
(1, 9944, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `note` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `price` float NOT NULL,
  `wholesale` float NOT NULL,
  `capital` float NOT NULL,
  `item_id` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL,
  `label` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `shipvia` varchar(255) NOT NULL,
  `po_date` date NOT NULL,
  `po_number` varchar(255) NOT NULL,
  `memo` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_line`
--

CREATE TABLE `purchase_order_line` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `purchase_order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `item_condition` varchar(55) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sales_description_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `reason` varchar(255) NOT NULL,
  `barcode` varchar(55) NOT NULL,
  `transaction_number` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_number` varchar(99) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_name` varchar(88) DEFAULT NULL,
  `type` varchar(55) NOT NULL,
  `status` int(11) NOT NULL,
  `total` double NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(55) DEFAULT NULL,
  `zipcode` varchar(55) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `supplier_name` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `date_time`, `transaction_number`, `user_id`, `customer_id`, `customer_name`, `type`, `status`, `total`, `note`, `address`, `city`, `zipcode`, `supplier_id`, `supplier_name`) VALUES
(1, '2021-05-01 05:37:57', 'TRN0001', 6, NULL, NULL, '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '2021-05-14 11:29:40', 'TRN0002', 6, NULL, NULL, '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2021-05-14 11:41:54', 'TRN0003', 6, NULL, NULL, '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '2021-05-14 11:43:12', 'TRN0004', 6, NULL, NULL, '', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_description`
--

CREATE TABLE `sales_description` (
  `id` int(11) NOT NULL,
  `transaction_number` varchar(55) NOT NULL,
  `quantity` int(11) NOT NULL,
  `barcode` varchar(55) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `price` float NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `discount` int(11) NOT NULL,
  `profit` float NOT NULL,
  `user_id` int(11) NOT NULL,
  `staff` varchar(55) NOT NULL,
  `capital` float NOT NULL,
  `returned` float NOT NULL,
  `item_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `warranty` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_description`
--

INSERT INTO `sales_description` (`id`, `transaction_number`, `quantity`, `barcode`, `created_at`, `price`, `name`, `discount`, `profit`, `user_id`, `staff`, `capital`, `returned`, `item_id`, `sales_id`, `warranty`) VALUES
(1, 'TRN0001', 2, '1', '2021-05-01 05:37:57', 123, '123123 ', 0, 0, 6, '', 123, 0, 0, 0, ''),
(2, 'TRN0002', 98, '1', '2021-05-14 11:29:40', 123, '123123 ', 0, 0, 6, '', 123, 0, 0, 0, ''),
(3, 'TRN0003', 5, '1', '2021-05-14 11:41:54', 50000, '123123 ', 0, 0, 6, '', 25000, 0, 0, 0, ''),
(4, 'TRN0004', 50, '1', '2021-05-14 11:43:12', 50000, '123123 ', 0, 0, 6, '', 25000, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `background` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `start` varchar(99) NOT NULL,
  `business_address` varchar(99) NOT NULL,
  `business_name` varchar(99) NOT NULL,
  `contact` varchar(55) NOT NULL,
  `email` varchar(99) NOT NULL,
  `facebook` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `background`, `logo`, `start`, `business_address`, `business_name`, `contact`, `email`, `facebook`) VALUES
(1, '', '', '', 'Purok 19 san gabriel mintal davao city', 'POSLite', '09560887535', 'admin@poslitesoftware.com', 'www.facebook.com/poslitesoftware');

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
(1, 'test', 'test', 'test', 'test@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `sync`
--

CREATE TABLE `sync` (
  `id` int(11) NOT NULL,
  `query` text NOT NULL,
  `synced` int(11) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `created_by` varchar(100) NOT NULL,
  `name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `account_type`, `date_created`, `created_by`, `name`) VALUES
(6, 'Admin', '$2y$10$XY9ldowA0i1OIAXE7mhPbOqQjtJJjkGdXEBUO74y5C3fjwstRRDl2', 'Admin', '2017-07-07 02:10:21 am', 'admin', 'Lourdes Amor'),
(24, 'cashier', '$2y$10$KOpoPi3NJrTGGlQFJzDqjufU0aQi23xbK5/.8VXS6VBCs9QRMoE2m', 'Cashier', '2020-09-13 20:24:09', 'admin', 'cashier');

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` int(11) NOT NULL,
  `serial` varchar(99) NOT NULL,
  `name` varchar(99) NOT NULL,
  `price` float NOT NULL,
  `stocks` int(11) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `delivery_ibfk_1` (`supplier_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `delivery_details`
--
ALTER TABLE `delivery_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_id` (`delivery_id`),
  ADD KEY `barcode` (`barcode`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expiries`
--
ALTER TABLE `expiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_adjustment`
--
ALTER TABLE `inventory_adjustment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `barcode_2` (`barcode`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordering_level`
--
ALTER TABLE `ordering_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `price` (`price`),
  ADD KEY `wholesale` (`wholesale`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order_line`
--
ALTER TABLE `purchase_order_line`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_number` (`transaction_number`),
  ADD KEY `transaction_number_2` (`transaction_number`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `sales_description`
--
ALTER TABLE `sales_description`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_number` (`transaction_number`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `barcode` (`barcode`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sync`
--
ALTER TABLE `sync`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial` (`serial`),
  ADD KEY `serial_2` (`serial`),
  ADD KEY `serial_3` (`serial`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `stocks` (`stocks`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup`
--
ALTER TABLE `backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_details`
--
ALTER TABLE `delivery_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expiries`
--
ALTER TABLE `expiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inventory_adjustment`
--
ALTER TABLE `inventory_adjustment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ordering_level`
--
ALTER TABLE `ordering_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_line`
--
ALTER TABLE `purchase_order_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_description`
--
ALTER TABLE `sales_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sync`
--
ALTER TABLE `sync`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
