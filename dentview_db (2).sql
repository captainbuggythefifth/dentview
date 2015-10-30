-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 02, 2013 at 01:29 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dentview_db`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `email_add`, `password`, `approved_by`, `status`) VALUES
(1, 'Gaudencio', 'Teves', 'siklo99@yahoo.com', 'wfiCuI1zyrPg9nEki/soKzYfvpFj0hjrjOEIQAwISxAGmlMzOKjPLw+2Tu3H3fC3qWn5J3tE/0rKFDSXN8ErnQ==', 'Joel Taytayan', 'ACTIVE');

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
  `status` varchar(50) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `first_name`, `mi`, `last_name`, `address`, `email_add`, `password`, `status`) VALUES
(1, 'Joel', 'T.', 'Taytayan', 'Hipodromo', 'joeltaytayan@yahoo.com', 'WoJ4NRhId2ttnbKtRpr7um98QPyIUompKYvGZtCB0laEAZGegscQb8cF0+52AUdgKBpWGsaYAatYUSo9eOTJVQ==', 'ACTIVE'),
(2, 'Gaudencio', 'R.', 'Teves', 'Lilo-an', 'siklo99@yahoo.com', '2IikcZa7Xdop8uJWn+ciQ+F4LaqyUyljyocmscUNIVlhKYcx13QSi8gQcRyA1w7jXMBnR7EIP10muQNQJSkoDg==', 'ACTIVE');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `expertise`
--

INSERT INTO `expertise` (`id`, `doctor_id`, `service_id`, `status`) VALUES
(1, '1', '1', 'ACTIVE'),
(2, '1', '2', 'ACTIVE'),
(3, '2', '1', 'ACTIVE'),
(4, '2', '2', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `mi` varchar(20) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email_add` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `last_logged_in` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `first_name`, `mi`, `last_name`, `email_add`, `password`, `last_logged_in`, `address`, `status`) VALUES
(6, 'Gaudencio', 'R.', 'Teves', 'siklo99@yahoo.com', '8z0iXIn1B258Wv/7WKV74osyCatTM1Gt6jTirW6xOe6ZYq61JUISYaEOu4GP/IN35OGhQqNhO3N7L3fI+GY5uA==', '2013-02-02', 'Lolo-an', 'ACTIVE'),
(7, 'Dexter', 'C.', 'Lapay', 'dexterlapay@yahoo.com', 'DbkNUQ1jdGgB5xP3FJ/8/VQIXiSecoDjzoqQHKDrrTbKoG+7nvf2XLMT39OS4NusRKlZZwQOoxusg003u+0G7Q==', '2012-12-21', 'Minglanilla', 'ACTIVE'),
(8, 'Fe', 'R.', 'Teves', 'ferachoteves@yahoo.com', 'kFJ3eQFqHEPS+IfEb5YINiIBDYYOyR1pTNypAtcTDfhGllNlH2PPKa6L3NQXd76/S0ypfwX5qhFLZ7fPf5VJVA==', '2012-12-29', 'Lilo-an', 'ACTIVE'),
(9, 'Lady Maureen', 'R.', 'Teves', 'mauteves@yahoo.com', 'nWp2n2fGFpeF3FDpIgUzkkvB7zvfXMpbuYf015XaixK2S59WHVuJZJqb3eFOEUUrMU4zDAhegkLmnnbctsT4Kg==', '2013-01-15', 'Lilo-an', 'ACTIVE'),
(10, 'Gaudencio', 'B.', 'Teves', 'gauteves@yahoo.com', 'SXAVeK/ErU/miazHPLdCe9ttwLbEmYqO8Irxhzt6M6YI4caPGmDCUfy/I5qo30CEMctWTx6uf9aim4IpBIqbaQ==', '2013-01-15', 'Lilo-an', 'ACTIVE'),
(11, 'dkboi', 'm', 'lapay', 'dkboi@yahoo.com', '0HnIfEZz5eziylC6kprYoiEebQ4waBQ3WuTAvhjtS8nDNGx825FAOlhIbcOw7VoDHcjwDmZseLnZ/rvc/ustoA==', '2013-01-24', 'naga', 'ACTIVE');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`id`, `from`, `from_id`, `name`, `description`, `source`, `status`) VALUES
(1, 'service', '1', 'First_Tooth1.jpg', '', 'http://localhost/DentView/images/service/First_Tooth1.jpg', 'ACTIVE'),
(2, 'service', '1', 'First_Tooth2.jpg', '', 'http://localhost/DentView/images/service/First_Tooth2.jpg', 'ACTIVE'),
(3, 'service', '2', 'Green.jpg', '', 'http://localhost/DentView/images/service/Green.jpg', 'ACTIVE'),
(4, 'service', '1', 'WHAR.jpg', '', 'http://localhost/DentView/images/service/WHAR.jpg', 'ACTIVE'),
(5, 'service', '2', 'White.jpg', '', 'http://localhost/DentView/images/service/White.jpg', 'ACTIVE'),
(6, 'service', '2', 'bob_marley_one_love-56440.jpg', '', 'http://localhost/DentView/images/service/bob_marley_one_love-56440.jpg', 'ACTIVE'),
(10, 'patient', '6', 'Gaudencio Teves', '', 'http://localhost/DentView/images/patient/n1381418396_30151597_5416877.jpg', 'ACTIVE'),
(11, 'patient', '10', 'Gaudencio Teves', '', 'http://localhost/DentView/images/patient/backhoe21.gif', 'ACTIVE'),
(12, 'doctor', '2', 'my_profile_picture', 'Divina_Garces', 'http://localhost/DentView/images/doctor/pg.jpg', 'ACTIVE'),
(13, 'doctor', '1', 'Joel Taytayan', '', 'http://localhost/DentView/images/patient/n1381418396_30151597_5416877.jpg', 'ACTIVE'),
(14, 'patient', '11', 'dkboi lapay', 'Your profile Picture', 'http://localhost/DentView/images/patient/silhouette.jpg', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `patient_id` int(15) NOT NULL,
  `doctor_id` int(15) NOT NULL,
  `time` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `patient_id`, `doctor_id`, `time`, `date`, `status`) VALUES
