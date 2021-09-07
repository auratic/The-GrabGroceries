-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2021 at 03:38 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `cust_message`
--

CREATE TABLE `cust_message` (
  `case_id` varchar(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `subject` varchar(20) NOT NULL,
  `message` varchar(500) NOT NULL,
  `receive_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust_message`
--

INSERT INTO `cust_message` (`case_id`, `name`, `email`, `phone`, `subject`, `message`, `receive_date`) VALUES
('IVQ8JJ', 'Chan', 'mw@gmail.com', '012-4445566', 'F', 'Testing', '2021-09-07 14:26:51');

-- --------------------------------------------------------

--
-- Table structure for table `cust_receipt`
--

CREATE TABLE `cust_receipt` (
  `receipt_id` int(9) NOT NULL,
  `receipt_date` datetime DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `receive_date` datetime DEFAULT NULL,
  `product_status` varchar(10) DEFAULT 'Not set',
  `user_id` int(9) NOT NULL,
  `payment_cost` float DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust_receipt`
--

INSERT INTO `cust_receipt` (`receipt_id`, `receipt_date`, `delivery_date`, `receive_date`, `product_status`, `user_id`, `payment_cost`, `payment_method`) VALUES
(300000000, '2020-09-07 16:59:00', NULL, NULL, 'Not set', 100000001, 59.99, 'Touch N Go');

-- --------------------------------------------------------

--
-- Table structure for table `cust_transaction`
--

CREATE TABLE `cust_transaction` (
  `trans_id` int(9) NOT NULL,
  `item_id` int(9) DEFAULT NULL,
  `receipt_id` int(9) DEFAULT NULL,
  `amount` int(5) DEFAULT NULL,
  `total_cost` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust_transaction`
--

INSERT INTO `cust_transaction` (`trans_id`, `item_id`, `receipt_id`, `amount`, `total_cost`) VALUES
(400000000, 200000001, 300000000, 5, 10),
(400000001, 200000000, 300000000, 10, 50);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(9) NOT NULL,
  `item` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `cost` float NOT NULL,
  `stock` int(9) NOT NULL,
  `exp_date` datetime NOT NULL,
  `image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item`, `category`, `description`, `cost`, `stock`, `exp_date`, `image`) VALUES
(200000000, 'Mamee (10 In 1)', 'Fruit & Vegetables', 'Mamee 250g per pack. Durian flavor at its best.', 2.99, 888, '2050-05-21 00:00:00', 'ShotType1_540x540.jpg'),
(200000001, 'Watermelon', 'Fruit & Vegetables', 'Watermelon imported from Iceland', 1.99, 500, '2050-05-21 00:00:00', 'watermelon.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(9) NOT NULL,
  `password` varchar(50) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `verified` varchar(10) DEFAULT 'false',
  `mode` varchar(10) DEFAULT 'user',
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `address1` varchar(200) DEFAULT NULL,
  `address2` varchar(200) DEFAULT NULL,
  `address3` varchar(200) DEFAULT NULL,
  `address4` varchar(200) DEFAULT NULL,
  `address5` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `password`, `lastname`, `firstname`, `verified`, `mode`, `phone`, `email`, `address1`, `address2`, `address3`, `address4`, `address5`) VALUES
(100000000, 'mwmwmw', 'chan', 'mw', 'true', 'admin', '60127991011', 'mw@hotmail.com', 'Bukit Beruang MMU', NULL, NULL, NULL, NULL),
(100000001, 'mw12345', 'Chan', 'Mingwai', 'false', 'customer', NULL, 'mw@gmail.com', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cust_message`
--
ALTER TABLE `cust_message`
  ADD PRIMARY KEY (`case_id`);

--
-- Indexes for table `cust_receipt`
--
ALTER TABLE `cust_receipt`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cust_transaction`
--
ALTER TABLE `cust_transaction`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `receipt_id` (`receipt_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cust_receipt`
--
ALTER TABLE `cust_receipt`
  MODIFY `receipt_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300000001;

--
-- AUTO_INCREMENT for table `cust_transaction`
--
ALTER TABLE `cust_transaction`
  MODIFY `trans_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400000002;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200000002;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000002;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cust_receipt`
--
ALTER TABLE `cust_receipt`
  ADD CONSTRAINT `cust_receipt_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cust_transaction`
--
ALTER TABLE `cust_transaction`
  ADD CONSTRAINT `cust_transaction_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  ADD CONSTRAINT `cust_transaction_ibfk_2` FOREIGN KEY (`receipt_id`) REFERENCES `cust_receipt` (`receipt_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
