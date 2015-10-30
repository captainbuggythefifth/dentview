-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2013 at 05:29 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dentview_final_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email_add` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `approved_by` varchar(50) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `email_add`, `password`, `approved_by`, `status`) VALUES
(1, 'Gaudencio', 'Teves', 'siklo99@yahoo.com', '130f8047dd469877b1dae5157277c545578379b7', 'Joel Taytayan', 'ACTIVE'),
(2, 'Captain', 'Buggy', 'captainbuggythefifth@gmail.com', '130f8047dd469877b1dae5157277c545578379b7', 'Gaudencio', 'ACTIVE'),
(3, 'admin', 'admin', 'admin@yahoo.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 'INACTIVE'),
(4, 'admin', 'admin', 'admin@yahoo.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 'ACTIVE'),
(5, 'alalah', 'alalah', 'alalah@yahoo.com', 'c9d8128f120cb15b695cf8d1cdf8ad5cc60e44b8', 'alalah', 'ACTIVE'),
(6, 'Admin2', 'Admin2', 'admin2@yahoo.com', '130f8047dd469877b1dae5157277c545578379b7', 'Me', 'ACTIVE'),
(7, 'docter', 'lim', 'doctor@yahoo.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Gaudencio Teves', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `customer_care`
--

CREATE TABLE IF NOT EXISTS `customer_care` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(15) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `about` varchar(100) NOT NULL,
  `query` varchar(1000) NOT NULL,
  `date_reply` int(11) NOT NULL DEFAULT '0',
  `time_reply` int(11) NOT NULL DEFAULT '0',
  `reply` int(11) NOT NULL DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `customer_care`
--

INSERT INTO `customer_care` (`id`, `patient_id`, `date`, `time`, `about`, `query`, `date_reply`, `time_reply`, `reply`, `status`) VALUES
(1, '6', '2013-03-02', '1362178986', 'asfsfd', 'adffd', 2013, 1, 0, 'INACTIVE'),
(2, '6', '2013-03-02', '1362178986', 'asfsfd', 'adffd', 2013, 0, 0, 'INACTIVE'),
(3, '6', '2013-03-02', '7:05:43', 'asf', 'adsfsdg', 2013, 1, 0, 'INACTIVE'),
(4, '6', '2013-03-02', '7:05:44', 'asf', 'adsfsdg', 2013, 0, 0, 'INACTIVE'),
(5, '6', '2013-03-02', '04:13:11', 'sdfgd', 'sdggjhkgk', 2013, 1, 0, 'INACTIVE'),
(6, '23', '2013-03-02', '11:59:05', 'alalah', 'wa', 2013, 12, 0, 'INACTIVE'),
(7, '6', '2013-03-04', '12:47:48', 'asflsdkfhdlgkfh;l', 'adshdkgfgjl;j', 0, 0, 0, 'ACTIVE'),
(8, '6', '2013-03-04', '12:49:30', 'aksflksdlkhl;', 'a;dlgjsfd;hjfhj', 0, 0, 0, 'ACTIVE'),
(9, '6', '2013-03-04', '12:58:40', 'asfdg', 'asgfhd', 0, 0, 0, 'ACTIVE'),
(10, '6', '2013-03-05', '11:24:49', 'alalalh', 'askjfakjsfalkjfk', 0, 0, 0, 'ACTIVE'),
(11, '6', '2013-03-11', '12:35:58', 'alalal', 'aefkladkf', 0, 0, 0, 'ACTIVE'),
(12, '23', '2013-03-13', '11:39:57', 'wala', 'wala gihapun', 0, 0, 0, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE IF NOT EXISTS `doctor` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `mi` varchar(15) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `email_add` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `license` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `first_name`, `mi`, `last_name`, `address`, `email_add`, `password`, `license`, `status`) VALUES
(1, 'Joel', 'T.', 'Taytayan', 'Hipodromo', 'joeltaytayan@yahoo.com', 'b9d36085e787249a0bf6c9e3ee3e6d73c742c40c', '12345', 'ACTIVE'),
(2, 'Gaudencio', 'R.', 'Teves', 'Lilo-an', 'captainbuggythefifth@gmail.com', '130f8047dd469877b1dae5157277c545578379b7', '123456', 'ACTIVE'),
(3, 'Dexter', 'C.', 'Lapay', 'Naga', 'lapay@yahoo.com', '59432f862aab0403854c26d5b9a671803676d263', '123456', 'ACTIVE'),
(4, 'docter', 'c', 'lim', 'naga', 'doctor@yahoo.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `expertise`
--

CREATE TABLE IF NOT EXISTS `expertise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` varchar(50) NOT NULL,
  `service_id` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `expertise`
--

INSERT INTO `expertise` (`id`, `doctor_id`, `service_id`, `status`) VALUES
(1, '1', '1', 'INACTIVE'),
(2, '1', '2', 'INACTIVE'),
(3, '2', '1', 'ACTIVE'),
(4, '2', '2', 'ACTIVE'),
(5, '1', '2', 'INACTIVE'),
(6, '1', '2', 'INACTIVE'),
(7, '1', '1', 'INACTIVE'),
(8, '1', '2', 'INACTIVE'),
(9, '1', '1', 'INACTIVE'),
(10, '1', '2', 'INACTIVE'),
(11, '1', '1', 'ACTIVE'),
(12, '1', '2', 'INACTIVE'),
(13, '1', '17', 'ACTIVE'),
(14, '1', '18', 'ACTIVE'),
(15, '1', '20', 'ACTIVE'),
(16, '1', '27', 'ACTIVE'),
(17, '1', '19', 'ACTIVE'),
(18, '1', '22', 'ACTIVE'),
(19, '1', '1', 'ACTIVE'),
(20, '2', '1', 'ACTIVE'),
(21, '2', '1', 'ACTIVE'),
(22, '4', '1', 'ACTIVE'),
(23, '4', '22', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(500) NOT NULL,
  `answer` varchar(500) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'ACTIVE',
  `date` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`, `status`, `date`) VALUES
