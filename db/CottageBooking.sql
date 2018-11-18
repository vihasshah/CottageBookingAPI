-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 18, 2018 at 10:59 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CottageBooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, '3 Star'),
(2, '5 Star'),
(3, '7 Star');

-- --------------------------------------------------------

--
-- Table structure for table `cottages`
--

CREATE TABLE `cottages` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `place` text NOT NULL,
  `images` text NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `price` int(20) NOT NULL,
  `amenities` text NOT NULL,
  `contact` int(20) NOT NULL,
  `ratings` int(11) NOT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cottages`
--

INSERT INTO `cottages` (`id`, `name`, `place`, `images`, `available`, `price`, `amenities`, `contact`, `ratings`, `blocked`, `category_id`) VALUES
(1, 'Rethal Greens', 'Ahmedabad', '/cottage/assets/img1.jpeg,/cottage/assets/rethal2.jpg,/cottage/assets/img1.jpeg,/cottage/assets/rethal2.jpg,/cottage/assets/img1.jpeg,/cottage/assets/rethal2.jpg,/cottage/assets/img1.jpeg,/cottage/assets/rethal2.jpg', 1, 3500, 'Pool, Wifi, Outdoor Games, Indoor Games', 1233465567, 5, 0, 2),
(2, 'Harmonic Holidays', 'Baroda', '/cottage/assets/img1.jpeg,/cottage/assets/rethal2.jpg', 1, 3000, 'Pool, Wifi', 987654321, 5, 0, 1),
(12, 'test', 'test', '/cottage/assets/6823b72e90bc8813c659c5023d13d002.jpg', 1, 123, 'test', 1231232, 5, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `image`, `title`, `details`) VALUES
(1, '/cottage/assets/img1.jpeg', 'news title', 'this is description part of property new.this is multiline para.');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `review` text NOT NULL,
  `ratings` varchar(6) NOT NULL,
  `cottage_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `review`, `ratings`, `cottage_id`, `date`) VALUES
(1, 'test is test review for rethel greens', '4', 1, '2018-09-01'),
(2, 'this is review for harmonic holidays', '4.5', 2, '2018-09-01'),
(3, 'this is review for harmonic holidays', '3', 2, '2018-09-01'),
(4, 'this is review for old rethel greens', '3', 1, '2018-03-01'),
(5, 'this is review for old rethel greens', '4.5', 1, '2016-05-01'),
(6, 'test review', '2', 1, '2018-10-26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` text,
  `lastname` text,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `contact`, `email`, `password`, `blocked`) VALUES
(1, 'vihas', 'shah', '123456789', 'vihas@vihas.com', '5da1d400bcf731b1243e7581994ec0a0', 0),
(2, 'testing', 'testing', '123456789', 'testing@testing.com', 'ae2b1fca515949e5d54fb22b8ed95575', 0),
(3, 'test', 'test', '1234567890', 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cottages`
--
ALTER TABLE `cottages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cottages`
--
ALTER TABLE `cottages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
