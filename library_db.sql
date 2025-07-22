-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 22, 2025 at 02:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `bookTitle` varchar(255) DEFAULT NULL,
  `published` varchar(10) DEFAULT NULL,
  `copies` int(11) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `authorFirst` varchar(100) DEFAULT NULL,
  `authorLast` varchar(100) DEFAULT NULL,
  `coverImage` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `bookTitle`, `published`, `copies`, `genre`, `description`, `authorFirst`, `authorLast`, `coverImage`, `created_at`) VALUES
(1, 'fourth', '2021', 1, 'Science', 'good', 'Shelby', 'Arthur', '1753035631_Soliman, Dennis Jr. 1x1.png', '2025-07-20 16:55:06'),
(2, 'Fiftth', '2021', 1, 'Science', 'good', 'Arthur', 'Shelby2', '', '2025-07-20 16:55:24'),
(3, 'The great escape', '2018', 15, 'History', 'Its about a great escape to alcatraz prison', 'Dennis', 'Soliman', '1753035537_be82af59-9f55-4f17-81f8-471f25f03e3d.jpg', '2025-07-20 17:06:04');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
