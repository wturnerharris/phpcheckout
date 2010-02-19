-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 18, 2010 at 09:38 PM
-- Server version: 5.1.43
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `witdesig_equipment`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessorytype`
--

CREATE TABLE IF NOT EXISTS `accessorytype` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=121 ;

--
-- Dumping data for table `accessorytype`
--

INSERT INTO `accessorytype` (`ID`, `Name`) VALUES
(0, 'Accessory'),
(1, 'Charger'),
(2, 'Lav Mic'),
(3, 'DV Cable'),
(4, 'AV Cable'),
(5, 'Headphones'),
(6, '.5x Wide-Angle adapter'),
(7, '2x Telephoto adaper'),
(8, 'Neutral Density Filter'),
(9, 'Charger AC cord'),
(10, 'AC Battery insert'),
(11, 'Docking Station'),
(12, 'Bubble level'),
(13, 'Camera light'),
(14, 'Charger DC cord'),
(15, 'USB Cable'),
(16, '4 AA Rechargeable Batteries'),
(17, 'AA Battery Charger'),
(18, '2gb Compact Flash Card'),
(19, 'Film Back'),
(20, '80mm Lens'),
(21, '18-55mm stock lens'),
(22, 'Lens Cap'),
(23, 'Tripod'),
(24, '8gb SD card'),
(25, 'Light Stand'),
(26, 'Omni Light'),
(27, 'Rubber case'),
(28, 'AC Cord'),
(29, 'Umbrella reflector'),
(30, 'Gel Frame'),
(31, 'Mounting Plate'),
(32, 'Extension Cord'),
(33, 'USB Extension'),
(34, 'AC Adapter'),
(35, 'XLR Cord'),
(36, 'Power/PC Sync Cord'),
(37, 'Bag of washers'),
(38, 'Box of screws'),
(39, 'Mounting Plate'),
(40, 'Wiring Harness'),
(41, 'Battery Pack'),
(42, 'Manual Winder'),
(43, 'Bag'),
(44, 'Component Video Cable'),
(45, 'Rain Cover'),
(46, 'Dark Cloth'),
(47, 'Remote Cord'),
(48, '4x5 Film Holder'),
(49, '18-70mm lens');

-- --------------------------------------------------------

--
-- Table structure for table `checkedout`
--

CREATE TABLE IF NOT EXISTS `checkedout` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `KitID` int(11) NOT NULL DEFAULT '0',
  `StudentID` varchar(24) NOT NULL DEFAULT '0',
  `DateOut` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ExpectedDateIn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DateIn` varchar(255) NOT NULL DEFAULT '',
  `FinePaid` varchar(255) DEFAULT NULL,
  `Reserved` int(11) DEFAULT NULL,
  `Accessories` varchar(255) NOT NULL DEFAULT '',
  `Notes` varchar(255) DEFAULT NULL,
  `Problem` int(1) NOT NULL DEFAULT '0',
  `CheckoutUser` varchar(255) NOT NULL DEFAULT '0',
  `CheckinUser` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`ID`, `Name`) VALUES
(1, 'Class'),

-- --------------------------------------------------------

--
-- Table structure for table `kit`
--

