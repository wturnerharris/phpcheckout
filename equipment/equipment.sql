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
(60, 'Battery'),
(61, 'Charger'),
(62, 'Lav Mic'),
(63, 'DV Cable'),
(64, 'AV Cable'),
(65, 'Headphones'),
(66, '.5x Wide-Angle adapter'),
(67, '2x Telephoto adaper'),
(68, 'Neutral Density Filter'),
(69, 'Charger AC cord'),
(70, 'AC Battery insert'),
(71, 'Docking Station'),
(72, 'Bubble level'),
(74, 'Camera light'),
(75, 'Charger DC cord'),
(76, 'USB Cable'),
(77, '4 AA Rechargeable Batteries'),
(78, 'AA Battery Charger'),
(119, '2gb Compact Flash Card'),
(118, 'Film Back'),
(117, '80mm Lens'),
(82, '18-55mm stock lens'),
(87, 'Lens Cap'),
(86, 'Tripod'),
(85, '8gb SD card'),
(88, 'Light Stand'),
(89, 'Omni Light'),
(115, 'Rubber case'),
(91, 'AC Cord'),
(92, 'Umbrella reflector'),
(93, 'Gel Frame'),
(94, 'Mounting Plate'),
(95, 'Extension Cord'),
(114, 'USB Extension'),
(98, 'AC Adapter'),
(99, 'XLR Cord'),
(100, 'Power/PC Sync Cord'),
(101, 'Bag of washers'),
(102, 'Box of screws'),
(103, 'Mounting Plate'),
(104, 'Wiring Harness'),
(105, 'Battery Pack'),
(116, 'manual winder'),
(113, 'Bag'),
(108, 'Component Video Cable'),
(109, 'Rain Cover'),
(110, 'Dark Cloth'),
(111, 'remote cord'),
(112, '4x5 Film Holder'),
(120, '18-70mm lens');

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

--
-- Dumping data for table `checkedout`
--

