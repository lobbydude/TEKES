-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2017 at 06:48 PM
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
-- Table structure for table `tbl_jobpost_requisitions`
--

CREATE TABLE IF NOT EXISTS `tbl_jobpost_requisitions` (
  `JP_Id` int(11) NOT NULL,
  `Department_Name` varchar(50) NOT NULL,
  `Sub_Department_Name` varchar(50) NOT NULL,
  `Job_Title` varchar(50) NOT NULL,
  `Job_Skills` varchar(50) NOT NULL,
  `Job_Type` varchar(50) NOT NULL,
  `Positions` varchar(50) NOT NULL,
  `Job_Location` varchar(50) NOT NULL,
  `Qualification` varchar(50) NOT NULL,
  `Experience` varchar(10) NOT NULL,
  `Age_Start` int(10) NOT NULL,
  `Age_End` int(10) NOT NULL,
  `Salary_Start_Range` int(30) NOT NULL,
  `Salary_End_Range` int(30) NOT NULL,
  `Job_Description` varchar(100) NOT NULL,
  `Job_Other_Information` varchar(100) NOT NULL,
  `Inserted_By` int(11) NOT NULL,
  `Inserted_Date` datetime NOT NULL,
  `Modified_By` int(11) NOT NULL,
  `Modified_Date` datetime NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_jobpost_requisitions`
--

INSERT INTO `tbl_jobpost_requisitions` (`JP_Id`, `Department_Name`, `Sub_Department_Name`, `Job_Title`, `Job_Skills`, `Job_Type`, `Positions`, `Job_Location`, `Qualification`, `Experience`, `Age_Start`, `Age_End`, `Salary_Start_Range`, `Salary_End_Range`, `Job_Description`, `Job_Other_Information`, `Inserted_By`, `Inserted_Date`, `Modified_By`, `Modified_Date`, `Status`) VALUES
(1, '8', '8', '31', '.Net,Sql,MVC framework,HTML,CSS', 'Project Based', '20', 'Bangalore123', 'BE,MCA,B-T', '2-4 Years', 26, 31, 10000, 20000, 'I want Good MVC Framework candidates1', 'Good Person only1', 58, '2017-02-04 05:12:43', 58, '2017-02-06 23:17:13', 1),
(14, '7', '10', '21', 'TitleSearch, Titletyper', 'Permanent', '20', 'Bangalore', 'Any Degree', '2-3 Years', 25, 30, 25000, 30000, 'Good Person', 'Quick Learner', 58, '2017-02-06 19:42:51', 0, '0000-00-00 00:00:00', 1),
(15, '7', '9', '17', 'TitleSearch, Titletyper', 'Permanent', '1', 'Bangalore', 'B.E,MCA', '2-3 Years', 24, 30, 25000, 30000, '123', '123', 58, '2017-02-06 23:11:07', 0, '0000-00-00 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_jobpost_requisitions`
--
ALTER TABLE `tbl_jobpost_requisitions`
  ADD PRIMARY KEY (`JP_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_jobpost_requisitions`
--
ALTER TABLE `tbl_jobpost_requisitions`
  MODIFY `JP_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
