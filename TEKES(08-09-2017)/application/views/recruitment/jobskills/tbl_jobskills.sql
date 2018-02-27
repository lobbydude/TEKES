-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2017 at 12:19 AM
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
-- Table structure for table `tbl_jobskills`
--

CREATE TABLE IF NOT EXISTS `tbl_jobskills` (
  `S_Id` int(11) NOT NULL,
  `Jobtitle` varchar(50) NOT NULL,
  `Jobskills` varchar(50) NOT NULL,
  `Inserted_By` int(11) NOT NULL,
  `Inserted_Date` datetime NOT NULL,
  `Modified_By` int(11) NOT NULL,
  `Modified_Date` datetime NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_jobskills`
--

INSERT INTO `tbl_jobskills` (`S_Id`, `Jobtitle`, `Jobskills`, `Inserted_By`, `Inserted_Date`, `Modified_By`, `Modified_Date`, `Status`) VALUES
(1, '31', 'PHP Mysql, Codeignator,HTML,CSS,Jquery', 1, '2017-02-04 04:46:06', 0, '0000-00-00 00:00:00', 1),
(2, '21', 'TitleSearch, Titletyper', 1, '2017-02-04 04:47:31', 0, '0000-00-00 00:00:00', 1),
(3, '54', 'Manual Testing, Automated Testing', 1, '2017-02-04 04:48:02', 0, '0000-00-00 00:00:00', 1),
(4, '31', '.Net,Sql,MVC framework,HTML,CSS', 1, '2017-02-04 04:49:03', 0, '0000-00-00 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_jobskills`
--
ALTER TABLE `tbl_jobskills`
  ADD PRIMARY KEY (`S_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_jobskills`
--
ALTER TABLE `tbl_jobskills`
  MODIFY `S_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
