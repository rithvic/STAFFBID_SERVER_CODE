-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 23, 2016 at 11:28 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pilotapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `developers`
--

CREATE TABLE IF NOT EXISTS `developers` (
  `developerID` int(11) NOT NULL AUTO_INCREMENT,
  `developername` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `resetToken` varchar(255) DEFAULT NULL,
  `resetComplete` varchar(3) DEFAULT 'No',
  PRIMARY KEY (`developerID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `developers`
--

INSERT INTO `developers` (`developerID`, `developername`, `password`, `email`, `active`, `resetToken`, `resetComplete`) VALUES
(6, 'Arun', '3s4yN/rF1wMi6KwgNbN6R7DSvCTe0oQzj1i3iXW5260=', 'arun@gmail.com', 'e7a8241187f8f984738ed76b86a6d560', NULL, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `in_production`
--

CREATE TABLE IF NOT EXISTS `in_production` (
  `Video_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Video_Name` varchar(200) NOT NULL,
  `Video_SEO` varchar(200) NOT NULL,
  `Video_Thumb_URL` varchar(200) NOT NULL,
  `Video_URL` varchar(200) NOT NULL,
  `Duration` varchar(200) NOT NULL,
  `Video_Description` varchar(200) NOT NULL,
  `Video_Views` varchar(200) NOT NULL,
  `Video_Rate` varchar(200) NOT NULL,
  `Published_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Video_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `in_production`
--

INSERT INTO `in_production` (`Video_ID`, `Video_Name`, `Video_SEO`, `Video_Thumb_URL`, `Video_URL`, `Duration`, `Video_Description`, `Video_Views`, `Video_Rate`, `Published_Date`) VALUES
(1, 'test PILOT Video', 'test-pilot-video', '1d0bb70f637ed2baf7077a656080951020160220.jpg', '30e591cd95af0f9e3556e18222a1815a20160220.MOV', '5:10', 'Pilot New Videos', '', '', '2016-02-20 12:39:32'),
(2, 'test PILOT Video', 'test-pilot-video', '05460269f35700a56db9a9e074ff258820160220.jpg', 'c29fd1f8473c9666151d5d45dc20fad920160220.MOV', '5:10', 'Pilot New Videos', '', '', '2016-02-20 12:45:36'),
(3, 'test PILOT Video', 'test-pilot-video', '8833767fe3515160900ba056a24abea920160220.jpg', 'e6415bd17acd9e10b4c3f6f927e0f68320160220.MOV', '5:10', 'Pilot New Videos', '', '', '2016-02-20 12:45:55'),
(4, 'test PILOT Video', 'test-pilot-video', '5538f5329b4a8d269b2edb465075559120160220.jpg', '6ee58a99776762089d277848fd9e10c020160220.MOV', '5:10', 'Pilot New Videos', '', '', '2016-02-20 12:47:20'),
(5, 'test PILOT Video', 'test-pilot-video', '6406d91eb6e591e3c41902824c216b8520160220.jpg', 'fcb9ca1f89a020d222aa2bf0b0234c0220160220.MOV', '5:10', 'Pilot New Videos', '', '', '2016-02-20 13:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FB_ID` varchar(100) NOT NULL,
  `Device_Token` varchar(1000) NOT NULL,
  `User_Status` varchar(50) NOT NULL,
  `Joined_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Username`, `Password`, `Email`, `FB_ID`, `Device_Token`, `User_Status`, `Joined_at`) VALUES
(1, 'Arun', 'TUHQ+ZAdhnnK/Wbru84s3EmXCly25clAkxnyd/Liil8=', 'Arun@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:27:40'),
(2, 'Arun', '2aVEvGBnGM5SxeULe4/S+xQrMecVbQeDi3iD9NqVav8=', 'Arunk@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', 'Off-Line', '2016-02-19 09:53:41'),
(3, 'Arun', '7B13b+xMC9rcZjCN40rOf0WSuelzybAIPV9/MsrEJXs=', 'Arunku@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:36:28'),
(4, 'Arun', '82gEXRCfs7sZ8i3+lulpELX6WwxPmQwPzi0kWycF0v4=', 'Arunkum@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:39:13'),
(5, 'Arun', 'g5pxC3kpNxzjWR2+KT250HE0z/Jy1YN1e499cbTPeVw=', 'Arunkuma@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:43:15'),
(6, 'Arun', '0jvj0y8opFJDZ5NVtWSo4rThhXVXSdy78N0fV3Q78Vk=', 'Arunkumar@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:48:14'),
(7, 'Arun', '/fVFRWg/5C1lqYzWDynC8XpwlCNljLQNMYmn3G0bBsg=', 'Arunkumaar@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:49:48'),
(8, 'Arun', 'crgGA2Hs+rnMf4SFrVUD0DG/HPP4OKG8tTIxb7VvSz8=', 'Arunkumaarr@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:50:16'),
(9, 'Arun', '+qJ6NQcxerpnJh13bVXtwbhI3nra23VXbAfyxQoeUS4=', 'Arunkumaarrs@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:51:00'),
(10, 'Arun', '+n4bA8IIlWA5ibO8U3Ubp6fh9joHD8ASeTh0vXJhQbA=', 'Arunkumaarrss@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:51:18'),
(11, 'Arun', 'RquOjjVcWB77K1r1mEkjKPKyIIJDNVa+dWbvtQ89dBQ=', 'aArunkumaarrss@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:51:56'),
(12, 'Arun', '3z71FPKQ/wUMwdCHg39eIax2zafcqbnD2Wx9Iyvhpbc=', 'aaArunkumaarrss@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:52:57'),
(13, 'Arun', '6hN8wy9tld1yf2SWZlGiBy1zmfkQ761K28hMdxxgxVU=', 'aaArrunkumaarrss@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:53:27'),
(14, 'Arun', 'roIpeXeXn+BkKM/rVWtqsQmCFmbnTOZc3SmCx+XPVSg=', 'aaArruunkumaarrss@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 07:53:55'),
(15, 'Arun', 'gxeEqLOzTkHl7eDJc7O6w4MYAeTNcXuOeSlwjGkYd6w=', 'aaArruunnkumaarrss@gmail.com', '1234567890', '1323ewdew2312e2e32e2e2e2eweq', '', '2016-02-19 08:02:44');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
