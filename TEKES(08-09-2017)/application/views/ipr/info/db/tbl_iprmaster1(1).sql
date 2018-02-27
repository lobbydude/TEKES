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
-- Table structure for table `tbl_iprmaster1`
--

CREATE TABLE IF NOT EXISTS `tbl_iprmaster1` (
  `IPR_Id` int(11) NOT NULL,
  `Kp_Id` int(11) NOT NULL,
  `Employee_Id` varchar(100) NOT NULL,
  `Employee_Name` varchar(50) NOT NULL,
  `Year` int(11) NOT NULL,
  `Efficiency` varchar(11) NOT NULL,
  `Accuracy` int(11) NOT NULL,
  `Punctuality` int(11) NOT NULL,
  `Process_Knowledge` int(11) NOT NULL,
  `Teamwork_Flexibility` int(11) NOT NULL,
  `Total_Efficiency` int(11) NOT NULL,
  `Total_Accuracy` int(11) NOT NULL,
  `Internal` int(11) NOT NULL,
  `External` int(11) NOT NULL,
  `Total_Errors` int(11) NOT NULL,
  `Attendance` int(11) NOT NULL,
  `Leaves` int(11) NOT NULL,
  `Weekend_Working` int(11) NOT NULL,
  `LOP` int(11) NOT NULL,
  `Overall_Score` int(11) NOT NULL,
  `Final_Rating` int(11) NOT NULL,
  `Inserted_By` int(11) NOT NULL,
  `Inserted_Date` datetime NOT NULL,
  `Modified_By` int(11) NOT NULL,
  `Modified_Date` datetime NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_iprmaster1`
--

INSERT INTO `tbl_iprmaster1` (`IPR_Id`, `Kp_Id`, `Employee_Id`, `Employee_Name`, `Year`, `Efficiency`, `Accuracy`, `Punctuality`, `Process_Knowledge`, `Teamwork_Flexibility`, `Total_Efficiency`, `Total_Accuracy`, `Internal`, `External`, `Total_Errors`, `Attendance`, `Leaves`, `Weekend_Working`, `LOP`, `Overall_Score`, `Final_Rating`, `Inserted_By`, `Inserted_Date`, `Modified_By`, `Modified_Date`, `Status`) VALUES
(1, 1, 'DRN/0188', 'Mani', 2016, '25', 2, 4, 10, 2, 55, 4, 5, 5, 2, 22, 2, 4, 1, 90, 100, 58, '2017-07-10 23:46:41', 0, '0000-00-00 00:00:00', 1),
(2, 1, 'DRN/0205', 'Ganesh', 2017, '25', 2, 4, 10, 2, 55, 4, 5, 5, 2, 22, 2, 4, 1, 90, 100, 58, '2017-07-10 23:46:41', 0, '0000-00-00 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_iprmaster1`
--
ALTER TABLE `tbl_iprmaster1`
  ADD PRIMARY KEY (`IPR_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_iprmaster1`
--
ALTER TABLE `tbl_iprmaster1`
  MODIFY `IPR_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
