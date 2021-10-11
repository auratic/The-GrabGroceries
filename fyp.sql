-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2021 at 08:22 AM
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
(500000002, 100000000, 'login', NULL, '2021-09-28 17:38:36'),
(500000004, 100000000, 'restore item', '200000000,200000002', '2021-09-28 18:22:03'),
(500000005, 100000000, 'archive item', '200000000', '2021-09-28 18:24:21'),
(500000006, 100000000, 'update receipt', '300000000', '2021-09-28 19:38:00'),
(500000007, 100000000, 'add admin', 'Tan Ah Beng', '2021-09-28 21:16:45'),
(500000008, 100000000, 'update item', '200000002', '2021-09-28 21:23:24'),
(500000009, 100000000, 'add item', 'Egg', '2021-09-28 21:41:21'),
(500000012, 100000000, 'login', NULL, '2021-09-28 21:42:05'),
(500000013, 100000000, 'login', NULL, '2021-09-29 19:07:20'),
(500000014, 100000000, 'login', NULL, '2021-09-29 20:18:10'),
(500000015, 100000000, 'add admin', 'Guang Jie Liyu', '2021-09-29 20:18:45'),
(500000016, 100000000, 'login', NULL, '2021-09-30 14:13:13'),
(500000017, 100000000, 'add admin', 'Guang JIe', '2021-09-30 14:19:19'),
(500000018, 100000000, 'login', NULL, '2021-10-01 00:03:11'),
(500000019, 100000000, 'login', NULL, '2021-10-04 16:47:51'),
(500000020, 100000000, 'login', NULL, '2021-10-04 20:49:16'),
(500000021, 100000000, 'login', NULL, '2021-10-05 17:50:34'),
(500000022, 100000000, 'login', NULL, '2021-10-06 12:37:50'),
(500000023, 100000000, 'login', NULL, '2021-10-07 14:41:28'),
(500000024, 100000010, 'login', NULL, '2021-10-08 17:15:41'),
(500000025, 100000000, 'login', NULL, '2021-10-10 14:34:44');

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
  `email5` varchar(200) DEFAULT NULL,
  `postcode1` int(10) DEFAULT NULL,
  `postcode2` int(10) DEFAULT NULL,
  `postcode3` int(10) DEFAULT NULL,
  `postcode4` int(10) DEFAULT NULL,
  `postcode5` int(10) DEFAULT NULL,
  `state1` varchar(30) DEFAULT NULL,
  `state2` varchar(30) DEFAULT NULL,
  `state3` varchar(30) DEFAULT NULL,
  `state4` varchar(30) DEFAULT NULL,
  `state5` varchar(30) DEFAULT NULL,
  `area1` varchar(50) DEFAULT NULL,
  `area2` varchar(50) DEFAULT NULL,
  `area3` varchar(50) DEFAULT NULL,
  `area4` varchar(50) DEFAULT NULL,
  `area5` varchar(50) DEFAULT NULL,
  `lname1` varchar(100) DEFAULT NULL,
  `lname2` varchar(100) DEFAULT NULL,
  `lname3` varchar(100) DEFAULT NULL,
  `lname4` varchar(100) DEFAULT NULL,
  `lname5` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust_address`
--

INSERT INTO `cust_address` (`user_id`, `name1`, `name2`, `name3`, `name4`, `name5`, `address1`, `address2`, `address3`, `address4`, `address5`, `phone1`, `phone2`, `phone3`, `phone4`, `phone5`, `email1`, `email2`, `email3`, `email4`, `email5`, `postcode1`, `postcode2`, `postcode3`, `postcode4`, `postcode5`, `state1`, `state2`, `state3`, `state4`, `state5`, `area1`, `area2`, `area3`, `area4`, `area5`, `lname1`, `lname2`, `lname3`, `lname4`, `lname5`) VALUES
(100000002, 'Liyu Guang Jie', 'Liyu Guang Jie', 'da re', 'Liyu Guang Jie', 'Liyu Guang Jie', '12, Lorong Seri Wangsa 7', '12, Lorong Seri Wangsa 7/2', '123,Kuala Lumpur', '12, Lorong Seri Wangsa 7', '12, Melaka', '0123456789', '0123608370', '0123608371', '0123608370', '0123608370', 'gj@student.mmu', '123@gmail.com', 'mw@gmail.com', 'mw@outlook.com', 'jj@outlook.com', 76400, 75150, 75150, 75300, 76450, 'Melaka', 'Melaka', 'Melaka', 'Melaka', 'Melaka', 'Alor Gajah', 'Melaka Tengah', 'Alor Gajah', 'Alor Gajah', 'Alor Gajah', NULL, NULL, NULL, NULL, NULL),
(100000000, 'mw', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100000001, 'mw', NULL, NULL, NULL, NULL, 'Ujong Pasir', NULL, NULL, NULL, NULL, ' 0122334455  ', NULL, NULL, NULL, NULL, 'mw@hotmail.my', NULL, NULL, NULL, NULL, 75000, NULL, NULL, NULL, NULL, 'Melaka', NULL, NULL, NULL, NULL, 'Alor Gajah', NULL, NULL, NULL, NULL, 'chan', NULL, NULL, NULL, NULL),
(100000003, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100000029, 'Liyu Guang Jie', NULL, NULL, NULL, NULL, '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', NULL, NULL, NULL, NULL, '0123608370', NULL, NULL, NULL, NULL, '123@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100000030, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  `cardCvv5` int(3) DEFAULT NULL,
  `cardExpYr1` int(4) DEFAULT NULL,
  `cardExpYr2` int(4) DEFAULT NULL,
  `cardExpYr3` int(4) DEFAULT NULL,
  `cardExpYr4` int(4) DEFAULT NULL,
  `cardExpYr5` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust_card`
