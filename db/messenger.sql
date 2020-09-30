-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2019 at 01:30 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `messenger`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `chat_Link` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `msg_type` varchar(50) NOT NULL,
  `Sender_ID` int(11) NOT NULL,
  `Receiver_ID` int(11) NOT NULL,
  `seen` varchar(3) NOT NULL DEFAULT '0',
  `msg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `chat_Link`, `message`, `msg_type`, `Sender_ID`, `Receiver_ID`, `seen`, `msg_time`) VALUES
(1, '154_153', 'Ø§Ø²ÙŠÙƒ ÙŠØ§ Ø§Ø¨ÙˆØ´Ø®Ù‡', 'text', 153, 154, '0', '2019-11-11 23:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To Identify User',
  `Username` varchar(255) NOT NULL COMMENT 'Username To Login',
  `Pass` varchar(255) NOT NULL COMMENT 'Password To Login',
  `Email` varchar(255) NOT NULL COMMENT 'Email To Login',
  `GroupID` int(11) NOT NULL DEFAULT '0' COMMENT 'Identifiy User Group',
  `Status` int(11) NOT NULL DEFAULT '0',
  `Date` date NOT NULL COMMENT 'Date Of Register',
  `Pic` varchar(255) NOT NULL,
  `offline_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Pass`, `Email`, `GroupID`, `Status`, `Date`, `Pic`, `offline_date`) VALUES
(153, 'AbdullRahman', 'e10adc3949ba59abbe56e057f20f883e', 'abdo@gmail.com', 1, 1, '2019-11-11', '186_IMG_2064.JPG', '2019-11-12 00:21:29'),
(154, 'marwan', 'e10adc3949ba59abbe56e057f20f883e', 'marwan@gmail.com', 1, 0, '2019-11-11', '629_20181110_230533.jpg', '2019-11-11 01:32:21'),
(155, 'Barry', 'e10adc3949ba59abbe56e057f20f883e', 'Barry@gmail.com', 1, 1, '2019-11-11', '806_images (4).jpg', '2019-11-11 01:36:14'),
(156, 'Calvin', 'e10adc3949ba59abbe56e057f20f883e', 'Calvin@gmail.com', 1, 0, '2019-11-11', '180_images (2).jpg', '2019-11-11 00:22:55'),
(157, 'Danny', 'e10adc3949ba59abbe56e057f20f883e', 'Danny@gmail.com', 1, 0, '2019-11-11', '956_images (3).jpg', '2019-11-11 00:16:31'),
(158, 'asdddddddd', '64ffd9c9a893ca196be91fe5d72d2cc8', 'asdddd@sad.ddd', 1, 0, '2019-11-11', '539_ssssssssssssssss.jpg', '2019-11-11 01:34:11'),
(159, 'asdasd', '1bd7ee6093507a6d00dd30d8b289bf9e', 'sfsfa@dasdas.asd', 1, 0, '2019-11-11', '911_ssssssssssssssss.jpg', '2019-11-11 01:34:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `messages_ibfk_1` (`Receiver_ID`),
  ADD KEY `messages_ibfk_2` (`Sender_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To Identify User', AUTO_INCREMENT=160;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`Receiver_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`Sender_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
