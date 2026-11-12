-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 12, 2026 at 02:44 PM
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
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `description`) VALUES
(1, 'Oval Racing for Dummies', 'Speed Dèmon', '\"Everything you need to know about setting up a Pure Stock race car on a shoestring budget: how to make a 20-year-old engine scream, how to chase setup gremlins, and how to convince your crew chief that the car was \'pushing like a dump truck in turns 3 and 4\' rather than admitting you just missed your mark.\"'),
(2, 'Clean Code', 'Robert C. Martin', 'A handbook of agile software craftsmanship.'),
(3, 'The Shining', 'Stephen King', 'A family heads to an isolated hotel for the winter where a sinister presence influences the father into violence.'),
(4, 'Dune', 'Frank Herbert', 'Set on the desert planet Arrakis, the sole source of the universe\'\'s most valuable substance, Dune follows young Paul Atreides as his noble family is thrust into a deadly political betrayal. Surviving in the harsh wasteland alongside the native Fremen, Paul must embrace a destiny that could reshape the entire galactic empire.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
