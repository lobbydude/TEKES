-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2017 at 08:28 PM
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
-- Table structure for table `tbl_iprmaster`
--

CREATE TABLE IF NOT EXISTS `tbl_iprmaster` (
  `Kp_Id` int(10) NOT NULL,
  `Department_Id` int(10) NOT NULL,
  `Test_Name` varchar(50) NOT NULL,
  `Enable_Date` date NOT NULL,
  `Duration_Time` varchar(50) NOT NULL,
  `Month` varchar(100) NOT NULL,
  `Year` date NOT NULL,
  `Upload_Id` varchar(50) NOT NULL,
  `Inserted_By` int(11) NOT NULL,
  `Inserted_Date` datetime NOT NULL,
  `Modified_By` int(11) NOT NULL,
  `Modified_Date` datetime NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_iprmaster`
--

INSERT INTO `tbl_iprmaster` (`Kp_Id`, `Department_Id`, `Test_Name`, `Enable_Date`, `Duration_Time`, `Month`, `Year`, `Upload_Id`, `Inserted_By`, `Inserted_Date`, `Modified_By`, `Modified_Date`, `Status`) VALUES
(1, 8, 'TEST', '2017-07-10', '11/07/2017 10:30 am', '', '0000-00-00', '', 58, '2017-07-10 23:46:41', 0, '0000-00-00 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_iprmaster`
--
ALTER TABLE `tbl_iprmaster`
  ADD PRIMARY KEY (`Kp_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_iprmaster`
--
ALTER TABLE `tbl_iprmaster`
  MODIFY `Kp_Id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
