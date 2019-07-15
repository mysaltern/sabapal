-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2019 at 10:16 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sabapal`
--

-- --------------------------------------------------------

--
-- Table structure for table `wagedetail`
--

CREATE TABLE `wagedetail` (
  `id` int(11) NOT NULL,
  `wage_id` int(11) NOT NULL,
  `fixpercent` int(11) DEFAULT NULL,
  `varpercent` int(11) DEFAULT NULL,
  `date` int(11) NOT NULL,
  `startprice` int(11) NOT NULL,
  `endprice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wagedetail`
--

INSERT INTO `wagedetail` (`id`, `wage_id`, `fixpercent`, `varpercent`, `date`, `startprice`, `endprice`) VALUES
(2, 2, 3, 2, 2, 100, 200),
(3, 4, 6, 3, 0, 300, 400),
(4, 1, NULL, 6, 1, 700, 900),
(5, 4, NULL, NULL, 0, 400, 600),
(6, 3, 3, NULL, 3, 10, 300);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wagedetail`
--
ALTER TABLE `wagedetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wage_id` (`wage_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wagedetail`
--
ALTER TABLE `wagedetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `wagedetail`
--
ALTER TABLE `wagedetail`
  ADD CONSTRAINT `wagedetail_ibfk_1` FOREIGN KEY (`wage_id`) REFERENCES `wage` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
