-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 17, 2024 at 08:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roommates`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(70) NOT NULL,
  `fname` varchar(40) NOT NULL,
  `lname` varchar(40) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `budget` enum('100','150','200','250','300','350','400','450','500','550','600','650','700','750','800','850','900','950','1000','50','1050') DEFAULT NULL,
  `rating` double DEFAULT NULL,
  `telephone` varchar(20) NOT NULL,
  `description` tinytext DEFAULT NULL,
  `avatar` blob DEFAULT NULL,
  `role` varchar(15) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `fname`, `lname`, `dob`, `gender`, `city`, `budget`, `rating`, `telephone`, `description`, `avatar`, `role`) VALUES
(14, 'test@gmail.com', 'password', 'John', 'Doe', '2024-03-01', 'male', 'Subotica', '800', 3, '0608045600', 'Volim da čitam knjige.', NULL, 'user'),
(15, 'vts@gmail.com', 'vts123', 'Milan', 'Radovanovic', '2002-03-13', 'male', 'Beograd', '400', 5, '0612033900', 'Volim da programiram.', NULL, 'user'),
(17, 'vtsica@gmail.com', 'vts123', 'Milan', 'Radovanovic', '2002-03-13', 'male', 'Beograd', '400', 5, '0612033900', 'Volim da programiram.', NULL, 'user'),
(18, 'igrac@gmail.com', 'sifrica', 'Aleksandra', 'Nemić', '2004-03-04', 'female', 'Subotica', '750', 2, '0605688845', 'Volim da izlazim na kafu.', NULL, 'user'),
(20, 'igra33c@gmail.com', 'sifrica', 'Aleksandra', 'Nemić', '2004-03-04', 'female', 'Subotica', '750', 2, '0605688845', 'Volim da izlazim na kafu.', NULL, 'user'),
(21, 'qwerMC@gmail.com', 'passlaje', 'Matej', 'Kočiš', '2000-03-24', 'male', 'Niš', '300', 4, '0605670098', 'Volim da igram igrice!', NULL, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
