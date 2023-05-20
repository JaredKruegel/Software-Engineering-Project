-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 03, 2023 at 06:12 PM
-- Server version: 5.7.42
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thaurec1_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `accountNumber` int(10) UNSIGNED ZEROFILL NOT NULL,
  `userID` int(11) NOT NULL,
  `balance` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`accountNumber`, `userID`, `balance`) VALUES
(0000000003, 5, 1999.50),
(0000000004, 6, 30.00),
(0000000005, 7, 0.00),
(0000000007, 9, 231.00),
(0000000010, 12, 80.45),
(0000000009, 11, 0.00),
(0000000012, 14, 684.50),
(0000000013, 15, 622.66),
(0000000015, 16, 1350.00);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `email`, `password`) VALUES
(1, 'admin@bank.com', '$2a$10$0vPWPhPZQJTPYwgZtG1i3uN1bdgQHu.jMcK1WrIluAQUBlB5hcqBm');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcementID` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `datePosted` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcementID`, `title`, `description`, `datePosted`) VALUES
(1, 'NEW Basic Bank Credit Card OFFER!', 'Today is a good day for customers! Today we are releasing our brand new credit line! Basic Bank Steady, Silver and Gold will offer you new opportunities to make purchases and train up your credit score! Apply for one today!', '2023-05-02 00:00:00'),
(4, 'Memorial Day Special: Earn Bonus Cash Back!', 'Celebrate Memorial Day with us and take advantage of our special offers, exclusively for our valued customers.', '2023-05-03 00:00:00'),
(16, 'Limited Time Offer!', 'Open a new account today and receive a $100 cash bonus!', '2023-05-02 00:00:00'),
(19, 'this is a test', 'this is another test!!!!!', '2023-05-03 00:00:00'),
(22, 'Test Announcement', 'Test Announcement to see if this shows', '2023-05-03 03:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionID` int(11) NOT NULL,
  `accountNumber` int(11) NOT NULL,
  `transactionType` enum('Deposit','Withdrawal') NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionID`, `accountNumber`, `transactionType`, `amount`) VALUES
(3, 3, 'Deposit', 50.00),
(2, 3, 'Deposit', 50.00),
(5, 3, 'Deposit', 200.00),
(7, 3, 'Deposit', 400.00),
(8, 3, 'Withdrawal', 100.50),
(9, 3, 'Withdrawal', 200.00),
(10, 3, 'Deposit', 100.00),
(11, 3, 'Deposit', 100.00),
(12, 3, 'Deposit', 50.00),
(13, 3, 'Deposit', 150.00),
(15, 3, 'Deposit', 1000.00),
(16, 4, 'Deposit', 60.00),
(17, 4, 'Withdrawal', 15.00),
(18, 4, 'Withdrawal', 15.00),
(19, 7, 'Deposit', 239.00),
(20, 7, 'Withdrawal', 20.00),
(21, 7, 'Withdrawal', 33.00),
(22, 7, 'Deposit', 45.00),
(23, 13, 'Deposit', 333.00),
(24, 13, 'Withdrawal', 66.67),
(25, 13, 'Withdrawal', 66.67),
(26, 13, 'Deposit', 333.00),
(27, 3, 'Withdrawal', 100.00),
(28, 3, 'Withdrawal', 100.00),
(29, 3, 'Deposit', 200.00),
(30, 10, 'Deposit', 500.00),
(31, 10, 'Deposit', 1250.45),
(32, 10, 'Withdrawal', 100.00),
(33, 10, 'Withdrawal', 200.00),
(34, 10, 'Deposit', 530.00),
(35, 12, 'Deposit', 400.00),
(36, 12, 'Deposit', 400.00),
(44, 15, 'Deposit', 1350.00),
(38, 12, 'Withdrawal', 115.50),
(39, 13, 'Deposit', 50.00),
(40, 13, 'Deposit', 20.00),
(41, 13, 'Deposit', 20.00),
(42, 10, 'Withdrawal', 1900.00),
(43, 3, 'Deposit', 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `email`, `password`) VALUES
(6, 'Jared', 'Kruegel', 'jaredkruege@gmail.com', '$2y$10$M/BzbNUpaI67C4IAEhD4jOiyvy7ST4mLRolqFCKdicYdidCu7KSrS'),
(7, 'chris', 'rojas', 'chrisrojas@gmail.com', '$2y$10$jxy2ORNLrUy1oKDcPKJZNOUQ.RN3N2aQv47dEeEh4K22qC.hfM.yS'),
(5, 'Cat', 'Thaureaux', 'thaureauxc1@montclair.edu', '$2y$10$Q8DoxTqiXh4IqgGFvqhPg.d4GNOTrG1fsDg8sfbDBR4B3.RcHC9Da'),
(9, 'jared', 'kruegel', 'jaredkruegel@gmail.com', '$2y$10$0vdljDOmLZqKTlJ7QhfCm.mUnXTiN5.kwAHNBUjIQrolm6YWDYROO'),
(12, 'Test', 'Subject', 'test@email.com', '$2y$10$FJpYyC6o0OIHRC6vK.JJj.D9ktIgMmdP6H3Hqyaws5JMb8qypBauG'),
(11, 'Chris', 'Rojas', 'chri@gmail.com', '$2y$10$9SjnrXgRCFEFjnweW26PBOcKGZx6AVIoxk5x8YjxF/afkWlvoQXka'),
(16, 'Jane', 'Doe', 'janedoe@email.com', '$2y$10$XnXEpu9Mzlunf/0.yQPm0uF4l2nXLGw5O0X8CeWTcOxdh3veWywEq'),
(14, 'Test', 'Subject', 'test2@gmail.com', '$2y$10$AwkckFy6d4oO.VESMC0do.Zw5Hp1vipNZaatRWimv5LlNF/SRYMk2'),
(15, 'john', 'doe', 'jd@gmail.com', '$2y$10$Kc2D/16l2QICmFNhXapFUOJGR65JLci7jp6wx89gEo5/MBDLwNn.e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`accountNumber`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcementID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactionID`),
  ADD KEY `accountNumber` (`accountNumber`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `accountNumber` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
