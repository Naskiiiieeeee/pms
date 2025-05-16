-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 08:35 AM
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
  `price` text DEFAULT NULL,
  `totalAmount` varchar(255) NOT NULL,
  `dateNeeded` text DEFAULT NULL,
  `supplierID` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `datePosted` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `dateAdded` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fullname`, `department`, `campus`, `access`, `status`, `dateAdded`) VALUES
(31, 'j.macapagal.cdm@gmail.com', '$2y$10$Fq3K.HfNB8aMVQ5I9DUR1eNFjtDkWW1DNDUP9p019kMHSG9KoZy/C', 'Jonas Macapagal', NULL, NULL, 'Admin', 1, '2025-05-14'),
(32, 'humblebeast1218@gmail.com', '$2y$10$1AgxLnJhPZkLWM/CQmC./eEkhq6TGs8KY7h0L.V9aDlyk.GTp77Xa', 'Clyde', 'COLLEGE OF ENGINEERING, ARCHITECTURE AND FINE ARTS', 'BSU ALANGILAN', 'Dephead', 1, '2025-05-14');

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
  MODIFY `oc_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `r_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `resetpassword`
--
ALTER TABLE `resetpassword`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `sup_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