CREATE TABLE IF NOT EXISTS `kit` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Image` varchar(255) DEFAULT NULL,
  `Repair` int(11) DEFAULT NULL,
  `Genre` varchar(100) DEFAULT NULL,
  `CheckHours` int(11) DEFAULT NULL,
  `SerialNumber` varchar(100) DEFAULT NULL,
  `ModelNumber` varchar(100) DEFAULT NULL,
  `ImageThumb` varchar(100) DEFAULT NULL,
  `ContractRequired` int(1) DEFAULT '0',
  `Notes` varchar(255) DEFAULT NULL,
  UNIQUE KEY `ID` (`ID`),
  KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=197 ;

--
-- Dumping data for table `kit`
--

INSERT INTO `kit` (`ID`, `Name`, `Image`, `Repair`, `Genre`, `CheckHours`, `SerialNumber`, `ModelNumber`, `ImageThumb`, `ContractRequired`, `Notes`) VALUES
(1, 'Canon ZR850-2', NULL, NULL, 'Video Camera', NULL, '5.82432E+11', NULL, NULL, 0, 'Digital Video Camera / W accessories '),
(2, 'N5000-Negative', NULL, NULL, 'Scanner', NULL, '', NULL, NULL, 0, 'Slide Adapter'),
(3, 'N5000-Slides', NULL, NULL, 'Scanner', NULL, '326885', NULL, NULL, 0, 'Slide Adapter'),
(4, 'Canon GL1 ', NULL, NULL, 'Video Camera', NULL, '2210200331', NULL, NULL, 0, 'Digital Video'),
(5, 'Canon ZR850-1', NULL, NULL, 'Video Camera', NULL, '5.82322E+11', NULL, NULL, 1, 'Digital Video Camera / W accessories '),
(6, 'Wacom-1', NULL, NULL, 'Graphic Tablet', NULL, '0CU006729', NULL, NULL, 0, 'Wacom Tablets w/o Accessories'),
(7, 'Wacom Bamboo 01', NULL, NULL, 'Graphic Tablet', NULL, '8AP003435', NULL, NULL, 0, 'Graphic Tablet/ Bamboo Fun with accessories. 8.5x5.3'),
(8, 'Samson C01U 1', 'samson.jpg', NULL, 'Equipment', NULL, 'COUW7I1038', NULL, 'samson-thumb.jpg', 0, 'USB Studio Condenser Microphone C01U'),
(9, 'Nikon Coolpix1', NULL, NULL, 'Still Camera', NULL, '30158468', NULL, NULL, 0, 'www.bhphotovideo.com	B&H# NICPP1KA	Nikon Coolpix P1 B&H Kit   '),
(10, 'Canon GL2', NULL, NULL, 'Video Camera', NULL, '1.32223E+11', NULL, NULL, 0, 'PRICE IS GUESSED AS ON TECH BUDGET.05-06_EDM_BudgetBut camera is not listed as being ordered.B&H.com'),
(11, 'Nikon D80', NULL, NULL, 'Still Camera', NULL, '3219975', NULL, NULL, 0, 'camera sn# 3219975lens sn#us36185108'),
(12, 'Nikon-D70-1', 'nikond70.jpg', NULL, 'Still Camera', NULL, '3109236', NULL, 'nikond70-thumb.jpg', 0, 'Serial # camera: 3109236serial # Lens: 3238542 WHICH BUDGETreceived 04/06,not yet loggedwww.cdwg.com		Mfr# 25226'),
(13, 'Mamiya 645E-1', 'mamiya.jpg', NULL, 'Still Camera', NULL, 'TC1208', NULL, 'mamiya-thumb.jpg', 0, 'Mamiya 645E Camera with accesories'),
(14, 'CanonHD 1', 'canonhd.jpg', NULL, 'Video Camera', NULL, '7.72723E+11', NULL, 'canonhd-thumb.jpg', 0, 'Canon HD CMOS Camera with optical Image Stabilizer. '),
(15, 'Pears-Tripod-1', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Pearstone Video Tripod'),
(16, 'Aiptek DigHD 1', 'aiptek.jpg', NULL, 'Video Camera', NULL, 'BRU80007638', NULL, 'aiptek-thumb.jpg', 0, 'Aiptek Digital HD Video Camera with 2GB Internal Memory'),
(17, 'Audio-Tech Mic 1', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, 'Audio Tech Stereo Microphone with Hot Shoe mount.'),
(18, 'Stabilizer-1', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Glidecam HD-1000 with central support'),
(19, 'Sony Cybershot 1', NULL, NULL, 'Still Camera', NULL, '392956', NULL, NULL, 0, ''),
(20, 'Nikon D90', NULL, NULL, 'Still Camera', NULL, '3219975', NULL, NULL, 0, 'camera sn# 3219975lens sn#us36185108'),
(21, 'Light Meter 1', 'lightmeter.jpg', NULL, 'Equipment', NULL, 'jh12-114252', NULL, 'lightmeter-thumb.jpg', 0, ''),
(22, 'Light Meter 2', 'lightmeter.jpg', NULL, 'Equipment', NULL, 'jh12-113281', NULL, 'lightmeter-thumb.jpg', 0, ''),
(23, 'View Camera 1', 'toyo.gif', NULL, 'Still Camera', NULL, '126-0002450', NULL, 'toyo.gif', 0, ''),
(24, 'View Camera 2', 'toyo.gif', NULL, 'Still Camera', NULL, '', NULL, 'toyo.gif', 0, ''),
(25, 'Travel Lights', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, ''),
(26, 'Bogen Tripod 1', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, ''),
(27, 'Calumet Tripod', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, ''),
(28, 'Vado HD 1', 'Vado.jpg', NULL, 'Video Camera', NULL, '', NULL, 'Vado-thumb.jpg', 0, ''),

-- --------------------------------------------------------

--
-- Table structure for table `kit_accessorytype`
--

CREATE TABLE IF NOT EXISTS `kit_accessorytype` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `KitID` int(16) NOT NULL DEFAULT '0',
  `AccessorytypeID` int(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=860 ;

--
-- Dumping data for table `kit_accessorytype`
--

INSERT INTO `kit_accessorytype` (`ID`, `KitID`, `AccessorytypeID`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),

-- --------------------------------------------------------

--
-- Table structure for table `kit_class`
--

CREATE TABLE IF NOT EXISTS `kit_class` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `KitID` int(16) NOT NULL DEFAULT '0',
  `ClassID` int(16) NOT NULL DEFAULT '0',
  `CheckHours` int(16) NOT NULL DEFAULT '0',
  `OverNightAllowed` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=607 ;

--
-- Dumping data for table `kit_class`
--

INSERT INTO `kit_class` (`ID`, `KitID`, `ClassID`, `CheckHours`, `OverNightAllowed`) VALUES
(1, 1, 1, 24, 1),

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `StudentID` varchar(255) NOT NULL DEFAULT '',
  `FirstName` varchar(255) NOT NULL DEFAULT '',
  `LastName` varchar(255) NOT NULL DEFAULT '',
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `ContractSigned` int(1) DEFAULT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ID`, `StudentID`, `FirstName`, `LastName`, `Email`, `Phone`, `ContractSigned`) VALUES
(1, '0000000000000', 'FirstName', 'LastName', 'email@email.com', '5551236789', 1),

-- --------------------------------------------------------

--
-- Table structure for table `student_class`
--

CREATE TABLE IF NOT EXISTS `student_class` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `StudentID` varchar(18) NOT NULL DEFAULT '0',
  `ClassID` int(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `student_class`
--

INSERT INTO `student_class` (`ID`, `StudentID`, `ClassID`) VALUES
(1, '0000000000000', 1),

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL DEFAULT '',
  `Password` varchar(255) NOT NULL DEFAULT '',
  `Type` varchar(8) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Username`, `Password`, `Type`) VALUES
(1, 'admin', 'administrator', 'Admin'),
(2, 'labtech', 'technician', 'LabMon');
