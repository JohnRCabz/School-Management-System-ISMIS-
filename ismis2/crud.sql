-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2020 at 03:08 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `studentsched`
--

CREATE TABLE `studentsched` (
  `id` int(255) NOT NULL,
  `schedid` int(255) NOT NULL,
  `studid` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studentsched`
--

INSERT INTO `studentsched` (`id`, `schedid`, `studid`) VALUES
(32, 14, 6),
(36, 21, 6),
(38, 20, 8);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `maxpopulation` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `maxpopulation`) VALUES
(1, 'Data Structures', 30),
(5, 'Mobile Development', 30),
(6, 'Web Dev', 30);

-- --------------------------------------------------------

--
-- Table structure for table `teachersched`
--

CREATE TABLE `teachersched` (
  `id` int(255) NOT NULL,
  `instructor` int(255) NOT NULL,
  `subjid` int(255) NOT NULL,
  `day` int(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `tstart` int(255) NOT NULL,
  `tend` int(255) NOT NULL,
  `population` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachersched`
--

INSERT INTO `teachersched` (`id`, `instructor`, `subjid`, `day`, `location`, `tstart`, `tend`, `population`) VALUES
(14, 7, 1, 2, 'LB 486', 730, 1000, 1),
(16, 7, 5, 3, 'LB 466', 800, 1330, 0),
(20, 7, 5, 4, 'LB 486', 800, 1330, 1),
(21, 5, 6, 4, 'LB 486', 730, 1000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `password`, `type`) VALUES
(4, 'Admin', 'Admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(5, 'teacher', 'teacher', 'teacher@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'teacher'),
(6, 'student', 'student', 'student@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'student'),
(7, 'Jack', 'Ma', 'jack@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'teacher'),
(8, 'test', 'test', 'test@yahoo.com', '098f6bcd4621d373cade4e832627b4f6', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `studentsched`
--
ALTER TABLE `studentsched`
  ADD PRIMARY KEY (`id`),
  ADD KEY `studentsched` (`schedid`),
  ADD KEY `studentsched2` (`studid`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachersched`
--
ALTER TABLE `teachersched`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teachersched` (`instructor`),
  ADD KEY `teachersched2` (`subjid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `studentsched`
--
ALTER TABLE `studentsched`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teachersched`
--
ALTER TABLE `teachersched`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `studentsched`
--
ALTER TABLE `studentsched`
  ADD CONSTRAINT `studentsched` FOREIGN KEY (`schedid`) REFERENCES `teachersched` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `studentsched2` FOREIGN KEY (`studid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachersched`
--
ALTER TABLE `teachersched`
  ADD CONSTRAINT `teachersched` FOREIGN KEY (`instructor`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teachersched2` FOREIGN KEY (`subjid`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
