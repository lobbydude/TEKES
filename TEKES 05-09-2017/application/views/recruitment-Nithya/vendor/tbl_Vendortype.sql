-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2017 at 12:40 AM
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
-- Table structure for table `tbl_Vendortype`
--

CREATE TABLE IF NOT EXISTS `tbl_vendortype` (
  `V_Id` int(11) NOT NULL,
  `Vendor_Type` varchar(50) NOT NULL,
  `Vendor_Name` varchar(50) NOT NULL,
  `Inserted_By` int(11) NOT NULL,
  `Inserted_Date` datetime NOT NULL,
  `Modified_By` int(11) NOT NULL,
  `Modified_Date` datetime NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_Vendortype`
--

INSERT INTO `tbl_Vendortype` (`V_Id`, `Vendor_Type`, `Vendor_Name`, `Inserted_By`, `Inserted_Date`, `Modified_By`, `Modified_Date`, `Status`) VALUES
(1, 'Consultant', 'Abele Consulting', 58, '2017-02-04 05:09:24', 58, '2017-02-04 05:10:23', 1),
(2, 'Reference', 'Employees', 58, '2017-02-04 05:09:57', 58, '2017-02-04 05:10:17', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_Vendortype`
--
ALTER TABLE `tbl_Vendortype`
  ADD PRIMARY KEY (`V_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_Vendortype`
--
ALTER TABLE `tbl_Vendortype`
  MODIFY `V_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