INSERT INTO `checkedout` (`ID`, `KitID`, `StudentID`, `DateOut`, `ExpectedDateIn`, `DateIn`, `FinePaid`, `Reserved`, `Accessories`, `Notes`, `Problem`, `CheckoutUser`, `CheckinUser`) VALUES
(1, 141, '29016001661241', '2010-02-15 21:34:07', '2010-02-17 17:00:00', '2010-02-15 21:37:25', NULL, NULL, '', '', 0, 'labtech', 'labtech'),
(2, 141, '2901600121212', '2010-02-16 09:24:46', '2010-02-18 17:00:00', '2010-02-16 16:53:01', NULL, NULL, 'USB Cable, Charger', '', 0, 'labtech', 'labtech');

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
(1, 'Test Class'),
(16, 'EDM Class'),
(17, 'Photo Class');

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
(132, 'Nikon D40', NULL, NULL, 'Still Camera', NULL, '3057513', NULL, NULL, 0, 'Nikon D40 with 18-55MM lens'),
(131, 'Samson C01U 2', 'samson.jpg', NULL, 'Equipment', NULL, 'COUW7I1039', NULL, 'samson-thumb.jpg', 0, 'USB Studio Condenser Microphone C01U'),
(130, 'Music Star Keyboard', NULL, NULL, 'Equipment', NULL, '4B05655', NULL, NULL, 0, 'keyboard'),
(129, 'Wacom 4x5-2', NULL, NULL, 'Graphic Tablet', NULL, '5jz036617', NULL, NULL, 0, 'Graphic Tablet'),
(128, 'Canon ZR850-3', NULL, NULL, 'Video Camera', NULL, '5.82432E+11', NULL, NULL, 0, 'Digital Video Camera / W accessories '),
(127, 'Sony-Tripod', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Sony Tripod VCT-D680Rm'),
(126, 'Canon ZR850-2', NULL, NULL, 'Video Camera', NULL, '5.82432E+11', NULL, NULL, 0, 'Digital Video Camera / W accessories '),
(124, 'Frotto-Tripod', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Video Tripod'),
(125, 'Sony-Handycam', NULL, NULL, 'Video Camera', NULL, 'SO10202142', NULL, NULL, 0, 'Sony Digital Handycam, 120 Digital zoom'),
(122, 'Cull Tripod 2', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Photography/Video Tripod'),
(123, 'Velbon-Tripod', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Video Tripod'),
(121, 'Cull Tripod 1', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Photography/Video Tripod'),
(120, 'N5000-Negative', NULL, NULL, 'Scanner', NULL, '', NULL, NULL, 0, 'Slide Adapter'),
(119, 'N5000-Slides', NULL, NULL, 'Scanner', NULL, '326885', NULL, NULL, 0, 'Slide Adapter'),
(118, 'Canon GL1 ', NULL, NULL, 'Video Camera', NULL, '2210200331', NULL, NULL, 0, 'Digital Video'),
(117, 'Canon ZR850-1', NULL, NULL, 'Video Camera', NULL, '5.82322E+11', NULL, NULL, 1, 'Digital Video Camera / W accessories '),
(116, 'Wacom-3', NULL, NULL, 'Graphic Tablet', NULL, '0CU006728', NULL, NULL, 0, 'Wacom Tablet w/o Accessories'),
(115, 'Wacom-2', NULL, NULL, 'Graphic Tablet', NULL, '0CU006727', NULL, NULL, 0, 'Wacom Tablet w/o Accessories'),
(114, 'Wacom-1', NULL, NULL, 'Graphic Tablet', NULL, '0CU006729', NULL, NULL, 0, 'Wacom Tablets w/o Accessories'),
(113, 'Tascam Studio ', NULL, NULL, 'Equipment', NULL, '110519', NULL, NULL, 0, 'Tascam Audio setupUS-122L interface/ LD-74 condenser microphone.'),
(112, 'Wacom Tablet', NULL, NULL, 'Graphic Tablet', NULL, '5IZ002606', NULL, NULL, 0, 'Graphic tablet for Adobe with Accessoriesmodel CTE-440'),
(111, 'Wacom Bamboo 01', NULL, NULL, 'Graphic Tablet', NULL, '8AP003435', NULL, NULL, 0, 'Graphic Tablet/ Bamboo Fun with accessories. 8.5x5.3'),
(110, 'Samson C01U 1', 'samson.jpg', NULL, 'Equipment', NULL, 'COUW7I1038', NULL, 'samson-thumb.jpg', 0, 'USB Studio Condenser Microphone C01U'),
(109, 'Nikon Coolpix2', NULL, NULL, 'Still Camera', NULL, '30158470', NULL, NULL, 0, 'www.bhphotovideo.com	B&H# NICPP1KA	Nikon Coolpix P1 B&H Kit   '),
(108, 'Nikon Coolpix1', NULL, NULL, 'Still Camera', NULL, '30158468', NULL, NULL, 0, 'www.bhphotovideo.com	B&H# NICPP1KA	Nikon Coolpix P1 B&H Kit   '),
(104, 'Canon GL2', NULL, NULL, 'Video Camera', NULL, '1.32223E+11', NULL, NULL, 0, 'PRICE IS GUESSED AS ON TECH BUDGET.05-06_EDM_BudgetBut camera is not listed as being ordered.B&H.com'),
(196, 'Nikon D80', NULL, NULL, 'Still Camera', NULL, '3219975', NULL, NULL, 0, 'camera sn# 3219975lens sn#us36185108'),
(103, 'Nikon-D70-2', 'nikond70.jpg', NULL, 'Still Camera', NULL, '3117224', NULL, 'nikond70-thumb.jpg', 0, 'serial  camera: 3109236serial lens: 3238542received 04/06, EDMorder40706www.cdwg.com		Mfr# 25226'),
(102, 'Nikon-D70-1', 'nikond70.jpg', NULL, 'Still Camera', NULL, '3109236', NULL, 'nikond70-thumb.jpg', 0, 'Serial # camera: 3109236serial # Lens: 3238542 WHICH BUDGETreceived 04/06,not yet loggedwww.cdwg.com		Mfr# 25226'),
(135, 'Mamiya 645E-1', 'mamiya.jpg', NULL, 'Still Camera', NULL, 'TC1208', NULL, 'mamiya-thumb.jpg', 0, 'Mamiya 645E Camera with accesories'),
(136, 'Mamiya 645E-2', 'mamiya.jpg', NULL, 'Still Camera', NULL, 'AA1122', NULL, 'mamiya-thumb.jpg', 0, 'Mamiya 645E Camera with accesories'),
(137, 'CanonHD 1', 'canonhd.jpg', NULL, 'Video Camera', NULL, '7.72723E+11', NULL, 'canonhd-thumb.jpg', 0, 'Canon HD CMOS Camera with optical Image Stabilizer. '),
(138, 'CanonHD 2', 'canonhd.jpg', NULL, 'Video Camera', NULL, '7.72723E+11', NULL, 'canonhd-thumb.jpg', 0, 'Canon HD CMOS Camera with optical Image Stabilizer. '),
(139, 'Pears-Tripod-1', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Pearstone Video Tripod'),
(140, 'Pears-Tripod-2', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Pearstone Video Tripod'),
(141, 'Aiptek DigHD 1', 'aiptek.jpg', NULL, 'Video Camera', NULL, 'BRU80007638', NULL, 'aiptek-thumb.jpg', 0, 'Aiptek Digital HD Video Camera with 2GB Internal Memory'),
(142, 'Audio-Tech Mic 1', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, 'Audio Tech Stereo Microphone with Hot Shoe mount.'),
(143, 'Stabilizer-1', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Glidecam HD-1000 with central support'),
(144, 'Stabilizer-2', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Glidecam HD-1000 with central support'),
(146, 'Aiptek DigHD 2', 'aiptek.jpg', NULL, 'Video Camera', NULL, 'BRU80007354', NULL, 'aiptek-thumb.jpg', 0, 'Aiptek Digital HD Video Camera with 2GB Internal Memory'),
(147, 'Audio-Tech Mic 2', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, 'Audio Tech Stereo Microphone with Hot Shoe mount.'),
(148, 'Audio-Tech Mic 3', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, 'Audio Tech Stereo Microphone with Hot Shoe mount.'),
(149, 'Aiptek DigHD 3', 'aiptek.jpg', NULL, 'Video Camera', NULL, 'BRU80007406', NULL, 'aiptek-thumb.jpg', 0, 'Aiptek Digital HD Video Camera with 2GB Internal Memory'),
(150, 'Aiptek DigHD 4', 'aiptek.jpg', NULL, 'Video Camera', NULL, 'BRU80007539', NULL, 'aiptek-thumb.jpg', 0, 'Aiptek Digital HD Video Camera with 2GB Internal Memory'),
(151, 'Aiptek DigHD 5', 'aiptek.jpg', NULL, 'Video Camera', NULL, 'BRU80007750', NULL, 'aiptek-thumb.jpg', 0, 'Aiptek Digital HD Video Camera with 2GB Internal Memory'),
(152, 'Pears-Tripod-3', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Pearstone Video Tripod'),
(153, 'Pears-Tripod-4', NULL, NULL, 'Tripod', NULL, '', NULL, NULL, 0, 'Pearstone Video Tripod'),
(154, 'Nikon-D70-3', 'nikond70.jpg', NULL, 'Still Camera', NULL, '3062523', NULL, 'nikond70-thumb.jpg', 0, 'serial  camera: 3062523serial lens: 3238542received 04/06, EDMorder40706www.cdwg.com		Mfr# 25226'),
(155, 'Sony Cybershot 1', NULL, NULL, 'Still Camera', NULL, '392956', NULL, NULL, 0, ''),
(156, 'Sony Cybershot 2', NULL, NULL, 'Still Camera', NULL, '415847', NULL, NULL, 0, ''),
(169, 'Nikon D90', NULL, NULL, 'Still Camera', NULL, '3219975', NULL, NULL, 0, 'camera sn# 3219975lens sn#us36185108'),
(170, 'Nikon SB-900', 'nikonflash.jpg', NULL, 'Equipment', NULL, '2239987', NULL, 'nikonflash.jpg', 0, ''),
(171, 'Light Meter 1', 'lightmeter.jpg', NULL, 'Equipment', NULL, 'jh12-114252', NULL, 'lightmeter-thumb.jpg', 0, ''),
(172, 'Light Meter 2', 'lightmeter.jpg', NULL, 'Equipment', NULL, 'jh12-113281', NULL, 'lightmeter-thumb.jpg', 0, ''),
(173, 'Light Meter 3', 'lightmeter.jpg', NULL, 'Equipment', NULL, 'jh12-113607', NULL, 'lightmeter-thumb.jpg', 0, ''),
(174, 'View Camera 1', 'toyo.gif', NULL, 'Still Camera', NULL, '126-0002450', NULL, 'toyo.gif', 0, ''),
(175, 'View Camera 2', 'toyo.gif', NULL, 'Still Camera', NULL, '', NULL, 'toyo.gif', 0, ''),
(176, 'View Camera 3', 'toyo.gif', NULL, 'Still Camera', NULL, '', NULL, 'toyo.gif', 0, ''),
(177, 'View Camera 4', 'toyo.gif', NULL, 'Still Camera', NULL, '', NULL, 'toyo.gif', 0, 'Speed Graphic Camera - owned by Patterson Beckwithschool''s lens'),
(178, 'Travel Lights', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, ''),
(179, 'Bogen Tripod 3', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, ''),
(180, 'Bogen Tripod 2', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, ''),
(181, 'Bogen Tripod 4', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, ''),
(182, 'Bogen Tripod 1', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, ''),
(183, 'Bogen Tripod 5', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, ''),
(184, 'Calumet Tripod', NULL, NULL, 'Equipment', NULL, '', NULL, NULL, 0, ''),
(185, 'CanonHD 3', 'canonhd.jpg', NULL, 'Video Camera', NULL, '', NULL, 'canonhd-thumb.jpg', 0, 'Canon HD CMOS Camera with optical image stabilization'),
(186, 'CanonHD 4', 'canonhd.jpg', NULL, 'Video Camera', NULL, '', NULL, 'canonhd-thumb.jpg', 0, 'Canon HD CMOS Camera with optical Image Stabilization'),
(187, 'CanonHD 5', 'canonhd.jpg', NULL, 'Video Camera', NULL, '', NULL, 'canonhd-thumb.jpg', 0, 'Canon HD CMOS Camera with optical image stabalizer '),
(188, 'Vado HD 1', 'Vado.jpg', NULL, 'Video Camera', NULL, '', NULL, 'Vado-thumb.jpg', 0, ''),
(189, 'CanonHD 6', 'canonhd.jpg', NULL, 'Video Camera', NULL, '42890565589', NULL, 'canonhd-thumb.jpg', 0, 'Canon Hd CMOS Camera with optical image stablizer'),
(190, 'CanonHD 7', 'canonhd.jpg', NULL, 'Video Camera', NULL, '42890565517', NULL, 'canonhd-thumb.jpg', 0, 'Canon HD CMOS Camera with optical image stabalizer '),
(191, 'Vado HD 2', 'Vado.jpg', NULL, 'Video Camera', NULL, '', NULL, 'Vado-thumb.jpg', 0, ''),
(192, 'Vado HD 3', 'Vado.jpg', NULL, 'Video Camera', NULL, '', NULL, 'Vado-thumb.jpg', 0, ''),
(193, 'Vado HD 4', 'Vado.jpg', NULL, 'Video Camera', NULL, '', NULL, 'Vado-thumb.jpg', 0, ''),
(194, 'Vado HD 5', 'Vado.jpg', NULL, 'Video Camera', NULL, '', NULL, 'Vado-thumb.jpg', 0, ''),
(195, 'Vado HD 6', 'Vado.jpg', NULL, 'Video Camera', NULL, '', NULL, 'Vado-thumb.jpg', 0, ''),
(1, 'Test Kit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL);

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
(593, 76, 90),
(592, 76, 89),
(591, 76, 88),
(590, 76, 88),
(589, 76, 88),
(588, 76, 88),
(587, 75, 87),
(586, 74, 86),
(585, 74, 85),
(352, 2, 60),
(353, 2, 60),
(354, 2, 61),
(355, 2, 62),
(356, 2, 63),
(360, 2, 70),
(358, 2, 65),
(359, 2, 66),
(357, 2, 68),
(584, 74, 82),
(571, 72, 69),
(572, 72, 82),
(579, 73, 85),
(573, 72, 85),
(574, 72, 86),
(575, 73, 60),
(576, 73, 61),
(577, 73, 69),
(578, 73, 82),
(371, 2, 72),
(372, 2, 71),
(373, 8, 60),
(374, 8, 61),
(375, 8, 74),
(376, 8, 63),
(377, 8, 65),
(378, 8, 62),
(379, 8, 75),
(380, 8, 69),
(381, 7, 60),
(382, 7, 60),
(383, 7, 61),
(384, 7, 69),
(385, 7, 63),
(386, 7, 64),
(387, 7, 65),
(388, 7, 62),
(389, 4, 60),
(390, 4, 60),
(391, 4, 61),
(392, 4, 69),
(393, 4, 63),
(394, 4, 64),
(395, 4, 65),
(396, 4, 62),
(397, 5, 60),
(398, 5, 60),
(399, 5, 61),
(400, 5, 69),
(401, 5, 63),
(402, 5, 64),
(403, 5, 65),
(404, 5, 62),
(582, 74, 61),
(583, 74, 69),
(409, 2, 86),
(581, 74, 60),
(411, 4, 86),
(412, 5, 86),
(413, 7, 86),
(414, 8, 86),
(566, 71, 82),
(565, 71, 69),
(554, 69, 86),
(548, 69, 60),
(547, 68, 86),
(541, 67, 86),
(534, 66, 85),
(532, 66, 69),
(570, 72, 61),
(568, 71, 86),
(567, 71, 85),
(569, 72, 60),
(560, 70, 85),
(561, 70, 86),
(559, 70, 82),
(564, 71, 61),
(557, 70, 60),
(556, 70, 61),
(563, 71, 60),
(562, 70, 69),
(550, 69, 61),
(551, 69, 69),
(553, 69, 85),
(552, 69, 82),
(545, 68, 82),
(544, 68, 69),
(543, 68, 61),
(546, 68, 85),
(538, 67, 69),
(540, 67, 85),
(542, 68, 60),
(539, 67, 82),
(535, 66, 86),
(533, 66, 82),
(536, 67, 60),
(537, 67, 61),
(530, 66, 60),
(531, 66, 61),
(453, 9, 79),
(454, 9, 80),
(455, 9, 81),
(456, 9, 62),
(457, 21, 82),
(458, 21, 85),
(459, 21, 86),
(460, 21, 61),
(461, 21, 60),
(462, 21, 69),
(463, 22, 82),
(464, 22, 85),
(465, 22, 86),
(466, 22, 61),
(467, 22, 60),
(468, 22, 69),
(469, 23, 82),
(470, 23, 85),
(471, 23, 86),
(472, 23, 61),
(473, 23, 60),
(474, 23, 69),
(475, 24, 82),
(476, 24, 85),
(477, 24, 86),
(478, 24, 61),
(479, 24, 60),
(480, 24, 69),
(481, 25, 82),
(482, 25, 85),
(483, 25, 86),
(484, 25, 61),
(485, 25, 60),
(486, 25, 69),
(487, 31, 87),
(488, 32, 87),
(489, 33, 87),
(490, 34, 87),
(491, 41, 89),
(492, 41, 89),
(493, 41, 90),
(494, 41, 88),
(495, 41, 88),
(496, 41, 88),
(497, 41, 91),
(498, 41, 91),
(499, 41, 91),
(500, 41, 92),
(501, 41, 93),
(502, 10, 61),
(503, 10, 69),
(504, 10, 64),
(505, 10, 63),
(506, 35, 94),
(507, 36, 94),
(508, 37, 94),
(580, 73, 86),
(510, 41, 95),
(511, 41, 95),
(512, 61, 96),
(513, 61, 65),
(514, 61, 97),
(515, 61, 98),
(516, 61, 99),
(517, 61, 81),
(518, 61, 76),
(519, 61, 85),
(520, 62, 100),
(521, 63, 101),
(522, 63, 102),
(523, 63, 103),
(524, 38, 104),
(525, 38, 105),
(526, 64, 106),
(527, 64, 106),
(594, 76, 91),
(595, 76, 91),
(596, 76, 91),
(597, 76, 91),
(598, 76, 92),
(599, 76, 93),
(600, 73, 93),
(601, 76, 107),
(602, 76, 93),
(603, 77, 88),
(604, 77, 88),
(605, 77, 88),
(606, 77, 88),
(607, 77, 89),
(608, 77, 90),
(609, 77, 91),
(610, 77, 91),
(611, 77, 91),
(612, 77, 91),
(613, 77, 92),
(614, 77, 93),
(615, 77, 93),
(616, 77, 107),
(617, 78, 88),
(619, 78, 88),
(620, 78, 88),
(621, 78, 88),
(622, 78, 89),
(623, 78, 90),
(624, 78, 91),
(625, 78, 91),
(626, 78, 91),
(627, 78, 91),
(628, 78, 92),
(629, 78, 93),
(630, 78, 93),
(631, 78, 107),
(632, 76, 95),
(641, 79, 87),
(634, 76, 95),
(642, 79, 60),
(636, 77, 95),
(637, 77, 95),
(643, 79, 60),
(639, 78, 95),
(640, 78, 95),
(644, 79, 61),
(645, 79, 69),
(646, 79, 70),
(647, 80, 87),
(648, 80, 60),
(649, 80, 60),
(650, 80, 61),
(651, 80, 69),
(652, 80, 70),
(653, 81, 87),
(654, 81, 60),
(655, 81, 60),
(656, 81, 61),
(657, 81, 69),
(658, 81, 70),
(659, 82, 87),
(660, 82, 60),
(661, 82, 60),
(662, 82, 61),
(663, 82, 69),
(664, 82, 70),
(665, 82, 66),
(666, 82, 64),
(667, 82, 108),
(668, 82, 109),
(669, 83, 87),
(670, 84, 87),
(671, 85, 87),
(672, 86, 87),
(673, 87, 61),
(674, 87, 91),
(675, 88, 61),
(705, 97, 61),
(678, 88, 91),
(679, 89, 61),
(680, 89, 91),
(681, 90, 61),
(682, 90, 91),
(683, 91, 61),
(684, 91, 91),
(685, 92, 61),
(686, 92, 91),
(687, 93, 61),
(688, 93, 91),
(689, 94, 61),
(690, 94, 91),
(691, 95, 61),
(692, 95, 91),
(693, 96, 61),
(694, 96, 91),
(695, 97, 91),
(696, 98, 61),
(697, 98, 91),
(699, 99, 61),
(700, 99, 91),
(701, 100, 61),
(702, 100, 91),
(703, 101, 61),
(704, 174, 110),
(709, 174, 111),
(710, 174, 112),
(750, 177, 112),
(749, 177, 112),
(748, 176, 112),
(747, 176, 112),
(746, 176, 112),
(745, 176, 112),
(744, 176, 112),
(743, 176, 111),
(742, 176, 110),
(741, 175, 110),
(740, 175, 111),
(739, 175, 112),
(738, 175, 112),
(737, 175, 112),
(736, 175, 112),
(735, 175, 112),
(734, 174, 112),
(733, 174, 112),
(732, 174, 112),
(731, 174, 112),
(751, 177, 112),
(752, 177, 112),
(753, 177, 112),
(754, 177, 111),
(755, 177, 110),
(756, 177, 113),
(757, 176, 113),
(758, 175, 113),
(759, 174, 113),
(760, 141, 113),
(761, 141, 76),
(762, 141, 61),
(763, 146, 61),
(764, 146, 76),
(765, 146, 113),
(766, 149, 113),
(767, 149, 76),
(768, 149, 61),
(769, 150, 61),
(770, 150, 76),
(771, 150, 113),
(772, 151, 113),
(773, 151, 76),
(774, 151, 61),
(775, 137, 60),
(776, 137, 60),
(777, 138, 60),
(778, 138, 60),
(779, 185, 60),
(780, 185, 60),
(781, 186, 60),
(782, 186, 60),
(783, 187, 60),
(784, 187, 60),
(785, 189, 60),
(786, 189, 60),
(787, 190, 60),
(788, 190, 60),
(789, 190, 61),
(790, 189, 61),
(791, 187, 61),
(792, 186, 61),
(793, 185, 61),
(794, 138, 61),
(795, 137, 61),
(796, 137, 76),
(797, 138, 76),
(798, 185, 76),
(799, 186, 76),
(800, 187, 76),
(801, 189, 76),
(802, 190, 76),
(803, 190, 85),
(804, 189, 85),
(818, 188, 113),
(806, 187, 85),
(807, 186, 85),
(808, 185, 85),
(809, 138, 85),
(810, 137, 85),
(811, 137, 113),
(812, 138, 113),
(813, 185, 113),
(814, 186, 113),
(815, 187, 113),
(816, 189, 113),
(817, 190, 113),
(819, 188, 114),
(820, 188, 115),
(821, 191, 115),
(822, 191, 114),
(823, 191, 113),
(824, 192, 113),
(825, 192, 114),
(826, 192, 115),
(827, 193, 115),
(828, 193, 114),
(829, 193, 113),
(830, 194, 113),
(831, 194, 114),
(832, 194, 115),
(833, 195, 115),
(834, 195, 114),
(835, 195, 113),
(836, 171, 113),
(837, 172, 113),
(838, 173, 113),
(839, 135, 116),
(840, 135, 117),
(841, 135, 118),
(842, 136, 118),
(843, 136, 117),
(844, 136, 116),
(845, 102, 60),
(846, 102, 61),
(847, 102, 76),
(848, 102, 119),
(849, 102, 120),
(850, 103, 60),
(851, 103, 61),
(852, 103, 76),
(853, 103, 119),
(854, 103, 120),
(855, 154, 60),
(856, 154, 61),
(857, 154, 76),
(858, 154, 119),
(859, 154, 120);

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
(384, 71, 7, 24, 1),
(1, 2, 16, 24, 1),
(2, 4, 1, 24, 1),
(3, 5, 1, 24, 1),
(4, 7, 1, 24, 1),
(5, 8, 1, 24, 1),
(6, 9, 1, 24, 1),
(518, 141, 16, 48, 2),
(519, 146, 16, 48, 2),
(520, 149, 16, 48, 2),
(521, 150, 16, 48, 2),
(522, 151, 16, 48, 2),
(523, 142, 16, 48, 2),
(524, 147, 16, 48, 2),
(525, 148, 16, 48, 2),
(526, 182, 17, 48, 2),
(527, 180, 17, 48, 2),
(528, 179, 17, 48, 2),
(529, 181, 17, 48, 2),
(530, 183, 17, 48, 2),
(531, 184, 17, 48, 2),
(532, 118, 16, 48, 2),
(533, 104, 16, 48, 2),
(534, 117, 16, 48, 2),
(535, 126, 16, 48, 2),
(536, 128, 16, 48, 2),
(537, 137, 16, 48, 2),
(538, 138, 16, 48, 2),
(539, 185, 16, 48, 2),
(540, 186, 16, 48, 2),
(541, 187, 16, 48, 2),
(542, 189, 16, 48, 2),
(543, 190, 16, 48, 2),
(544, 121, 16, 48, 2),
(545, 122, 16, 48, 2),
(546, 124, 16, 48, 2),
(547, 171, 17, 48, 2),
(548, 172, 17, 48, 2),
(549, 173, 17, 48, 2),
(550, 135, 17, 48, 2),
(551, 136, 17, 48, 2),
(552, 108, 16, 48, 2),
(553, 109, 16, 48, 2),
(554, 132, 16, 48, 2),
(555, 169, 17, 48, 2),
(556, 170, 17, 48, 2),
(557, 102, 16, 48, 2),
(558, 103, 16, 48, 2),
(559, 154, 16, 48, 2),
(560, 140, 16, 48, 2),
(561, 139, 16, 48, 2),
(562, 152, 16, 48, 2),
(563, 153, 16, 48, 2),
(564, 110, 16, 48, 2),
(565, 131, 16, 48, 2),
(566, 155, 16, 48, 2),
(567, 156, 16, 48, 2),
(568, 125, 16, 48, 2),
(569, 127, 16, 48, 2),
(570, 143, 16, 48, 2),
(571, 144, 16, 48, 2),
(572, 113, 16, 48, 2),
(573, 178, 17, 48, 2),
(574, 188, 16, 48, 2),
(575, 191, 16, 48, 2),
(576, 192, 16, 48, 2),
(577, 193, 16, 48, 2),
(578, 193, 16, 48, 2),
(579, 194, 16, 48, 2),
(580, 195, 16, 48, 2),
(581, 123, 16, 48, 2),
(582, 174, 17, 48, 2),
(583, 175, 17, 48, 2),
(584, 176, 17, 48, 2),
(585, 177, 17, 48, 2),
(586, 129, 16, 48, 2),
(587, 111, 16, 48, 2),
(588, 162, 16, 48, 2),
(589, 163, 16, 48, 2),
(590, 164, 16, 48, 2),
(591, 165, 16, 48, 2),
(592, 166, 16, 48, 2),
(593, 167, 16, 48, 2),
(594, 133, 16, 48, 2),
(595, 134, 16, 48, 2),
(596, 157, 16, 48, 2),
(597, 158, 16, 48, 2),
(598, 168, 16, 48, 2),
(599, 159, 16, 48, 2),
(600, 160, 16, 48, 2),
(601, 161, 16, 48, 2),
(602, 112, 16, 48, 2),
(603, 114, 16, 48, 2),
(604, 115, 16, 48, 2),
(605, 116, 16, 48, 2),
(606, 1, 1, 0, 0);

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
(1, '29016001661241', 'Wesley', 'Turner', 'wesswei@hotmail.com', '3472846408', 1),
(2, '2901600121212', 'Bob', 'Dole', 'meyer@bob.com', '1234567890', 1),
(7, '29016001346792', 'Wendell', 'Freeman', 'skiter@gmail.com', '2126502134', 1),
(10, '29016001234567', 'Yelsew', 'Renrut', 'yrenrut@gmail.com', '1234567890', 1),
(11, '29016001234567', 'Robert', 'Seagram', 'rseagram@gmail.com', '5551234657', 1),
(12, '29016001346798', 'Yvegev', 'Horace', 'horat@amail.com', '5552127576', 1),
(15, '29016001234567', 'Wes', 'Lee', 'leewes@hotmail.com', '9876543210', NULL);

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
(2, '2901600121212', 16),
(22, '2901600313259', 16),
(29, '29016001346798', 1),
(8, '2901600313257', 1),
(9, '2901600313257', 16),
(31, '29016001234567', 16),
(30, '29016002123634', 1),
(26, '290160013456789', 16),
(28, '29016001346792', 1);

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
(1, 'labtech', 'challengerdeep', 'LabMon'),
(5, 'admin', 'u81i812', 'Admin');
