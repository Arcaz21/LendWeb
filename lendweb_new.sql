-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2019 at 03:47 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lendweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accID` varchar(30) NOT NULL,
  `creditAmnt` decimal(19,4) NOT NULL,
  `memberID` varchar(30) NOT NULL,
  `balance` decimal(19,2) NOT NULL,
  `dailyPayment` decimal(19,2) NOT NULL,
  `startDate` datetime NOT NULL,
  `dueDate` datetime NOT NULL,
  `status` enum('cleared','uncleared','overdue','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accID`, `creditAmnt`, `memberID`, `balance`, `dailyPayment`, `startDate`, `dueDate`, `status`) VALUES
('e0ef0', '1000.0000', '618be', '490.00', '20.00', '2019-02-18 22:02:52', '2019-04-19 22:04:52', 'uncleared');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `memberID` varchar(30) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `mname` varchar(20) NOT NULL,
  `contact` varchar(13) NOT NULL,
  `address` mediumtext NOT NULL,
  `gender` varchar(20) NOT NULL,
  `rating` int(5) DEFAULT NULL,
  `regDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`memberID`, `fname`, `lname`, `mname`, `contact`, `address`, `gender`, `rating`, `regDate`) VALUES
('618be', 'John', 'Suarez', 'Lemuel', '09438229231', 'Km. 12, Wisdom St., Catalunan Pequeno,Catalunan Pequeno,DAS,Davao City,Philippines 8000', '', 0, '2019-02-18 14:08:52');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `recordID` varchar(30) NOT NULL,
  `accID` varchar(30) NOT NULL,
  `payment` decimal(19,2) DEFAULT NULL,
  `creditBalance` decimal(19,2) NOT NULL,
  `AccuBal` decimal(19,2) DEFAULT NULL,
  `AdvBal` decimal(19,2) DEFAULT NULL,
  `recDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` varchar(30) DEFAULT NULL,
  `status` enum('full','partial','absent','initial','final','unpaid') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`recordID`, `accID`, `payment`, `creditBalance`, `AccuBal`, `AdvBal`, `recDate`, `description`, `status`) VALUES
('13d93', 'e0ef0', '30.00', '1100.00', '0.00', '10.00', '2019-02-18 14:11:03', 'Normal Payment', 'partial'),
('38190', 'e0ef0', '30.00', '990.00', '0.00', '0.00', '2019-02-18 14:11:08', 'Normal Payment', 'partial'),
('470f2', 'e0ef0', '30.00', '1130.00', '0.00', '0.00', '2019-02-18 14:11:00', 'Normal Payment', 'partial'),
('4fa20', 'e0ef0', '500.00', '490.00', '0.00', '480.00', '2019-02-18 14:11:10', 'Normal Payment', 'partial'),
('6b32d', 'e0ef0', '30.00', '1030.00', '0.00', '10.00', '2019-02-18 14:11:06', 'Normal Payment', 'partial'),
('942fa', 'e0ef0', '30.00', '1060.00', '0.00', '0.00', '2019-02-18 14:11:05', 'Normal Payment', 'partial'),
('c1f22', 'e0ef0', '30.00', '1170.00', '0.00', '10.00', '2019-02-18 14:09:33', 'Normal Payment', 'partial'),
('defc4', 'e0ef0', '0.00', '0.00', '0.00', '0.00', '2019-02-18 14:08:52', 'Initial Record - New Member', 'initial');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` enum('admin','user','collector','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `fname`, `lname`, `reg_date`, `role`) VALUES
(1, 'arcaz', 'arcaz', 'arcaz', 'suarez', '2019-01-21 03:45:26', 'admin'),
(2, 'von', 'von', 'von', 'von', '2019-01-22 01:56:26', 'collector'),
(3, 'user', 'user', 'user', 'user', '2019-01-22 01:56:26', 'user'),
(4, 'ayah', 'ayah', 'ayah', 'ayah', '2019-01-31 09:18:45', 'admin'),
(5, 'arnold', 'arnold', 'arnold', 'arnold', '2019-01-31 09:28:59', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accID`),
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`memberID`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`recordID`),
  ADD KEY `accID` (`accID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `member` (`memberID`);

--
-- Constraints for table `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `records_ibfk_1` FOREIGN KEY (`accID`) REFERENCES `account` (`accID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
