-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 26, 2026 at 05:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `imageName` varchar(255) NOT NULL DEFAULT 'placeholder_100.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `description`, `imageName`) VALUES
(1, 'NASCAR for Dummies', 'Mark Martin', 'NASCAR For Dummies is a friendly, thorough introduction to one of North America’s most popular motorsports. Written in an accessible style, it explains how NASCAR works so newcomers and casual fans can follow the action with confidence.\r\n\r\nStarting with the basics, the book outlines the major NASCAR series and what sets them apart. It breaks down how race teams operate, what each crew member does, and how rules shape the strategies you see on track.\r\n\r\nReaders get a clear look at the anatomy of a stock car, from the body to key components, and why a race car is so different from a showroom model. The book also explains race-day essentials: the meaning of coloured flags, how pit stops are choreographed, and why tires and fuel strategy can decide a win.\r\n\r\nBeyond the track, the guide explores sponsorship, the variety of NASCAR tracks, and how to plan and enjoy a live race, from the roar of the engines to the smell of burned rubber.', 'nascar.jpg'),
(2, 'Clean Code', 'Robert C. Martin', 'A handbook of agile software craftsmanship.', 'CC.jpg'),
(3, 'The Shining', 'Stephen King', 'A family heads to an isolated hotel for the winter where a sinister presence influences the father into violence.', 'shining.jpg'),
(4, 'Dune', 'Frank Herbert', 'Set on the desert planet Arrakis, the sole source of the universe\'\'s most valuable substance, Dune follows young Paul Atreides as his noble family is thrust into a deadly political betrayal. Surviving in the harsh wasteland alongside the native Fremen, Paul must embrace a destiny that could reshape the entire galactic empire.', 'dune.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `failedAttempts` int(11) NOT NULL DEFAULT 0,
  `lastFailedLogin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`userID`, `userName`, `password`, `emailAddress`, `failedAttempts`, `lastFailedLogin`) VALUES
(4, 'mario', '$2y$10$BxeyAm4wkvBhvUUP3Aj0pOHS2FHFJ4WDXq0zH2HjHZ6NPP6dGLsNi', 'mcalitri@live.com', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
