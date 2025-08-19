-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2025 at 09:04 AM
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
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `orderconfirmation`
--

CREATE TABLE `orderconfirmation` (
  `oc_id` int(255) NOT NULL,
  `orderID` varchar(255) NOT NULL,
  `products` text NOT NULL,
  `quantities` text NOT NULL,
  `empID` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `datePosted` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderconfirmation`
--

INSERT INTO `orderconfirmation` (`oc_id`, `orderID`, `products`, `quantities`, `empID`, `status`, `datePosted`) VALUES
(23, '02', 'Sample,Sample', '4,6', 'humblebeast1218@gmail.com', 1, '2025-08-19'),
(24, '01', 'Testing ulit,Testing ulit', '3,6', 'humblebeast1218@gmail.com', 1, '2025-08-19'),
(25, '04', 'This is Test,This is Test,This is TestThis is Test', '4,6,2', 'humblebeast1218@gmail.com', 0, '2025-08-19'),
(26, '03', 'ewan,ewanewan,ewanewanewanewan', '4,1,2', 'jonas.macapagal@pnm.edu.ph', 0, '2025-08-19'),
(27, '05', 'testing', '4', 'jonas.macapagal@pnm.edu.ph', 0, '2025-08-19'),
(28, '06', 'agoy', '2', 'jonas.macapagal@pnm.edu.ph', 0, '2025-08-19');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(255) NOT NULL,
  `orderID` varchar(255) NOT NULL,
  `requestID` varchar(255) NOT NULL,
  `empID` varchar(255) NOT NULL,
  `Reason` text DEFAULT NULL,
  `addSupply` text DEFAULT NULL,
  `quantity` text DEFAULT NULL,
  `totalAmount` varchar(255) NOT NULL,
  `dateNeeded` text DEFAULT NULL,
  `supplierID` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `datePosted` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `orderID`, `requestID`, `empID`, `Reason`, `addSupply`, `quantity`, `totalAmount`, `dateNeeded`, `supplierID`, `status`, `datePosted`) VALUES
(42, '01', '003', 'humblebeast1218@gmail.com', 'Testing ulit', 'Testing ulit,Testing ulit', '3,6', '', '2025-08-30', 'asdf', 1, '2025-08-19'),
(43, '02', '002', 'humblebeast1218@gmail.com', 'Sample', 'Sample,Sample', '4,6', '', '2025-08-19', 'asdf', 1, '2025-08-19'),
(44, '03', '005', 'jonas.macapagal@pnm.edu.ph', 'ewan', 'ewan,ewanewan,ewanewanewanewan', '4,1,2', '', '2025-08-19', 'asdf', 1, '2025-08-19'),
(45, '04', '001', 'humblebeast1218@gmail.com', 'This is Test', 'This is Test,This is Test,This is TestThis is Test', '4,6,2', '', '2025-08-29', 'asdf', 1, '2025-08-19'),
(46, '05', '006', 'jonas.macapagal@pnm.edu.ph', 'testing', 'testing', '4', '', '2025-08-19', 'asdf', 1, '2025-08-19'),
(47, '06', '007', 'jonas.macapagal@pnm.edu.ph', 'agoy', 'agoy', '2', '', '2025-09-06', 'asdf', 1, '2025-08-19');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `r_id` int(255) NOT NULL,
  `transactionCode` varchar(255) NOT NULL,
  `Reason` text DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `addSupply` text DEFAULT NULL,
  `productDes` text DEFAULT NULL,
  `quantity` text DEFAULT NULL,
  `dateNeeded` text DEFAULT NULL,
  `dateRequest` text DEFAULT NULL,
  `dateApprove` text DEFAULT NULL,
  `empID` varchar(255) NOT NULL,
  `statusOne` int(2) DEFAULT 0,
  `statusTwo` int(2) DEFAULT 0,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`r_id`, `transactionCode`, `Reason`, `Description`, `addSupply`, `productDes`, `quantity`, `dateNeeded`, `dateRequest`, `dateApprove`, `empID`, `statusOne`, `statusTwo`, `notes`) VALUES
(52, '001', 'This is Test', 'This is Test', 'This is Test,This is Test,This is TestThis is Test', 'This is Test,This is Test,This is TestThis is Test', '4,6,2', '2025-08-29', '2025-08-19', '2025-08-19', 'humblebeast1218@gmail.com', 1, 1, NULL),
(53, '002', 'Sample', 'Sample', 'Sample,Sample', 'Sample,Sample', '4,6', '2025-08-19', '2025-08-19', '2025-08-19', 'humblebeast1218@gmail.com', 1, 1, NULL),
(54, '003', 'Testing ulit', 'Testing ulit', 'Testing ulit,Testing ulit', 'Testing ulit,Testing ulit', '3,6', '2025-08-30', '2025-08-19', '2025-08-19', 'humblebeast1218@gmail.com', 1, 1, NULL),
(55, '004', 'Sports Festival', 'Sports Festival', 'Microphone,Speakers', 'Microphone,Speakers', '2,2', '2025-08-23', '2025-08-19', NULL, 'humblebeast1218@gmail.com', 2, 2, 'We apologize, but we cannot approve your request now. If you wish to provide additional information or clarification, please request it again. Thank you.'),
(56, '005', 'ewan', 'ewan', 'ewan,ewanewan,ewanewanewanewan', 'ewan,ewanewan,ewanewanewan', '4,1,2', '2025-08-19', '2025-08-19', '2025-08-19', 'jonas.macapagal@pnm.edu.ph', 1, 1, NULL),
(57, '006', 'testing', 'testing', 'testing', 'testing', '4', '2025-08-19', '2025-08-19', '2025-08-19', 'jonas.macapagal@pnm.edu.ph', 1, 1, NULL),
(58, '007', 'agoy', 'agoy', 'agoy', 'agoy', '2', '2025-09-06', '2025-08-19', '2025-08-19', 'jonas.macapagal@pnm.edu.ph', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resetpassword`
--

CREATE TABLE `resetpassword` (
  `id` int(50) NOT NULL,
  `code` varchar(50) DEFAULT '0',
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `sup_id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `about` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phoneNumber` text DEFAULT NULL,
  `access` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1,
  `dateAdded` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `campus` text DEFAULT NULL,
  `access` varchar(50) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `dateAdded` date DEFAULT current_timestamp(),
  `isprotected` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fullname`, `department`, `campus`, `access`, `status`, `dateAdded`, `isprotected`) VALUES
(31, 'j.macapagal.cdm@gmail.com', '$2y$10$YldqrvceqG5LLA0XzxunvOKuxzT.M.lUTGMnPWh9lW.C6AURgivP2', 'Jonas Macapagal', NULL, NULL, 'Admin', 1, '2025-05-14', 1),
(36, 'humblebeast1218@gmail.com', '$2y$10$oyDPrx8d/Gl3m99AyYFwxuQTkdqMTvMRXTItMw4Jwnf5AlWohFgwG', 'testing', 'COLLEGE OF ENGINEERING, ARCHITECTURE AND FINE ARTS', 'BSU ALANGILAN', 'DepHead', 1, '2025-08-18', 0),
(42, 'jonas.macapagal@pnm.edu.ph', '$2y$10$sa9C9cJlcZj6acAb6L8FE.LqbE8G.4eJBrm1z27d0T1AGCkfOu5NC', 'Mr JM', 'COLLEGE OF ENGINEERING', 'BSU MALVAR', 'DepHead', 1, '2025-08-19', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orderconfirmation`
--
ALTER TABLE `orderconfirmation`
  ADD PRIMARY KEY (`oc_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `resetpassword`
--
ALTER TABLE `resetpassword`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`sup_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderconfirmation`
--
ALTER TABLE `orderconfirmation`
  MODIFY `oc_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `r_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `resetpassword`
--
ALTER TABLE `resetpassword`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `sup_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
