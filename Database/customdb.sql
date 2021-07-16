-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2021 at 07:31 PM
-- Server version: 5.7.31
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `customdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `art`
--

CREATE TABLE `art` (
  `art_id` int(8) UNSIGNED NOT NULL,
  `thumb` varchar(130) NOT NULL,
  `type` varchar(50) NOT NULL,
  `price` decimal(6,2) UNSIGNED NOT NULL,
  `medium` varchar(50) NOT NULL,
  `artist` varchar(50) NOT NULL,
  `mini_descr` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `art`
--

INSERT INTO `art` (`art_id`, `thumb`, `type`, `price`, `medium`, `artist`, `mini_descr`) VALUES
(1, 'http://localhost:8080/examples/Practical%20php/ch.11/N_customcard%20-%20Copy/images/frame1.jpg', 'still-life', '70.00', 'oil-painting', 'Adrian W West', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, repudiandae.'),
(2, 'http://localhost:8080/examples/Practical%20php/ch.11/N_customcard%20-%20Copy/images/frame2.jpg', 'abstract', '710.00', 'oil-painting', 'Roger st. Barbe', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, repudiandae.'),
(3, 'http://localhost:8080/examples/Practical%20php/ch.11/N_customcard%20-%20Copy/images/frame3.jpg', 'still-life', '800.00', 'oil-painting', 'James Kessell', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, repudiandae.'),
(4, 'http://localhost:8080/examples/Practical%20php/ch.11/N_customcard%20-%20Copy/images/frame4.jpg', 'nature', '50.00', 'oil-painting', 'Adrian W West', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, repudiandae.'),
(5, 'http://localhost:8080/examples/Practical%20php/ch.11/N_customcard%20-%20Copy/images/frame5.jpg', 'nature', '720.00', 'oil-painting', 'Adrian W West', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, repudiandae.'),
(6, 'http://localhost:8080/examples/Practical%20php/ch.11/N_customcard%20-%20Copy/images/frame6.jpg', 'abstract', '55.00', 'oil-painting', 'James Kessell', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, repudiandae.');

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `artist_id` int(8) UNSIGNED NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `middle_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`artist_id`, `first_name`, `middle_name`, `last_name`) VALUES
(1, 'Adrian', 'W', 'West'),
(2, 'Roger', 'St.', 'Barbe'),
(3, 'James', NULL, 'Kessell');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(8) UNSIGNED NOT NULL,
  `total_price` decimal(7,0) NOT NULL,
  `order_date` datetime NOT NULL,
  `price` decimal(6,0) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_contents`
--

CREATE TABLE `order_contents` (
  `content_id` int(8) UNSIGNED NOT NULL,
  `order_id` int(8) UNSIGNED NOT NULL,
  `art_id` int(8) UNSIGNED NOT NULL,
  `price` decimal(5,2) UNSIGNED NOT NULL,
  `quantity` int(4) UNSIGNED NOT NULL,
  `dispatch_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` mediumint(6) UNSIGNED NOT NULL,
  `title` varchar(12) DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(100) NOT NULL,
  `registration_date` datetime NOT NULL,
  `user_level` tinyint(1) UNSIGNED NOT NULL,
  `class` char(20) NOT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state_country` char(30) NOT NULL,
  `zcode_pcode` char(10) NOT NULL,
  `phone` char(15) DEFAULT NULL,
  `secret` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `title`, `first_name`, `last_name`, `email`, `password`, `registration_date`, `user_level`, `class`, `address1`, `address2`, `city`, `state_country`, `zcode_pcode`, `phone`, `secret`) VALUES
(28, 'Mr.', 'Mike', 'Rosoft', 'miker@myisp.com', '$2y$10$qjrwJBOEcWZWyra/cnOynusUuYW6XTVp/SH3M5yYWGKmG9sZyCaYK', '2020-12-10 08:25:34', 1, '', '', NULL, '', '', '', NULL, ''),
(29, 'Mrs.', 'Rose', 'Bush', 'rbush@myisp.co.uk', '$2y$10$7edP2Her6mewngH0bnZb0.vYSUH/gWEj2WhyRxpxiBYnPDlVqMbV2', '2020-12-10 08:27:22', 0, '', '', NULL, '', '', '', NULL, ''),
(30, 'Dr', 'John', 'Smith', 'jsmith@myisp.com', 'John123#', '2021-07-14 20:32:45', 2, 'hf', 'fgf', 'hg', 'fh', 'gfhg', '67657', '65', '12345678');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `art`
--
ALTER TABLE `art`
  ADD PRIMARY KEY (`art_id`),
  ADD KEY `price` (`price`);

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`artist_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_date` (`order_date`),
  ADD KEY `price` (`price`);

--
-- Indexes for table `order_contents`
--
ALTER TABLE `order_contents`
  ADD PRIMARY KEY (`content_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `art_id` (`art_id`),
  ADD KEY `price` (`price`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `art`
--
ALTER TABLE `art`
  MODIFY `art_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `artist_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_contents`
--
ALTER TABLE `order_contents`
  MODIFY `content_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` mediumint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
