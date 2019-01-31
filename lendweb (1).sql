-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2019 at 02:38 AM
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
  `accID` int(11) UNSIGNED ZEROFILL NOT NULL,
  `memberID` int(11) UNSIGNED ZEROFILL NOT NULL,
  `balance` double NOT NULL,
  `dailyPayment` double NOT NULL,
  `startDate` datetime NOT NULL,
  `dueDate` datetime NOT NULL,
  `status` enum('cleared','uncleared','overdue','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accID`, `memberID`, `balance`, `dailyPayment`, `startDate`, `dueDate`, `status`) VALUES
(00000000321, 00000000123, 8000, 0, '2019-01-29 00:00:00', '0000-00-00 00:00:00', 'uncleared');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `memberID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `username` varchar(30) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `mname` varchar(20) NOT NULL,
  `contact` varchar(13) NOT NULL,
  `address` mediumtext NOT NULL,
  `rating` int(5) NOT NULL,
  `regDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`memberID`, `username`, `fname`, `lname`, `mname`, `contact`, `address`, `rating`, `regDate`) VALUES
(0000000123, 'Bern1999', 'Bern', 'Lakwatsa', '', '+639874215489', 'Km.6, Dorina St., Kalipay Village, Sasa, Davao City,  Philippines 8000', 0, '2019-01-29 14:48:39');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `recordID` int(11) UNSIGNED ZEROFILL NOT NULL,
  `accID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `absent` int(11) NOT NULL,
  `APM` int(11) NOT NULL,
  `APB` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `recDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(3, 'user', 'user', 'user', 'user', '2019-01-22 01:56:26', 'user');

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
  ADD KEY `loanID` (`accID`);

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
