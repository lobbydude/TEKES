-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2017 at 12:05 AM
-- Server version: 5.6.26
-- PHP Version: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drn_tekes`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_Jobtitle`
--

CREATE TABLE IF NOT EXISTS `tbl_jobtitle` (
  `J_Id` int(11) NOT NULL,
  `Department_Name` varchar(50) NOT NULL,
  `Subdepartment_Name` varchar(50) NOT NULL,
  `Jobtitle` varchar(50) NOT NULL,
  `Jobtype` varchar(50) NOT NULL,
  `Process` varchar(50) NOT NULL,
  `Inserted_By` int(11) NOT NULL,
  `Inserted_Date` datetime NOT NULL,
  `Modified_By` int(11) NOT NULL,
  `Modified_Date` datetime NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_Jobtitle`
--

INSERT INTO `tbl_Jobtitle` (`J_Id`, `Department_Name`, `Subdepartment_Name`, `Jobtitle`, `Jobtype`, `Process`, `Inserted_By`, `Inserted_Date`, `Modified_By`, `Modified_Date`, `Status`) VALUES
(1, '8', '8', '31', 'Permanent', 'IT-Software', 1, '2017-02-04 04:29:23', 0, '0000-00-00 00:00:00', 1),
(2, '7', '10', '37', 'Permanent', 'Titlesearch', 1, '2017-02-04 04:30:12', 1, '2017-02-04 04:30:31', 1),
(3, '7', '9', '32', 'Permanent', 'TaxSearch', 1, '2017-02-04 04:31:12', 0, '0000-00-00 00:00:00', 1),
(4, '2', '1', '30', 'Permanent', 'IT Support', 1, '2017-02-04 04:31:54', 0, '0000-00-00 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_Jobtitle`
--
ALTER TABLE `tbl_Jobtitle`
  ADD PRIMARY KEY (`J_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_Jobtitle`
--
ALTER TABLE `tbl_Jobtitle`
  MODIFY `J_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
