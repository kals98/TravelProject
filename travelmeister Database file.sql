-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2020 at 06:30 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travelmeister`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `cname` varchar(100) NOT NULL,
  `cemail` varchar(100) NOT NULL,
  `cadd` varchar(100) NOT NULL,
  `bdate` date NOT NULL,
  `sdate` date NOT NULL,
  `edate` date NOT NULL,
  `nop` int(3) NOT NULL,
  `cost` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `agent_id` int(100) DEFAULT NULL,
  `tour_id` int(11) DEFAULT NULL,
  `review` tinyint(1) NOT NULL DEFAULT 0,
  `cancel` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `cname`, `cemail`, `cadd`, `bdate`, `sdate`, `edate`, `nop`, `cost`, `user_id`, `agent_id`, `tour_id`, `review`, `cancel`) VALUES
(56, 'Kalash Chandak', 'kalashchandak@gmail.com', '1234 street', '2020-05-05', '2020-05-14', '2020-05-27', 5, 25000, 1, 1, 13, 0, 1),
(57, 'Kalash Chandak', 'kalashchandak@gmail.com', '1234 strret', '2020-05-13', '2020-06-01', '2020-06-10', 4, 20000, 1, 1, 13, 5, 0),
(58, 'Kalash Chandak', 'kalashchandak@gmail.com', '2345 street', '2020-05-13', '2020-05-14', '2020-05-18', 5, 25000, 1, 1, 13, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `subject`, `message`) VALUES
(3, 'harsh shahh', 'kalashchandak@gmail.com', 'hello', 'pls send me some good tour details'),
(4, 'Kalash chandak', 'kalashchandak@gmail.com', 'hi', 'Give me some tours'),
(7, 'kala', 'kalashchandak@gmail.com', 'for tour', 'send some good tours'),
(8, 'Kalash Sunil Chandak', 'kalashchandak@gmail.com', 'Hi', 'Hello'),
(9, 'Kalash Sunil Chandak', 'kalashchandak@gmail.com', 'hi', 'nice query test'),
(10, 'Kalash Sunil Chandak', 'kalashchandak@gmail.com', 'hello', 'query test'),
(11, 'Kalash Sunil Chandak', 'kalashchandak@gmail.com', 'hello', 'testy'),
(12, 'Kalash Sunil Chandak', 'kalashchandak@gmail.com', 'sda', 'asd'),
(13, 'Kalash Sunil Chandak', 'kalashchandak@gmail.com', 'hello', 'hi'),
(22, 'Kalash', 'kalashchandak@gmail.com', 'Hi', 'Do you guys have any backpacker Tours?'),
(23, 'Kalash Sunil Chandak', 'kalashchandak@gmail.com', 'hi', 'I want to be an agent on this site'),
(24, 'Kalash Sunil Chandak', 'kalashchandak@gmail.com', 'hi', 'Hi do you provide tours for 20 people?');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT 'Unamed Tour',
  `country` varchar(100) NOT NULL,
  `continent` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `agent_uname` varchar(100) DEFAULT NULL,
  `rating` decimal(10,1) NOT NULL DEFAULT 5.0,
  `image` varchar(10000) NOT NULL,
  `nor` int(100) NOT NULL DEFAULT 1,
  `descr` varchar(1000) NOT NULL DEFAULT 'Amazing Tour'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `name`, `country`, `continent`, `price`, `agent_id`, `agent_uname`, `rating`, `image`, `nor`, `descr`) VALUES
(13, 'Indian Cruise Tour', 'India', 'Asia', 5000, 1, 'kals98', '4.5', '130.jpg,131.jpeg,132.jfif,133.jpg', 2, 'Adventure out in a stunning 20 day cruise tour in the Arabian Sea departing from Mumbai,India'),
(21, 'Argentina grand tour', 'Argentina', 'Africa', 10000, 1, 'kals98', '5.0', '210.jpg', 1, 'Amazing Tour'),
(27, 'USA Road Trip', 'United States', 'North America', 100000, 1, 'kals98', '5.0', '270.jpg', 1, 'Amazing tour through the huge landscape of america'),
(28, 'Indonesia Trip', 'Indonesia', 'Asia', 40000, 1, 'kals98', '5.0', '280.jpg', 1, 'Cultural Tour'),
(29, 'Australia Trip', 'Australia', 'Australia', 120000, 1, 'kals98', '5.0', '290.jpg,291.jpg', 1, 'Australia Wild tour through the vast expanses');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phno` bigint(11) NOT NULL,
  `dob` date NOT NULL,
  `user_type` varchar(100) NOT NULL DEFAULT 'user',
  `password` varchar(200) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phno`, `dob`, `user_type`, `password`, `image`) VALUES
(1, 'Kalash Chandak', 'kals98', 'kalashchandak@gmail.com', 8879305922, '1998-12-27', 'admin', 'a437860b5f44406aec42bef8f18be1a7', 'kals98.jpg'),
(2, 'Haseeb Sidiqui', 'Haseeb98', 'haseeb.sidiqui@gmail.com', 7875285080, '1998-06-17', 'user', '7cd14c3fb67dc4861215b36196885cf6', 'default.jpg'),
(3, 'Pranita', 'pranita98', 'pranita@gmail.com', 7021428514, '1993-06-08', 'agent', 'a437860b5f44406aec42bef8f18be1a7', 'default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `agent_id` (`agent_id`),
  ADD KEY `book_ibfk_3` (`tour_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `agent_id` (`agent_id`),
  ADD KEY `agent_uname` (`agent_uname`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phno` (`phno`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`agent_id`) REFERENCES `tours` (`agent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_ibfk_3` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tours_ibfk_2` FOREIGN KEY (`agent_uname`) REFERENCES `users` (`username`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
