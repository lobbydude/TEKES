-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2017 at 03:50 PM
-- Server version: 5.6.26
-- PHP Version: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tekes_original`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_Information1`
--

CREATE TABLE IF NOT EXISTS `tbl_information1` (
  `IPR_Id` int(10) NOT NULL,
  `Enable_Date` date NOT NULL,
  `Employee_Id` int(10) NOT NULL,
  `Year` int(10) NOT NULL,
  `Efficiency` int(11) NOT NULL,
  `Accuracy` int(11) NOT NULL,
  `Punctuality` int(11) NOT NULL,
  `Process_Knowledge` int(11) NOT NULL,
  `Teamwork_Flexibility` int(11) NOT NULL,
  `Overall_Score` int(11) NOT NULL,
  `Final_Rating` int(11) NOT NULL,
  `Inserted_By` int(11) NOT NULL,
  `Inserted_Date` datetime NOT NULL,
  `Modified_By` int(11) NOT NULL,
  `Modified_Date` datetime NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_Information1`
--
ALTER TABLE `tbl_Information1`
  ADD PRIMARY KEY (`IPR_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_Information1`
--
ALTER TABLE `tbl_Information1`
  MODIFY `IPR_Id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