(1, 'How do I make an account?', 'The users need to click the "signup" tab on the upper right corner of the screen. Fill out the form and walah!!! There you go ', 'ACTIVE', '03/09/2013'),
(2, 'How do I be able to reserve?', 'First, you have to have an account. After making one, you go to your profile, click the reserve tab(usually it is color yellow) and there you go. You can now pick your time and date, doctor and service.', 'ACTIVE', '03/12/2013');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `from` varchar(50) NOT NULL,
  `to` varchar(50) NOT NULL,
  `from_id` varchar(50) NOT NULL,
  `to_id` varchar(50) NOT NULL,
  `about` varchar(50) NOT NULL,
  `msg` varchar(500) NOT NULL,
  `time` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `from`, `to`, `from_id`, `to_id`, `about`, `msg`, `time`, `date`, `status`) VALUES
(1, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has reserved a slot on time 10:00 AM,March 05 2013', '13:44:18', '2013-03-03', 'ACTIVE'),
(2, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has rescheduled her time 10:00 AM,March 05 2013 to 3:00 PM, ', '15:16:46', '2013-03-03', 'ACTIVE'),
(3, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has rescheduled her time 4:00 PM,March 03 2013 to 3:00 PM, ', '15:24:40', '2013-03-03', 'ACTIVE'),
(4, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has rescheduled her time 3:00 PM,March 03 2013 to 4:00 PM, ', '15:26:38', '2013-03-03', 'ACTIVE'),
(5, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has rescheduled her time 4:00 PM,March 03 2013 to 3:00 PM, ', '15:27:54', '2013-03-03', 'ACTIVE'),
(6, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has rescheduled her time 3:00 PM, to 4:00 PM, ', '15:31:15', '2013-03-03', 'INACTIVE'),
(7, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has rescheduled her time 4:00 PM, to 5:00 PM, ', '15:39:04', '2013-03-03', 'ACTIVE'),
(8, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has rescheduled her time 5:00 PM,March 03 2013 to 7:00 PM, ', '15:39:43', '2013-03-03', 'ACTIVE'),
(9, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has rescheduled her time 7:00 PM,March 03 2013 to 5:00 PM, March 03 2013', '15:41:27', '2013-03-03', 'ACTIVE'),
(10, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has reserved a slot on time 6:00 PM,March 03 2013', '16:52:13', '2013-03-03', 'INACTIVE'),
(11, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has cancelled her reservation on time 5:00 PM,March 03 2013', '16:52:13', '2013-03-03', 'INACTIVE'),
(12, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has rescheduled his time 6:00 PM,March 03 2013 to 5:00 PM, March 03 2013', '16:54:49', '2013-03-03', 'INACTIVE'),
(14, 'doctor', 'patient', '2', '6', 'Reservation', 'Dr. Gaudencio Teves has rescheduled your reservation. You are now scheduled to 7:00 PM,March 03 2013.', '18:27:03', '2013-03-03', 'INACTIVE'),
(15, 'patient', 'doctor', '6', '2', 'Personal Message', 'asfsdjfdklhg', '13:51:16', '2013-03-04', 'ACTIVE'),
(16, 'doctor', 'patient', '2', '6', 'Personal Message', 'zmvmclvlbc', '16:56:54', '2013-03-04', 'ACTIVE'),
(17, 'doctor', 'patient', '2', '6', 'Personal Message', 'asdfgdfhkdskgjfgr', '17:27:42', '2013-03-04', 'ACTIVE'),
(18, 'doctor', 'patient', '2', '6', 'Personal Message', 'WWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWwWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWW', '17:28:47', '2013-03-04', 'ACTIVE'),
(19, 'patient', 'doctor', '6', '1', 'reservation', 'Gaudencio Gaudencio has made a reservation on time 10:00 AM,March 05 2013', '23:09:02', '2013-03-04', 'ACTIVE'),
(20, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has rescheduled his time 10:00 AM,March 05 2013 to 12:00 PM, March 05 2013', '23:13:52', '2013-03-04', 'ACTIVE'),
(21, 'patient', 'doctor', '6', '2', 'Personal Message', '', '23:49:04', '2013-03-04', 'ACTIVE'),
(22, 'patient', 'doctor', '6', '2', 'Personal Message', 'akkfdkdjfkjgls', '23:52:43', '2013-03-04', 'ACTIVE'),
(23, 'patient', 'doctor', '6', '3', 'Personal Message', 'alalalah!', '15:11:54', '2013-03-05', 'ACTIVE'),
(24, 'doctor', 'patient', '3', '6', 'Personal Message', 'alallalalah!', '15:12:22', '2013-03-05', 'ACTIVE'),
(25, 'patient', 'doctor', '6', '2', 'reservation', 'Gaudencio Gaudencio has made a reservation on time 6:00 PM,March 06 2013', '17:57:07', '2013-03-06', 'INACTIVE'),
(26, 'patient', 'doctor', '6', '1', 'reservation', 'Gaudencio Gaudencio has made a reservation on time 7:00 PM,March 06 2013', '18:01:19', '2013-03-06', 'ACTIVE'),
(27, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has reserved a slot on time 7:00 PM,March 06 2013', '18:02:07', '2013-03-06', 'ACTIVE'),
(28, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has cancelled her reservation on time 7:00 PM,March 06 2013', '18:02:07', '2013-03-06', 'ACTIVE'),
(29, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has reserved a slot on time 10:00 AM,March 07 2013', '18:08:29', '2013-03-06', 'ACTIVE'),
(30, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has reserved a slot on time 10:00 AM,March 07 2013', '18:10:03', '2013-03-06', 'ACTIVE'),
(31, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has cancelled her reservation on time 10:00 AM,March 07 2013', '18:10:03', '2013-03-06', 'ACTIVE'),
(32, 'doctor', 'doctor', '2', '1', 'Reservation', 'Dr. Gaudencio Teves has rescheduled you to manage Patient Gaudencio Teves on time 8:00 AM,March 07 2013.', '18:14:45', '2013-03-06', 'ACTIVE'),
(33, 'doctor', 'patient', '1', '6', 'Reservation', 'Dr. Gaudencio Teves has assigned Joel Taytayan to take care of you. You now have the schedule of 8:00 AM,March 07 2013.', '18:14:45', '2013-03-06', 'INACTIVE'),
(34, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has reserved a slot on time 10:00 AM,March 07 2013', '18:20:46', '2013-03-06', 'ACTIVE'),
(35, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has cancelled her reservation on time 8:00 AM,March 07 2013', '18:20:46', '2013-03-06', 'ACTIVE'),
(36, 'doctor', 'patient', '2', '6', 'Reservation', 'Dr. Gaudencio Teves has reschedule your reservation. You are now scheduled to 8:00 AM,March 07 2013.', '18:21:06', '2013-03-06', 'INACTIVE'),
(37, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has rescheduled his time 08:00 AM,March 07 2013 to 12:00 PM, March 07 2013', '18:25:22', '2013-03-06', 'ACTIVE'),
(38, 'doctor', 'doctor', '2', '1', 'Reservation', 'Dr. Gaudencio Teves has rescheduled you to manage Patient Gaudencio Teves on time 2:00 PM,March 07 2013.', '18:25:53', '2013-03-06', 'ACTIVE'),
(39, 'doctor', 'patient', '1', '6', 'Reservation', 'Dr. Gaudencio Teves has assigned Joel Taytayan to take care of you. You now have the schedule of 2:00 PM,March 07 2013.', '18:25:53', '2013-03-06', 'INACTIVE'),
(40, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has rescheduled his time 2:00 PM,March 07 2013 to 10:00 AM, March 08 2013', '14:29:53', '2013-03-07', 'ACTIVE'),
(41, 'doctor', 'patient', '1', '6', 'Reservation', 'Dr. Joel Taytayan has rescheduled your reservation. You are now scheduled to 8:00 AM,March 09 2013.', '17:56:47', '2013-03-07', 'INACTIVE'),
(42, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has reserved a slot on time 8:00 AM,March 09 2013', '13:52:31', '2013-03-08', 'ACTIVE'),
(43, 'patient', 'doctor', '6', '1', 'Reservation', 'Patient Gaudencio Teves has rescheduled his time 08:00 AM,March 09 2013 to 10:00 AM, April 04 2013', '17:09:43', '2013-03-08', 'ACTIVE'),
(44, 'patient', 'doctor', '6', '2', 'reservation', 'Gaudencio Gaudencio has made a reservation on time 9:00 AM,March 09 2013', '23:36:24', '2013-03-08', 'INACTIVE'),
(45, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has rescheduled his time 09:00 AM,March 09 2013 to 10:00 AM, March 09 2013', '00:08:22', '2013-03-09', 'INACTIVE'),
(46, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has rescheduled his time 10:00 AM,March 09 2013 to 10:00:00, March 09 2013', '00:08:33', '2013-03-09', 'INACTIVE'),
(47, 'patient', 'admin', '34', 'default', 'new patient', 'New registered patient', '12:52:15', '2013-03-11', 'ACTIVE'),
(48, 'patient', 'doctor', '34', '2', 'Reservation', 'Patient Jr Teves has reserved a slot on time 10:00 AM,March 13 2013', '15:23:25', '2013-03-11', 'INACTIVE'),
(49, 'doctor', 'patient', '2', '34', 'Reservation', 'Dr. Gaudencio Teves has rescheduled your reservation. You are now scheduled to 11:00 AM,March 13 2013.', '15:25:37', '2013-03-11', 'INACTIVE'),
(50, 'doctor', 'patient', '2', '34', 'Reservation', 'Dr. Gaudencio Teves has rescheduled your reservation. You are now scheduled to 2:00 PM,March 14 2013.', '20:51:43', '2013-03-12', 'ACTIVE'),
(51, 'patient', 'doctor', '6', '1', 'reservation', 'Gaudencio Gaudencio has made a reservation on time 2:00 PM,March 13 2013', '10:09:09', '2013-03-13', 'ACTIVE'),
(52, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has reserved a slot on time 12:00 PM,March 13 2013', '11:17:26', '2013-03-13', 'ACTIVE'),
(53, 'patient', 'doctor', '6', '2', 'Reservation', 'Patient Gaudencio Teves has cancelled her reservation on time 2:00 PM,March 13 2013', '11:17:26', '2013-03-13', 'ACTIVE'),
(54, 'patient', 'doctor', '6', '1', 'reservation', 'Gaudencio Gaudencio has made a reservation on time 4:00 PM,March 13 2013', '11:35:23', '2013-03-13', 'ACTIVE'),
(55, 'doctor', 'patient', '1', '6', 'Reservation', 'Dr. Joel Taytayan has rescheduled your reservation. You are now scheduled to 10:00 AM,March 14 2013.', '12:18:27', '2013-03-13', 'ACTIVE'),
(56, 'doctor', 'patient', '1', '6', 'Reservation', 'Dr. Joel Taytayan has rescheduled your reservation. You are now scheduled to 10:00 AM,March 14 2013.', '12:18:27', '2013-03-13', 'ACTIVE'),
(57, 'patient', 'doctor', '23', '1', 'reservation', 'Gaudencio Gaudencio has made a reservation on time 10:00 AM,March 15 2013', '22:02:02', '2013-03-14', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `mi` varchar(20) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `mobile_number` varchar(50) NOT NULL,
  `email_add` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `last_logged_in` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `age` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `marital_status` varchar(50) NOT NULL,
  `occupation` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `first_name`, `mi`, `last_name`, `mobile_number`, `email_add`, `password`, `last_logged_in`, `address`, `age`, `gender`, `marital_status`, `occupation`, `status`) VALUES
(6, 'Gaudencio', 'R.', 'Teves', '09424547610', 'siklo999@yahoo.com', '130f8047dd469877b1dae5157277c545578379b7', '2013-03-15', 'Lilo-an', '22', 'Male', 'Single', 'Strippers', 'ACTIVE'),
(7, 'Dexter', 'C.', 'Lapay', '09065', 'dexterlapay@yahoo.com', '84ef57391128dca19340a3747b4746a54ce9798e', '2012-12-21', 'Minglanilla', '22', 'Male', 'Single', 'Student', 'INACTIVE'),
(8, 'Fe', 'R.', 'Teves', '06565asf', 'ferachoteves@yahoo.com', 'c0261923246ea02cd0efbe3caef35f8f4685eda0', '2012-12-29', 'Lilo-an', '', '', '', '', 'INACTIVE'),
(9, 'Lady Maureen', 'R.', 'Teves', '', 'mauteves@yahoo.com', '6083dc1adfc7b41b6696df18fe255ea3e163a867', '2013-01-15', 'Lilo-an', '', '', '', '', 'ACTIVE'),
(10, 'Gaudencio', 'B.', 'Teves', 'gflhkgh', 'gauteves@yahoo.com', '9aa1aa86cd7225671c32a02c4b9d4373dbad8cee', '2013-02-10', 'Lilo-an', '', '', '', '', 'ACTIVE'),
(11, 'dkboi', 'm', 'lapay', '0643232', 'dkboi@yahoo.com', '8aabf107f41066b2ffb5614e4a67843e19cb1bca', '2013-01-24', 'naga', '', '', '', '', 'INACTIVE'),
(23, 'Gaudencio', 'R.', 'Teves', '09424547610', 'captainbuggythefifth@gmail.com', '130f8047dd469877b1dae5157277c545578379b7', '2013-03-15', 'Lilo-an', '22', 'Male', 'Single', 'Student', 'ACTIVE'),
(24, 'sgdfh', 'sdg', 'kipo', 'ioio', 'j@yahoo.com', '1e96e7d7b55002c76c7d0d9ef314fe2f5caf3565', '2013-02-16', 'oi', '', '', '', '', ''),
(25, 'Fetes', 'R', 'Teves', '09065006948', 'mama@yahoo.com', '130f8047dd469877b1dae5157277c545578379b7', '2013-02-18', 'Liloan', '', '', '', '', 'ACTIVE'),
(26, 'Gaudencio', 'T', 'Teves', '09065006948', 'papa@yahoo.com', '130f8047dd469877b1dae5157277c545578379b7', '2013-02-18', 'Liloan', '65', 'Male', 'Married', 'AirForce', 'ACTIVE'),
(27, 'girlie', 'f', 'marcellones', '980980', 'girlie@gaudi.net', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2013-02-21', 'buanoy', '19', 'Female', 'Single', 'stripper', 'ACTIVE'),
(28, 'h', 'h', 'h', 'h', 'test@yahoo.com', '130f8047dd469877b1dae5157277c545578379b7', '2013-02-26', 'h', '10', 'Male', 'Single', 'wa', 'ACTIVE'),
(29, 'Nikko', 'O', 'Ebuen', '0942123', 'ebuen.nikko@yahoo.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2013-03-02', 'Laray', '20', 'Male', 'Single', 'Stripper', ''),
(30, 'akfjkd', 'akdfjskl', 'ajkdlfjl', 'sdkjgkl', 'kasd@;yahoo.com', 'fa92e1b503c6ddce8e5d8f924fa7e0b3afedad1a', '2013-03-07', 'sdgj', 'klsdg', 'Male', 'Single', 'ajdskjsfkd', ''),
(31, 'jakdljgk', 'ksjdkgj', 'kgjsdkflj', 'kgsflj', 'cap@yahoo.com', '5075bbb9ccafaefb80224eee7a07260577b5adc2', '2013-03-07', 'wgdsf', 'kjgsk', 'Male', 'Single', 'adkjfgk', ''),
(32, 'sdkfldf', 'sklgk', 'skdlgk', 'sldgk', 'sik@yahoo.com', 'd8789eae6b01002d29c85e9db9b8493feb96032f', '2013-03-07', 'slfgk', 'asgdk', 'Male', 'Single', 'asdklgds', ''),
(33, 'Mais', 'H.', 'Humay', '09065006948', 'manga@yahoo.com', '1c404c691e1ce199d7682f5526652b4f55d19326', '2013-03-07', 'Bulacao', '69', 'Female', 'Married', 'Stripper', ''),
(34, 'Jr', 'R.', 'Teves', '09424547610', 'admin@yahoo.com', '130f8047dd469877b1dae5157277c545578379b7', '2013-03-11', 'Lilo-an', '22', 'Male', 'Single', 'Stripper', 'ACTIVE'),
(35, 'Admin', 'A.', 'Admin', '09065006948', 'admin2@yahoo.com', '130f8047dd469877b1dae5157277c545578379b7', '2013-03-13', 'Lilo-an', '22', 'Male', 'Single', 'Stripper', ''),
(36, 'Gaudencio', 'R.', 'Teves', '09065006948', 'admin3@yahoo.com', '87ab983b0db52b7f71c5b8942b1ebfcade8500d6', '2013-03-13', 'Lilo-an', '22', 'Male', 'Single', 'Student', '');

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `from` varchar(50) NOT NULL,
  `from_id` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `source` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`id`, `from`, `from_id`, `name`, `description`, `source`, `status`) VALUES
(1, 'service', '1', 'Mange', 'Tinidor', 'images/service/First_Tooth1.jpg', 'INACTIVE'),
(2, 'service', '1', 'First_Tooth2.jpg', '', 'images/service/First_Tooth2.jpg', 'INACTIVE'),
(3, 'service', '2', 'Green.jpg', '', 'images/service/Green.jpg', 'ACTIVE'),
(4, 'service', '1', 'WHAR.jpg', '', 'images/service/WHAR.jpg', 'INACTIVE'),
(5, 'service', '2', 'White.jpg', '', 'images/service/White.jpg', 'ACTIVE'),
(6, 'service', '2', 'bob_marley_one_love-56440.jpg', '', 'images/service/bob_marley_one_love-56440.jpg', 'ACTIVE'),
(10, 'patient', '6', 'Gaudencio Teves', '', 'images/patient/n1381418396_30151597_5416877.jpg', 'ACTIVE'),
(11, 'patient', '10', 'Gaudencio Teves', '', 'images/patient/backhoe21.gif', 'ACTIVE'),
(12, 'doctor', '2', 'Gaudencio_Teves', '', 'images/doctor/blank-profile.jpg', 'ACTIVE'),
(13, 'doctor', '1', 'Joel Taytayan', '', 'images/patient/joel_taytayan.jpg', 'ACTIVE'),
(14, 'patient', '11', 'dkboi lapay', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(15, 'patient', '7', ' Lapay', ' Lapay', 'images/patient/silhouette.jpg', 'ACTIVE'),
(16, 'patient', '8', ' Teves', ' Teves', 'images/patient/silhouette.jpg', 'ACTIVE'),
(17, 'patient', '9', ' Teves', ' Teves', 'images/patient/silhouette.jpg', 'ACTIVE'),
(18, 'doctor', '3', 'Dexter_Lapay', '', 'images/doctor/silhoutte.jpg', 'ACTIVE'),
(19, 'patient', '12', ' ', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(20, 'patient', '13', ' ', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(21, 'patient', '14', 'Captain Buggy', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(22, 'patient', '15', 'Captain Buggy', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(23, 'patient', '16', 'Captain Buggy', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(24, 'patient', '17', 'Captain Buggy', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(25, 'patient', '18', 'Captain Buggy', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(26, 'service', '2', 'alalah.jpg', '', 'images/service/alalah.jpg', 'ACTIVE'),
(27, 'patient', '19', 'Gaudencio Teves', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(28, 'patient', '20', 'Gaudencio Teves', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(29, 'patient', '21', 'Gaudencio Teves', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(30, 'patient', '22', 'Gaudencio Teves', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(31, 'patient', '23', 'Gaudencio Teves', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(32, 'service', '2', 'silhoutte.jpg', '', 'images/service/silhoutte.jpg', 'ACTIVE'),
(33, 'service', '7', 'blank-profile.jpg', '', 'images/service/blank-profile.jpg', 'ACTIVE'),
(34, 'service', '7', 'asfd.jpg', '', 'images/service/asfd.jpg', 'ACTIVE'),
(35, 'service', '7', 'n1381418396_30151588_1432547.jpg', '', 'images/service/n1381418396_30151588_1432547.jpg', 'ACTIVE'),
(36, 'service', '17', 'Oral_Prophalaxis.jpg', 'Gwapa', 'images/service/Oral_Prophalaxis.jpg', 'INACTIVE'),
(37, 'patient', '24', 'sgdfh kipo', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(38, 'service', '17', 'Ping2x.jpg', '', 'images/service/Ping2x.jpg', 'INACTIVE'),
(39, 'patient', '25', 'Fe Teves', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(40, 'patient', '26', 'Gaudencio Teves', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(41, 'service', '1', 'Extracted.jpg', '', 'images/service/Extracted.jpg', 'ACTIVE'),
(42, 'service', '18', 'Filled.jpg', 'Filled up the hole in the tooth', 'images/service/Filled.jpg', 'ACTIVE'),
(43, 'service', '19', 'endodontics.jpg', 'Piercing of the tooth  for the operation', 'images/service/endodontics.jpg', 'ACTIVE'),
(44, 'service', '20', '1.jpg', 'Bracing the tooth of the patient for support', 'images/service/1.jpg', 'ACTIVE'),
(45, 'service', '21', 'Cosmetics.jpg', 'Beautifying the tooth of the patient', 'images/service/Cosmetics.jpg', 'ACTIVE'),
(46, 'service', '22', '11.jpg', 'Veneers', 'images/service/11.jpg', 'ACTIVE'),
(47, 'service', '23', '1(dental_site).jpg', '', 'images/service/1(dental_site).jpg', 'ACTIVE'),
(48, 'service', '24', '2.jpg', '', 'images/service/2.jpg', 'ACTIVE'),
(49, 'service', '25', '21.jpg', '', 'images/service/21.jpg', 'ACTIVE'),
(50, 'service', '27', 'New.jpg', 'New', 'images/service/New.jpg', 'ACTIVE'),
(51, 'service', '27', 'New1.jpg', 'New', 'images/service/New1.jpg', 'ACTIVE'),
(52, 'service', '27', 'New2.jpg', 'New', 'images/service/New2.jpg', 'INACTIVE'),
(53, 'service', '27', 'new3.jpg', 'new', 'images/service/new3.jpg', 'ACTIVE'),
(54, 'service', '27', 'new4.jpg', 'new', 'images/service/new4.jpg', 'INACTIVE'),
(55, 'service', '27', 'new5.jpg', 'new', 'images/service/new5.jpg', 'ACTIVE'),
(56, 'service', '27', 'sakit_ngipon.jpg', 'sakit ngipon', 'images/service/sakit_ngipon.jpg', 'INACTIVE'),
(57, 'patient', '27', 'girlie marcellones', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(58, 'patient', '28', 'h h', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(59, 'service', '1', 'apache_pb.png', '', 'images/service/apache_pb.png', 'ACTIVE'),
(60, 'patient', '29', 'Nikko Ebuen', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(61, 'patient', '30', 'akfjkd ajkdlfjl', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(62, 'patient', '31', 'jakdljgk kgjsdkflj', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(63, 'patient', '32', 'sdkfldf skdlgk', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(64, 'patient', '33', 'Mais Humay', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(65, 'patient', '34', 'Jr Teves', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(66, 'patient', '35', 'Admin Admin', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(67, 'service', '17', 'Oral_Prophalaxis1.jpg', '', 'images/service/Oral_Prophalaxis1.jpg', 'ACTIVE'),
(68, 'service', '26', 'Surgery.jpg', '', 'images/service/Surgery.jpg', 'ACTIVE'),
(69, 'patient', '36', 'Gaudencio Teves', 'Your profile Picture', 'images/patient/silhouette.jpg', 'ACTIVE'),
(70, 'doctor', '4', 'docter_lim', '', 'images/doctor/childrn_dentstry.jpg', 'ACTIVE'),
(71, 'service', '19', 'weq.jpg', '', 'images/service/weq.jpg', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE IF NOT EXISTS `prescription` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(15) NOT NULL,
  `doctor_id` varchar(15) NOT NULL,
  `date` varchar(50) NOT NULL,
  `medicine` varchar(500) NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`id`, `patient_id`, `doctor_id`, `date`, `medicine`, `remarks`, `status`) VALUES
(1, '6', '2', '02/27/2013', 'alalah!', 'alalah!', 'ACTIVE'),
(2, '7', '1', '02/26/2013', 'dgsfhg', 'dfghj', 'ACTIVE'),
(3, '6', '1', '03/13/2013', 'medicol', '3 times a day', 'ACTIVE'),
(4, '6', '1', '03/13/2013', 'biogesic', 'wapak', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `record`
--

CREATE TABLE IF NOT EXISTS `record` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(15) NOT NULL,
  `date` varchar(50) NOT NULL,
  `occlusion` varchar(200) NOT NULL,
  `periodical_condition` varchar(200) NOT NULL,
  `oral_hygiene` varchar(200) NOT NULL,
  `denture_upper_since` varchar(200) NOT NULL,
  `denture_lower_since` varchar(200) NOT NULL,
  `abnormalities` varchar(200) NOT NULL,
  `general_condition` varchar(200) NOT NULL,
  `physician` varchar(200) NOT NULL,
  `nature_of_treatment` varchar(200) NOT NULL,
  `allergies` varchar(200) NOT NULL,
  `previous_history_of_bleeding` varchar(200) NOT NULL,
  `chronic_ailments` varchar(200) NOT NULL,
  `blood_pressure` varchar(100) NOT NULL,
  `drugs_being_taken` varchar(200) NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `record`
--

INSERT INTO `record` (`id`, `patient_id`, `date`, `occlusion`, `periodical_condition`, `oral_hygiene`, `denture_upper_since`, `denture_lower_since`, `abnormalities`, `general_condition`, `physician`, `nature_of_treatment`, `allergies`, `previous_history_of_bleeding`, `chronic_ailments`, `blood_pressure`, `drugs_being_taken`, `status`) VALUES
(1, '6', '02/20/2013', 'wa', 'wsa', 'se', 'se', 'se', 'es', 'ae', 'se', 'ase', 'se', 'se', 'se', 'es', 'asd', 'ACTIVE'),
(2, '6', '02/22/2013', 'Naa', 'Ok ra', 'Baho', 'Wa', 'Wa', 'Wa', 'Ok ra', 'Gaudencio', 'Extraction', 'Wa', 'Wa', 'Wa', '1000/29', 'Blue', 'ACTIVE'),
(3, '25', '03/14/2013', 'none', '', '', '', '', '', '', '', '', '', '', '', '', '', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `patient_id` int(15) NOT NULL,
  `doctor_id` int(15) NOT NULL,
  `time` varchar(20) NOT NULL,
  `hour` varchar(20) NOT NULL,
  `service_ids` varchar(100) NOT NULL,
  `specified_service` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=91 ;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `patient_id`, `doctor_id`, `time`, `hour`, `service_ids`, `specified_service`, `date`, `status`) VALUES
(3, 6, 1, '03:00:00', '', '', '', '2012-12-22', 'inactive'),
(4, 6, 1, '07:00:00', '', '', '', '2012-12-22', 'inactive'),
(5, 6, 1, '07:00:00', '', '', '', '2012-12-22', 'inactive'),
(6, 6, 1, '7:00 PM', '', '', '', '2012-12-22', 'inactive'),
(7, 6, 1, '1:00 AM', '', '', '', '2012-12-31', 'inactive'),
(8, 6, 1, '15:00:00', '', '', '', '2013-01-01', 'inactive'),
(9, 6, 1, '03:00:00', '', '', '', '2013-01-04', 'INACTIVE'),
(10, 6, 1, '04:00:00', '', '', '', '2013-01-04', 'INACTIVE'),
(11, 6, 1, '15:00:00', '', '', '', '2013-01-03', 'INACTIVE'),
(12, 6, 1, '15:00:00', '', '', '', '2013-01-03', 'INACTIVE'),
(13, 6, 1, '15:00:00', '', '', '', '2013-01-03', 'INACTIVE'),
(14, 6, 1, '15:00:00', '', '', '', '2013-01-04', 'INACTIVE'),
(15, 6, 1, '17:00:00', '', '', '', '2013-01-05', 'INACTIVE'),
(16, 6, 1, '15:00:00', '', '', '', '2013-01-05', 'INACTIVE'),
(17, 6, 1, '10:00:00', '', '', '', '2013-01-08', 'INACTIVE'),
(18, 6, 1, '08:00:00', '', '', '', '2013-01-12', 'INACTIVE'),
(19, 6, 1, '10:00:00', '', '', '', '2013-01-12', 'INACTIVE'),
(20, 6, 1, '10:00:00', '', '', '', '2013-01-12', 'INACTIVE'),
(21, 6, 1, '11:00:00', '', '', '', '2013-01-12', 'INACTIVE'),
(22, 6, 1, '16:00:00', '', '', '', '2013-01-12', 'INACTIVE'),
(23, 6, 1, '14:00:00', '', '', '', '2013-01-12', 'INACTIVE'),
(24, 6, 1, '12:00:00', '', '', '', '2013-01-13', 'INACTIVE'),
(25, 6, 1, '18:00:00', '', '', '', '2013-01-13', 'INACTIVE'),
(26, 6, 1, '10:00:00', '', '', '', '2013-01-15', 'INACTIVE'),
(27, 6, 1, '08:00:00', '', '', '', '2013-01-14', 'INACTIVE'),
(28, 6, 1, '14:00:00', '', '', '', '2013-01-14', 'INACTIVE'),
(29, 6, 1, '10:00:00', '', '', '', '2013-01-18', 'INACTIVE'),
(30, 6, 1, '08:00:00', '', '', '', '2013-01-20', 'INACTIVE'),
(31, 6, 1, '10:00:00', '', '', '', '2013-01-19', 'INACTIVE'),
(32, 6, 1, '12:00:00', '', '', '', '2013-01-19', 'INACTIVE'),
(33, 6, 1, '11:00:00', '', '', '', '2013-01-20', 'INACTIVE'),
(34, 6, 1, '10:00:00', '', '', '', '2013-01-20', 'INACTIVE'),
(35, 6, 1, '01:00:00', '', '', '', '2013-01-20', 'INACTIVE'),
(36, 6, 1, '18:00:00', '', '', '', '2013-01-20', 'INACTIVE'),
(37, 6, 2, '10:00:00', '', '', '', '2013-01-21', 'INACTIVE'),
(38, 6, 2, '09:00:00', '', '', '', '2013-01-22', 'INACTIVE'),
(39, 6, 2, '09:00:00', '', '', '', '2013-01-22', 'INACTIVE'),
(40, 6, 2, '09:00:00', '', '', '', '2013-01-22', 'INACTIVE'),
(41, 6, 1, '11:00:00', '', '', '', '2013-01-23', 'INACTIVE'),
(42, 6, 1, '19:00:00', '', '', '', '2013-01-23', 'INACTIVE'),
(43, 6, 1, '08:00:00', '', '', '', '2013-01-28', 'INACTIVE'),
(44, 6, 1, '08:00:00', '', '', '', '2013-01-29', 'INACTIVE'),
(45, 6, 1, '08:00:00', '', '', '', '2013-01-31', 'INACTIVE'),
(46, 6, 2, '19:00:00', '2', '1,2', 'NONE', '2013-02-12', 'INACTIVE'),
(47, 6, 1, '14:00:00', '1', 'NONE', 'NONE', '2013-02-14', 'INACTIVE'),
(48, 6, 2, '11:00:00', '2', '1,2', 'NONE', '2013-02-13', 'INACTIVE'),
(49, 6, 2, '12:00:00', '2', '1,2', 'NONE', '2013-02-14', 'INACTIVE'),
(58, 23, 2, '11:00:00', '2', '1,2', 'NONE', '2013-02-16', 'INACTIVE'),
(59, 6, 2, '17:00:00', '2', '1,2', 'NONE', '2013-02-19', 'INACTIVE'),
(60, 26, 2, '14:00:00', '2', '1,2', 'NONE', '2013-02-19', 'INACTIVE'),
(61, 23, 2, '13:00:00', '2', '1,2', 'NONE', '2013-02-22', 'INACTIVE'),
(62, 6, 2, '10:00:00', '2', '1,2', 'NONE', '2013-02-22', 'INACTIVE'),
(63, 27, 2, '18:00:00', '1', 'NONE', 'NONE', '2013-02-21', 'INACTIVE'),
(64, 6, 2, '15:00:00', '2', '1,2', 'NONE', '2013-02-24', 'INACTIVE'),
(65, 6, 2, '15:00:00', '2', '1,2', 'NONE', '2013-02-24', 'INACTIVE'),
(66, 6, 2, '15:00:00', '2', '1,2', 'NONE', '2013-02-24', 'INACTIVE'),
(67, 6, 2, '15:00:00', '2', '1,2', 'NONE', '2013-02-24', 'INACTIVE'),
(68, 6, 2, '15:00:00', '2', '1,2', 'NONE', '2013-02-24', 'INACTIVE'),
(69, 6, 2, '17:00:00', '2', '1,2', 'NONE', '2013-02-24', 'INACTIVE'),
(70, 6, 2, '14:00:00', '2', '1,2', 'NONE', '2013-02-25', 'INACTIVE'),
(72, 7, 1, '11:00:00', '1', 'NONE', 'NONE', '2013-02-26', 'INACTIVE'),
(73, 25, 1, '13:00:00', '2', '1,2', 'NONE', '2013-02-26', 'INACTIVE'),
(74, 6, 2, '10:00:00', '2', '1,2', 'NONE', '2013-03-01', 'INACTIVE'),
(75, 6, 2, '16:00:00', '1', 'NONE', 'NONE', '2013-03-04', 'INACTIVE'),
(76, 6, 1, '10:00:00', '2', '1,2', 'NONE', '2013-03-05', 'INACTIVE'),
(77, 6, 1, '12:00:00', '1', 'NONE', 'NONE', '2013-03-05', 'INACTIVE'),
(78, 6, 2, '13:00:00', '1', 'NONE', 'NONE', '2013-03-03', 'INACTIVE'),
(79, 23, 2, '14:00:00', '1', 'NONE', 'NONE', '2013-03-03', 'INACTIVE'),
(80, 6, 2, '19:00:00', '1', 'NONE', 'NONE', '2013-03-03', 'INACTIVE'),
(81, 6, 1, '12:00:00', '1', 'NONE', 'NONE', '2013-03-05', 'INACTIVE'),
(82, 6, 2, '18:00:00', '1', '2', 'NONE', '2013-03-06', 'INACTIVE'),
(83, 6, 2, '19:00:00', '1', 'NONE', 'NONE', '2013-03-06', 'INACTIVE'),
(84, 6, 1, '08:00:00', '1', 'NONE', 'NONE', '2013-03-09', 'INACTIVE'),
(85, 6, 1, '10:00:00', '1', 'NONE', 'NONE', '2013-04-04', 'INACTIVE'),
(86, 6, 2, '10:00:00', '1', '2', 'NONE', '2013-03-09', 'INACTIVE'),
(87, 34, 2, '14:00:00', '1', 'NONE', 'NONE', '2013-03-14', 'INACTIVE'),
(88, 6, 2, '12:00:00', '1', 'NONE', 'NONE', '2013-03-13', 'INACTIVE'),
(89, 6, 1, '10:00:00', '2', '17,19', 'NONE', '2013-03-14', 'ACTIVE'),
(90, 23, 1, '10:00:00', '1', 'NONE', 'NONE', '2013-03-15', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `secretary`
--

CREATE TABLE IF NOT EXISTS `secretary` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email_add` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `under_of` varchar(15) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `secretary`
--

INSERT INTO `secretary` (`id`, `first_name`, `last_name`, `email_add`, `password`, `under_of`, `status`) VALUES
(1, 'John', 'Scobert', 'siklo99@yahoo.com', '130f8047dd469877b1dae5157277c545578379b7', '2', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `name`, `description`, `status`) VALUES
(1, 'Tooth Extraction', 'When the patient is in excrutiating pain', 'INACTIVE'),
(2, 'Tooth Whitening', 'This happens every 6 months.', 'INACTIVE'),
(17, 'Oral Prophylaxis', 'Cleaning', 'ACTIVE'),
(18, 'Filling', 'Pasta', 'ACTIVE'),
(19, 'Endodontics', 'Root Canal Therapy', 'ACTIVE'),
(20, 'Orthodontics', 'Braces', 'ACTIVE'),
(21, 'Cosmetics', '', 'ACTIVE'),
(22, 'Veneers', 'Laminates', 'ACTIVE'),
(23, 'Jacket Crown', '', 'ACTIVE'),
(24, 'Dentures', 'Postiso', 'ACTIVE'),
(25, 'TMJ Problem', 'TMJD', 'ACTIVE'),
(26, 'Surgery', '', 'ACTIVE'),
(27, 'New Tooth Service', 'Newest service available in town', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE IF NOT EXISTS `system` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `date` varchar(50) NOT NULL,
  `whole_day` tinyint(1) NOT NULL DEFAULT '0',
  `time_in` varchar(50) NOT NULL,
  `time_out` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`id`, `date`, `whole_day`, `time_in`, `time_out`, `status`) VALUES
(4, '19', 0, '6', '19', 'ACTIVE'),
(5, '', 0, '10', '19', 'ACTIVE'),
(6, '03/01/2013', 0, '13:00:00', '18:00:00', 'ACTIVE'),
(7, '03/02/2013', 0, '10:00:00', '18:00:00', 'ACTIVE'),
(8, '03/04/2013', 1, '10:00:00', '19:00:00', 'ACTIVE'),
(9, '03/08/2013', 1, '10:00:00', '19:00:00', 'ACTIVE'),
(10, '03/09/2013', 0, '8:00:00', '11:00:00', 'ACTIVE'),
(11, '', 0, '10:00:00', '19:00:00', 'ACTIVE'),
(12, '03/14/2013', 1, '10:00:00', '19:00:00', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `tooth_adult`
--

CREATE TABLE IF NOT EXISTS `tooth_adult` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(15) NOT NULL,
  `date` varchar(15) NOT NULL,
  `18` varchar(100) NOT NULL DEFAULT '',
  `17` varchar(100) NOT NULL DEFAULT '',
  `16` varchar(100) NOT NULL DEFAULT '',
  `15` varchar(100) NOT NULL DEFAULT '',
  `14` varchar(100) NOT NULL DEFAULT '',
  `13` varchar(100) NOT NULL DEFAULT '',
  `12` varchar(100) NOT NULL DEFAULT '',
  `11` varchar(100) NOT NULL DEFAULT '',
  `21` varchar(100) NOT NULL DEFAULT '',
  `22` varchar(100) NOT NULL DEFAULT '',
  `23` varchar(100) NOT NULL DEFAULT '',
  `24` varchar(100) NOT NULL DEFAULT '',
  `25` varchar(100) NOT NULL DEFAULT '',
  `26` varchar(100) NOT NULL DEFAULT '',
  `27` varchar(100) NOT NULL DEFAULT '',
  `28` varchar(100) NOT NULL DEFAULT '',
  `48` varchar(100) NOT NULL DEFAULT '',
  `47` varchar(100) NOT NULL DEFAULT '',
  `46` varchar(100) NOT NULL DEFAULT '',
  `45` varchar(100) NOT NULL DEFAULT '',
  `44` varchar(100) NOT NULL DEFAULT '',
  `43` varchar(100) NOT NULL DEFAULT '',
  `42` varchar(100) NOT NULL DEFAULT '',
  `41` varchar(100) NOT NULL DEFAULT '',
  `31` varchar(100) NOT NULL DEFAULT '',
  `32` varchar(100) NOT NULL DEFAULT '',
  `33` varchar(100) NOT NULL DEFAULT '',
  `34` varchar(100) NOT NULL DEFAULT '',
  `35` varchar(100) NOT NULL DEFAULT '',
  `36` varchar(100) NOT NULL DEFAULT '',
  `37` varchar(100) NOT NULL DEFAULT '',
  `38` varchar(100) NOT NULL DEFAULT '',
  `status` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tooth_adult`
--

INSERT INTO `tooth_adult` (`id`, `patient_id`, `date`, `18`, `17`, `16`, `15`, `14`, `13`, `12`, `11`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `48`, `47`, `46`, `45`, `44`, `43`, `42`, `41`, `31`, `32`, `33`, `34`, `35`, `36`, `37`, `38`, `status`) VALUES
(1, '6', '', '  RF  ', '  PFB', ' ', '  LC ', '  Ag ', ' ', ' ', '', ' ', ' ', '', ' ', '', '', '', '', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '', ' ', ' ', ' ', ' ', 'ACTIVE'),
(2, '23', '2013-02-20', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, '27', '2013-02-21', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, '28', '2013-02-26', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, '34', '2013-03-11', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tooth_child`
--

CREATE TABLE IF NOT EXISTS `tooth_child` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(15) NOT NULL,
  `date` varchar(20) NOT NULL,
  `55` varchar(100) NOT NULL DEFAULT '',
  `54` varchar(100) NOT NULL DEFAULT '',
  `53` varchar(100) NOT NULL DEFAULT '',
  `52` varchar(100) NOT NULL DEFAULT '',
  `51` varchar(100) NOT NULL DEFAULT '',
  `61` varchar(100) NOT NULL DEFAULT '',
  `62` varchar(100) NOT NULL DEFAULT '',
  `63` varchar(100) NOT NULL DEFAULT '',
  `64` varchar(100) NOT NULL DEFAULT '',
  `65` varchar(100) NOT NULL DEFAULT '',
  `85` varchar(100) NOT NULL DEFAULT '',
  `84` varchar(100) NOT NULL DEFAULT '',
  `83` varchar(100) NOT NULL DEFAULT '',
  `82` varchar(100) NOT NULL DEFAULT '',
  `81` varchar(100) NOT NULL DEFAULT '',
  `71` varchar(100) NOT NULL DEFAULT '',
  `72` varchar(100) NOT NULL DEFAULT '',
  `73` varchar(100) NOT NULL DEFAULT '',
  `74` varchar(100) NOT NULL DEFAULT '',
  `75` varchar(100) NOT NULL DEFAULT '',
  `status` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tooth_child`
--

INSERT INTO `tooth_child` (`id`, `patient_id`, `date`, `55`, `54`, `53`, `52`, `51`, `61`, `62`, `63`, `64`, `65`, `85`, `84`, `83`, `82`, `81`, `71`, `72`, `73`, `74`, `75`, `status`) VALUES
(1, '6', '0', ' PJC  RPD  AJC  M ', ' RPD  PJC ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'ACTIVE'),
(2, '28', '2013-02-26', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(15) NOT NULL,
  `date` varchar(20) NOT NULL,
  `treatment_rendered` varchar(300) NOT NULL,
  `fee` varchar(100) NOT NULL,
  `paid` varchar(100) NOT NULL,
  `balance` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `patient_id`, `date`, `treatment_rendered`, `fee`, `paid`, `balance`, `status`) VALUES
(1, '6', '02/21/2013', 'Tooth Extraction', '20000', '20000', '0', 'ACTIVE'),
(2, '6', '02/20/2013', 'Tooth Whitening', '3000', '3000', '90', 'ACTIVE');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