(3, 6, 1, '03:00:00', '2012-12-22', 'inactive'),
(4, 6, 1, '07:00:00', '2012-12-22', 'inactive'),
(5, 6, 1, '07:00:00', '2012-12-22', 'inactive'),
(6, 6, 1, '7:00 PM', '2012-12-22', 'inactive'),
(7, 6, 1, '1:00 AM', '2012-12-31', 'inactive'),
(8, 6, 1, '15:00:00', '2013-01-01', 'inactive'),
(9, 6, 1, '03:00:00', '2013-01-04', 'INACTIVE'),
(10, 6, 1, '04:00:00', '2013-01-04', 'INACTIVE'),
(11, 6, 1, '15:00:00', '2013-01-03', 'INACTIVE'),
(12, 6, 1, '15:00:00', '2013-01-03', 'INACTIVE'),
(13, 6, 1, '15:00:00', '2013-01-03', 'INACTIVE'),
(14, 6, 1, '15:00:00', '2013-01-04', 'INACTIVE'),
(15, 6, 1, '17:00:00', '2013-01-05', 'INACTIVE'),
(16, 6, 1, '15:00:00', '2013-01-05', 'INACTIVE'),
(17, 6, 1, '10:00:00', '2013-01-08', 'INACTIVE'),
(18, 6, 1, '08:00:00', '2013-01-12', 'INACTIVE'),
(19, 6, 1, '10:00:00', '2013-01-12', 'INACTIVE'),
(20, 6, 1, '10:00:00', '2013-01-12', 'INACTIVE'),
(21, 6, 1, '11:00:00', '2013-01-12', 'INACTIVE'),
(22, 6, 1, '16:00:00', '2013-01-12', 'INACTIVE'),
(23, 6, 1, '14:00:00', '2013-01-12', 'INACTIVE'),
(24, 6, 1, '12:00:00', '2013-01-13', 'INACTIVE'),
(25, 6, 1, '18:00:00', '2013-01-13', 'INACTIVE'),
(26, 6, 1, '10:00:00', '2013-01-15', 'INACTIVE'),
(27, 6, 1, '08:00:00', '2013-01-14', 'INACTIVE'),
(28, 6, 1, '14:00:00', '2013-01-14', 'INACTIVE'),
(29, 6, 1, '10:00:00', '2013-01-18', 'INACTIVE'),
(30, 6, 1, '08:00:00', '2013-01-20', 'INACTIVE'),
(31, 6, 1, '10:00:00', '2013-01-19', 'INACTIVE'),
(32, 6, 1, '12:00:00', '2013-01-19', 'INACTIVE'),
(33, 6, 1, '11:00:00', '2013-01-20', 'INACTIVE'),
(34, 6, 1, '10:00:00', '2013-01-20', 'INACTIVE'),
(35, 6, 1, '01:00:00', '2013-01-20', 'INACTIVE'),
(36, 6, 1, '18:00:00', '2013-01-20', 'INACTIVE'),
(37, 6, 2, '10:00:00', '2013-01-21', 'INACTIVE'),
(38, 6, 2, '09:00:00', '2013-01-22', 'INACTIVE'),
(39, 6, 2, '09:00:00', '2013-01-22', 'INACTIVE'),
(40, 6, 2, '09:00:00', '2013-01-22', 'INACTIVE'),
(41, 6, 1, '11:00:00', '2013-01-23', 'INACTIVE'),
(42, 6, 1, '19:00:00', '2013-01-23', 'INACTIVE'),
(43, 6, 1, '08:00:00', '2013-01-28', 'INACTIVE'),
(44, 6, 1, '08:00:00', '2013-01-29', 'INACTIVE'),
(45, 6, 1, '08:00:00', '2013-01-31', 'INACTIVE');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `name`, `description`, `status`) VALUES
(1, 'Tooth Extraction', 'Tooth Extraction is made when the patient''s tooth is advised by the dentist to be removed', 'ACTIVE'),
(2, 'Tooth Whitening', 'This happens every 6 months.', 'ACTIVE');