--

INSERT INTO `cust_card` (`user_id`, `cardName1`, `cardNo1`, `cardExp1`, `cardCvv1`, `cardName2`, `cardNo2`, `cardExp2`, `cardCvv2`, `cardName3`, `cardNo3`, `cardExp3`, `cardCvv3`, `cardName4`, `cardNo4`, `cardExp4`, `cardCvv4`, `cardName5`, `cardNo5`, `cardExp5`, `cardCvv5`, `cardExpYr1`, `cardExpYr2`, `cardExpYr3`, `cardExpYr4`, `cardExpYr5`) VALUES
(100000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100000001, 'Chan Chan', '**** **** **** 2131', '10', 123, 'Ben', '**** **** **** 1123', '12 / 23', 123, 'Jess', '**** **** **** 9123', '12 / 12', 123, 'Name', '**** **** **** 3123', '12 / 31', 123, 'Alex', '**** **** **** 2222', '12 / 32', 132, 23, NULL, NULL, NULL, NULL),
(100000002, 'Guang Jie', '**** **** **** 6666', '2', 666, 'Jieeee', '**** **** **** 1231', '1', 123, 'Guang Jie', '**** **** **** 1231', '1', 111, 'Guang Jie', '**** **** **** 2112', '5', 123, NULL, NULL, NULL, NULL, 22, 22, 24, 28, NULL),
(100000003, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100000029, 'Jie Guang', '**** **** **** 3273', '33 / 33', 123, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100000030, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cust_cart`
--

CREATE TABLE `cust_cart` (
  `cart_id` int(9) NOT NULL,
  `user_id` int(9) DEFAULT NULL,
  `item_id` int(9) DEFAULT NULL,
  `quantity` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust_cart`
--

INSERT INTO `cust_cart` (`cart_id`, `user_id`, `item_id`, `quantity`) VALUES
(600000000, 100000002, 200000000, 1),
(600000003, 100000002, 200000001, 2);

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
('IVQ8JJ', 'Chan', 'mw@gmail.com', '012-4445566', 'F', 'Testing', '2021-09-07 14:26:51'),
('X5D5TR', 'Liyu Guang Jie', 'jie@gmail.com', '0123608370', 'Testing', '123', '2021-10-03 14:42:05');

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
  `receipt_phone` varchar(20) DEFAULT NULL,
  `receipt_area` varchar(50) DEFAULT NULL,
  `receipt_state` varchar(50) DEFAULT NULL,
  `receipt_postcode` int(10) DEFAULT NULL,
  `receipt_fname` varchar(100) DEFAULT NULL,
  `receipt_lname` varchar(100) DEFAULT NULL,
  `receipt_cardno` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust_receipt`
--

INSERT INTO `cust_receipt` (`receipt_id`, `receipt_date`, `delivery_date`, `receive_date`, `product_status`, `user_id`, `payment_cost`, `payment_method`, `receipt_address`, `rating`, `receipt_name`, `receipt_email`, `receipt_phone`, `receipt_area`, `receipt_state`, `receipt_postcode`, `receipt_fname`, `receipt_lname`, `receipt_cardno`) VALUES
(300000007, '2021-10-11 14:02:25', NULL, NULL, 'Not set', 100000001, 405.92, 'Online Banking', 'Bukit Beruang Mmu', 'Not delivered', NULL, 'mw@gmail.com', '60129998877', 'Alor Gajah', 'Melaka', 75000, 'Mingwai', 'Chan', '**** **** **** 2131');

-- --------------------------------------------------------

--
-- Table structure for table `cust_review`
--

CREATE TABLE `cust_review` (
  `user_id` int(9) DEFAULT NULL,
  `reviews` varchar(300) DEFAULT NULL,
  `rating` int(5) DEFAULT NULL,
  `cust_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust_review`
--

INSERT INTO `cust_review` (`user_id`, `reviews`, `rating`, `cust_name`) VALUES
(100000029, 'Decent prices, a good amount of products to choose from, efficient and friendly staff. I love their service and discounts.', 4, 'John Smith'),
(100000002, 'Groceries are cheaper when compared with the local stores', 5, 'Alex Tan'),
(100000030, NULL, NULL, NULL);

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
(400000008, 200000000, 300000007, 4, 2.99),
(400000009, 200000002, 300000007, 4, 2.97),
(400000010, 200000003, 300000007, 4, 399.96);

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
  `password` varchar(255) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `verified` varchar(10) DEFAULT 'false',
  `mode` varchar(10) DEFAULT 'user',
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `postcode` int(10) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `password`, `lastname`, `firstname`, `verified`, `mode`, `phone`, `email`, `address`, `postcode`, `state`, `area`) VALUES
(100000000, '$2a$12$CER/Z1hqGfDY7fFhYDyUy.Ch8tHTZirz0A96gn.PgoRAqeHsnYZSy', 'chan', 'mw', 'true', 'superadmin', '60127991011', 'mw@hotmail.com', 'Bukit Beruang MMU', NULL, NULL, NULL),
(100000001, '$2a$12$CER/Z1hqGfDY7fFhYDyUy.Ch8tHTZirz0A96gn.PgoRAqeHsnYZSy', 'Chan', 'Mingwai', 'false', 'customer', '60129998877', 'mw@gmail.com', 'Bukit Beruang Mmu', NULL, NULL, NULL),
(100000002, '$2y$10$lVUg7xBMOaCnp5WwMRcY7e6VS4qwBAO1YwbhrIqfPbzigE3WEIHgq', 'Jie', 'Guangg', 'false', 'customer', '0126511762', 'jie@gmail.com', '123,Melakaaa', 76450, 'Melaka', 'Alor Gajah'),
(100000003, '$2a$12$CER/Z1hqGfDY7fFhYDyUy.Ch8tHTZirz0A96gn.PgoRAqeHsnYZSy', 'Ali', 'Ali Muhammad Bin', 'false', 'customer', NULL, 'qwert@outlook.com', NULL, NULL, NULL, NULL),
(100000010, '$2a$12$E8Cj4lHwlU6DSCc.f.foZ.ckIoLuEBGwuL4mI0L7wK9oMjr.2NVnS', 'Guang', 'JIe', 'false', 'admin', '0123608370', '123@gmail.com', NULL, NULL, NULL, NULL),
(100000029, '$2y$10$s.vHWE42Aw6MbfDsurfLV.SQJkpPDl/vALYKvLQ9TDxbdEvQOO/ti', 'Jie', 'Guang', 'false', 'customer', '0123608370', 'derk@gmail.com', '123,Melakaaa', NULL, NULL, NULL),
(100000030, '$2y$10$Lwl/B/eB5/aSGs3RE7j1sOr6UMDZTvWIrOc7gxeJBEdMyOwN6R14O', 'Guang Jie', 'Liyu', 'false', 'customer', NULL, '4435345345@3213.com', NULL, NULL, NULL, NULL);

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
-- Indexes for table `cust_cart`
--
ALTER TABLE `cust_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

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
-- Indexes for table `cust_review`
--
ALTER TABLE `cust_review`
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
  MODIFY `activity_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500000026;

--
-- AUTO_INCREMENT for table `cust_cart`
--
ALTER TABLE `cust_cart`
  MODIFY `cart_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=600000011;

--
-- AUTO_INCREMENT for table `cust_receipt`
--
ALTER TABLE `cust_receipt`
  MODIFY `receipt_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300000008;

--
-- AUTO_INCREMENT for table `cust_transaction`
--
ALTER TABLE `cust_transaction`
  MODIFY `trans_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400000011;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200000004;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000031;

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
-- Constraints for table `cust_cart`
--
ALTER TABLE `cust_cart`
  ADD CONSTRAINT `cust_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cust_cart_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `cust_receipt`
--
ALTER TABLE `cust_receipt`
  ADD CONSTRAINT `cust_receipt_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cust_review`
--
ALTER TABLE `cust_review`
  ADD CONSTRAINT `cust_review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

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
