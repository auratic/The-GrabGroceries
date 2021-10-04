-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2021 at 10:17 AM
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
-- Table structure for table `admin_activity`
--

CREATE TABLE `admin_activity` (
  `activity_id` int(9) NOT NULL,
  `user_id` int(9) NOT NULL,
  `activity` varchar(50) DEFAULT NULL,
  `target` varchar(300) DEFAULT NULL,
  `activity_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_activity`
--

INSERT INTO `admin_activity` (`activity_id`, `user_id`, `activity`, `target`, `activity_time`) VALUES
(500000000, 100000000, 'login', NULL, '2021-09-27 22:18:26'),
(500000001, 100000006, 'login', NULL, '2021-09-28 17:38:21'),
(500000002, 100000000, 'login', NULL, '2021-09-28 17:38:36'),
(500000004, 100000000, 'restore item', '200000000,200000002', '2021-09-28 18:22:03'),
(500000005, 100000000, 'archive item', '200000000', '2021-09-28 18:24:21'),
(500000006, 100000000, 'update receipt', '300000000', '2021-09-28 19:38:00'),
(500000007, 100000000, 'add admin', 'Tan Ah Beng', '2021-09-28 21:16:45'),
(500000008, 100000000, 'update item', '200000002', '2021-09-28 21:23:24'),
(500000009, 100000000, 'add item', 'Egg', '2021-09-28 21:41:21'),
(500000010, 100000008, 'login', NULL, '2021-09-28 21:41:44'),
(500000011, 100000008, 'restore item', '200000000,200000001', '2021-09-28 21:41:57'),
(500000012, 100000000, 'login', NULL, '2021-09-28 21:42:05'),
(500000013, 100000000, 'login', NULL, '2021-09-29 20:23:54'),
(500000014, 100000000, 'add admin', 'Tan Ah Kau', '2021-09-29 20:27:10'),
(500000015, 100000000, 'login', NULL, '2021-10-04 12:27:25');

-- --------------------------------------------------------

--
-- Table structure for table `cust_address`
--

CREATE TABLE `cust_address` (
  `user_id` int(9) DEFAULT NULL,
  `name1` varchar(100) DEFAULT NULL,
  `name2` varchar(100) DEFAULT NULL,
  `name3` varchar(100) DEFAULT NULL,
  `name4` varchar(100) DEFAULT NULL,
  `name5` varchar(100) DEFAULT NULL,
  `address1` varchar(200) DEFAULT NULL,
  `address2` varchar(200) DEFAULT NULL,
  `address3` varchar(200) DEFAULT NULL,
  `address4` varchar(200) DEFAULT NULL,
  `address5` varchar(200) DEFAULT NULL,
  `phone1` varchar(15) DEFAULT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `phone3` varchar(15) DEFAULT NULL,
  `phone4` varchar(15) DEFAULT NULL,
  `phone5` varchar(15) DEFAULT NULL,
  `email1` varchar(200) DEFAULT NULL,
  `email2` varchar(200) DEFAULT NULL,
  `email3` varchar(200) DEFAULT NULL,
  `email4` varchar(200) DEFAULT NULL,
  `email5` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust_address`
--

INSERT INTO `cust_address` (`user_id`, `name1`, `name2`, `name3`, `name4`, `name5`, `address1`, `address2`, `address3`, `address4`, `address5`, `phone1`, `phone2`, `phone3`, `phone4`, `phone5`, `email1`, `email2`, `email3`, `email4`, `email5`) VALUES
(100000002, 'jie', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100000000, 'mw', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100000001, 'mw   ', NULL, 'mw mw', 'chan chan', NULL, 'Ujong Pasir', NULL, '123', '123', NULL, ' 0122334455  ', NULL, '123', '123', NULL, 'mw@hotmail.my', NULL, '123@gmail.com', '123@gmail.com', NULL),
(100000003, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100000004, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cust_card`
--

CREATE TABLE `cust_card` (
  `user_id` int(9) DEFAULT NULL,
  `cardName1` varchar(100) DEFAULT NULL,
  `cardNo1` varchar(19) DEFAULT NULL,
  `cardExp1` varchar(7) DEFAULT NULL,
  `cardCvv1` int(3) DEFAULT NULL,
  `cardName2` varchar(100) DEFAULT NULL,
  `cardNo2` varchar(19) DEFAULT NULL,
  `cardExp2` varchar(7) DEFAULT NULL,
  `cardCvv2` int(3) DEFAULT NULL,
  `cardName3` varchar(100) DEFAULT NULL,
  `cardNo3` varchar(19) DEFAULT NULL,
  `cardExp3` varchar(7) DEFAULT NULL,
  `cardCvv3` int(3) DEFAULT NULL,
  `cardName4` varchar(100) DEFAULT NULL,
  `cardNo4` varchar(19) DEFAULT NULL,
  `cardExp4` varchar(7) DEFAULT NULL,
  `cardCvv4` int(3) DEFAULT NULL,
  `cardName5` varchar(100) DEFAULT NULL,
  `cardNo5` varchar(19) DEFAULT NULL,
  `cardExp5` varchar(7) DEFAULT NULL,
  `cardCvv5` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust_card`
--

INSERT INTO `cust_card` (`user_id`, `cardName1`, `cardNo1`, `cardExp1`, `cardCvv1`, `cardName2`, `cardNo2`, `cardExp2`, `cardCvv2`, `cardName3`, `cardNo3`, `cardExp3`, `cardCvv3`, `cardName4`, `cardNo4`, `cardExp4`, `cardCvv4`, `cardName5`, `cardNo5`, `cardExp5`, `cardCvv5`) VALUES
(100000004, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100000001, 'Chan Chan', '**** **** **** 2131', '12 / 31', 123, 'Ben', '**** **** **** 1123', '12 / 23', 123, 'Jess', '**** **** **** 9123', '12 / 12', 123, 'Name', '**** **** **** 3123', '12 / 31', 123, 'Alex', '**** **** **** 2222', '12 / 32', 132),
(100000002, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100000003, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  `payment_method` varchar(20) DEFAULT NULL,
  `receipt_address` varchar(200) DEFAULT NULL,
  `rating` varchar(20) DEFAULT 'Not delivered',
  `receipt_name` varchar(200) DEFAULT NULL,
  `receipt_email` varchar(200) DEFAULT NULL,
  `receipt_phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust_receipt`
--

INSERT INTO `cust_receipt` (`receipt_id`, `receipt_date`, `delivery_date`, `receive_date`, `product_status`, `user_id`, `payment_cost`, `payment_method`, `receipt_address`, `rating`, `receipt_name`, `receipt_email`, `receipt_phone`) VALUES
(300000000, '2020-09-07 16:59:00', '2021-09-25 22:48:11', '2021-09-24 01:59:09', 'Preparing', 100000001, 59.99, 'Touch N Go', 'MMU Bukit Beruang', 'Not delivered', 'mw chan', 'mw@gmail.com', '0123334455'),
(300000001, '2020-09-10 16:59:00', '2021-09-25 22:48:11', NULL, 'Delivering', 100000001, 59.99, 'Maybank2U', 'Jasin', 'Not delivered', 'mw chan', 'mw@gmail.com', '0123334455'),
(300000002, '2020-11-20 16:59:00', '2021-09-25 22:48:11', NULL, 'Delivering', 100000002, 9.99, 'Credit Card', 'Batu Berendam', 'Not delivered', 'Jie Guang', 'jie@gmail.com', '0168889920');

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
(400000001, 200000000, 300000000, 10, 50),
(400000002, 200000002, 300000001, 10, 9.99);

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
  `image` varchar(200) DEFAULT NULL,
  `item_status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item`, `category`, `description`, `cost`, `stock`, `exp_date`, `image`, `item_status`) VALUES
(200000000, 'Mamee (10 In 1)', 'Fruit & Vegetables', 'Mamee 250g per pack. Durian flavor at its best.', 2.99, 888, '2050-05-21 00:00:00', 'ShotType1_540x540.jpg', 'Active'),
(200000001, 'Watermelon', 'Fruit & Vegetables', 'Watermelon imported from Iceland', 1.99, 500, '2050-05-21 00:00:00', 'watermelon.png', 'Active'),
(200000002, 'Potato', 'Fruit & Vegetables', 'Its no potato', 0.99, 999, '2022-05-10 00:00:00', '5b566bc71d308_thumb900.png', 'Active'),
(200000003, 'Egg', 'Fruit & Vegetables', 'A chicken egg', 99.99, 999, '2022-05-10 00:00:00', 'egg.jpg', 'Active');

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
  `address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `password`, `lastname`, `firstname`, `verified`, `mode`, `phone`, `email`, `address`) VALUES
(100000000, 'mwmwmw', 'chan', 'mw', 'true', 'superadmin', '60127991011', 'mw@hotmail.com', 'Bukit Beruang MMU'),
(100000001, 'mw12345', 'Chan', 'Mingwaiiii', 'false', 'customer', '60129998877', 'mw@gmail.com', 'Bukit Beruang Mmu'),
(100000002, 'jie123', 'Jiee', 'Guang', 'false', 'customer', '0123608370', 'jie@gmail.com', '666,Melaka'),
(100000003, 'mwmwmw', 'Ali', 'Ali Muhammad Bin', 'false', 'customer', NULL, 'qwert@outlook.com', NULL),
(100000004, 'mwmw12', 'Chan', 'Mingwai', 'false', 'customer', NULL, 'wasdwasd@yahoo.com', NULL),
(100000006, 'wwwwww', 'Ley', 'Daren', 'false', 'admin', NULL, 'www@gmail.com', NULL),
(100000007, 'wasdwasd', 'Jie', 'Guang', 'false', 'admin', NULL, 'gjgj@gmail.com', NULL),
(100000008, 'bbbbbb', 'Tan', 'Ah Beng', 'false', 'admin', '60170002292', 'bbb@gmail.com', NULL),
(100000009, 'mwmwmw', 'Tan', 'Ah Kau', 'false', 'admin', '601010101010', 'mmm@mail.com', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_activity`
--
ALTER TABLE `admin_activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cust_card`
--
ALTER TABLE `cust_card`
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `admin_activity`
--
ALTER TABLE `admin_activity`
  MODIFY `activity_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500000016;

--
-- AUTO_INCREMENT for table `cust_receipt`
--
ALTER TABLE `cust_receipt`
  MODIFY `receipt_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300000003;

--
-- AUTO_INCREMENT for table `cust_transaction`
--
ALTER TABLE `cust_transaction`
  MODIFY `trans_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400000003;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200000004;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000010;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_activity`
--
ALTER TABLE `admin_activity`
  ADD CONSTRAINT `admin_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cust_card`
--
ALTER TABLE `cust_card`
  ADD CONSTRAINT `cust_card_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

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
