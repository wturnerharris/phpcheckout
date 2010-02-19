-- phpMyAdmin SQL Dump
-- version 2.8.0.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Mar 22, 2006 at 02:57 PM
-- Server version: 5.0.18
-- PHP Version: 5.1.2
-- 
-- Database: `equipment`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `accessorytype`
-- 

CREATE TABLE `accessorytype` (
  `ID` int(11) NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

-- 
-- Dumping data for table `accessorytype`
-- 

INSERT INTO `accessorytype` (`ID`, `Name`) VALUES (60, 'Battery'),
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
(79, 'Wireless transmitter'),
(80, 'Wireless Receiver'),
(81, 'Stick mic'),
(82, '18-55mm stock lens'),
(87, 'Lens Cap'),
(86, 'Tripod'),
(85, 'Flash memory card'),
(88, 'Light Stand'),
(89, 'Omni Light'),
(90, 'Tota Light'),
(91, 'AC Cord'),
(92, 'Umbrella reflector'),
(93, 'Gel Frame'),
(94, 'Mounting Plate'),
(95, 'Extension Cord'),
(96, '8 AA Rechargeable Batteries'),
(97, 'Mic Stand'),
(98, 'AC Adapter'),
(99, 'XLR Cord'),
(100, 'Power/PC Sync Cord'),
(101, 'Bag of washers'),
(102, 'Box of screws'),
(103, 'Mounting Plate'),
(104, 'Wiring Harness'),
(105, 'Battery Pack'),
(106, '(3) AA Batteries'),
(107, 'Pro Light'),
(108, 'Component Video Cable'),
(109, 'Rain Cover');

-- --------------------------------------------------------

-- 
-- Table structure for table `checkedout`
-- 

CREATE TABLE `checkedout` (
  `ID` int(11) NOT NULL auto_increment,
  `KitID` int(11) NOT NULL default '0',
  `StudentID` int(11) NOT NULL default '0',
  `DateOut` datetime NOT NULL default '0000-00-00 00:00:00',
  `ExpectedDateIn` datetime NOT NULL default '0000-00-00 00:00:00',
  `DateIn` varchar(255) NOT NULL default '',
  `FinePaid` varchar(255) default NULL,
  `Reserved` int(11) default NULL,
  `Accessories` varchar(255) NOT NULL default '',
  `Notes` varchar(255) default NULL,
  `Problem` int(1) NOT NULL default '0',
  `CheckoutUser` varchar(255) NOT NULL default '0',
  `CheckinUser` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=510 ;

-- 
-- Dumping data for table `checkedout`
-- 



-- --------------------------------------------------------

-- 
-- Table structure for table `class`
-- 

CREATE TABLE `class` (
  `ID` int(11) NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL default '',
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- 
-- Dumping data for table `class`
-- 

INSERT INTO `class` (`ID`, `Name`) VALUES (1, 'Test Class');


-- --------------------------------------------------------

-- 
-- Table structure for table `kit`
-- 

CREATE TABLE `kit` (
  `ID` int(16) NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL default '',
  `Image` varchar(255) default NULL,
  `Repair` int(11) default NULL,
  `Genre` varchar(100) default NULL,
  `CheckHours` int(11) default NULL,
  `SerialNumber` varchar(100) default NULL,
  `ModelNumber` varchar(100) default NULL,
  `ImageThumb` varchar(100) default NULL,
  `ContractRequired` int(1) default '0',
  `Notes` varchar(255) default NULL,
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `ID_2` (`ID`),
  KEY `Name` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

-- 
-- Dumping data for table `kit`
-- 

INSERT INTO `kit` (`ID`, `Name`, `Image`, `Repair`, `Genre`, `CheckHours`, `SerialNumber`, `ModelNumber`, `ImageThumb`, `ContractRequired`, `Notes`) VALUES (64, '(2) Motorola Talkabout Radios', 'talkaboutbig.jpg', NULL, NULL, 24, '690WAS2TRP / 690WAS0Q33', 'FR50', 'talkaboutthumb.jpg', 0, NULL),
(65, '(3) Motorola Talkabout Radios', 'talkaboutbig.jpg', NULL, NULL, NULL, NULL, 'FR 50', 'talkaboutthumb.jpg', 0, NULL),
(21, 'Canon Digital Rebel Kit 1', 'rebelbig.jpg', NULL, NULL, 24, '1860515001', 'Canon Digital Rebel DS-6041', 'rebelthumb.jpg', 0, NULL),
(70, 'Canon Digital Rebel Kit 10', 'rebelbig.jpg', NULL, NULL, 24, '1260438417', 'DS-6041', 'rebelthumb.jpg', 0, NULL),
(71, 'Canon Digital Rebel Kit 11', 'rebelbig.jpg', NULL, NULL, 24, '1260440186', 'DS-6041', 'rebelthumb.jpg', 0, NULL),
(72, 'Canon Digital Rebel Kit 12', 'rebelbig.jpg', NULL, NULL, 24, '1660514350', 'DS-6041', 'rebelthumb.jpg', 0, NULL),
(73, 'Canon Digital Rebel Kit 13', 'rebelbig.jpg', NULL, NULL, 24, '1760520351', 'DS-6041', 'rebelthumb.jpg', 0, NULL),
(74, 'Canon Digital Rebel Kit 14', 'rebelbig.jpg', NULL, NULL, 24, '1660516053', 'DS-6041', 'rebelthumb.jpg', 0, NULL),
(22, 'Canon Digital Rebel Kit 2', 'rebelbig.jpg', NULL, NULL, 24, '1560542844', 'Canon Digital Rebel DS-6041', 'rebelthumb.jpg', 0, NULL),
(23, 'Canon Digital Rebel Kit 3', 'rebelbig.jpg', NULL, NULL, 24, '1860515000', 'Canon Digital Rebel DS-6041', 'rebelthumb.jpg', 0, NULL),
(24, 'Canon Digital Rebel Kit 4', 'rebelbig.jpg', NULL, NULL, 24, '1860514935', 'Canon Digital Rebel DS-6041', 'rebelthumb.jpg', 0, NULL),
(25, 'Canon Digital Rebel Kit 5', 'rebelbig.jpg', 1, NULL, 24, '1560542845', 'Canon Digital Rebel DS-6041', 'rebelthumb.jpg', 0, 'Missing FA05'),
(66, 'Canon Digital Rebel Kit 6', 'rebelbig.jpg', NULL, NULL, 24, '460011228', 'DS-6041', 'rebelthumb.jpg', 0, 'No USB cable'),
(67, 'Canon Digital Rebel Kit 7', 'rebelxt.jpg', NULL, NULL, 24, '420229511', 'DS126071', 'rebelxtThumb.jpg', 0, NULL),
(68, 'Canon Digital Rebel Kit 8', 'rebelxt.jpg', NULL, NULL, 24, '420229513', 'DS126071', 'rebelxtThumb.jpg', 0, NULL),
(69, 'Canon Digital Rebel Kit 9', 'rebelxt.jpg', NULL, NULL, 24, '420229515', 'DS126071', 'rebelxtThumb.jpg', 0, NULL),
(79, 'Canon GL kit 1', 'gl1big.jpg', NULL, NULL, 24, '2040100096', 'GL-1', 'Gl1thumb.jpg', 0, NULL),
(80, 'Canon GL kit 2', 'Gl2big.jpg', NULL, NULL, 24, '132072810563', 'GL-2', 'gl2thumb.jpg', 0, NULL),
(81, 'Canon GL kit 3', 'Gl2big.jpg', NULL, NULL, 24, '132072810329', 'GL-2', 'gl2thumb.jpg', 0, NULL),
(83, 'Canon Rebel Lens 55-200 1', '55200big.jpg', NULL, NULL, 24, '1061741', '55-200mm', '55200thumb.jpg', 0, NULL),
(84, 'Canon Rebel Lens 55-200 2', '55200big.jpg', NULL, NULL, 24, '1062128', '55-200mm', '55200thumb.jpg', 0, NULL),
(85, 'Canon Rebel Lens 55-200 3', '55200big.jpg', NULL, NULL, 24, '1061974', '55-200mm', '55200thumb.jpg', 0, NULL),
(86, 'Canon Rebel Lens 55-200 4', '55200big.jpg', NULL, NULL, 24, '1061962', '55-200mm', '55200thumb.jpg', 0, NULL),
(32, 'Digital Rebel Lens 1 70-200mm', '70200big.jpg', NULL, NULL, 24, '4002234', 'Sigma 70-200mm', '70200thumb.jpg', 0, NULL),
(75, 'Digital Rebel Lens 2 70-200', '70200big.jpg', NULL, NULL, 24, '5003473', '70-200mm', '70200thumb.jpg', 0, NULL),
(31, 'Digital Rebel Lens 5 18-50mm', '1850big.jpg', NULL, NULL, 24, '1004805', 'Sigma 18-50mm', '1850thumb.jpg', 0, NULL),
(2, 'DV Kit 2', 'ez30bigg.gif', NULL, NULL, 24, 'L9SA10055', 'Panasonic AG-EZ30', 'ez30thumb.jpg', 0, NULL),
(4, 'DV Kit 4', '38big.jpg', NULL, NULL, 24, '1341133', 'Sony DCR-TRV38', '38thumb.jpg', 0, NULL),
(5, 'DV Kit 5', '11big.jpg', NULL, NULL, 24, '101818', 'Sony DCR-TRV38', '11thumb.jpg', 0, NULL),
(7, 'DV Kit 7', '25big.jpg', NULL, NULL, 24, '324396', 'Sony DCR-TRV38', '25thumb.jpg', 0, NULL),
(8, 'DV Kit 8', '910big.jpg', NULL, NULL, 24, 'J9SA10582', 'Panasonic PV-DV910D', '910thumb.jpg', 0, NULL),
(63, 'Glidecam 2000 Pro', NULL, NULL, NULL, 24, NULL, '2000 PRO', NULL, 0, NULL),
(87, 'iBook A', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(88, 'iBook B', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(89, 'iBook C', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(90, 'iBook D', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(91, 'iBook E', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(92, 'iBook F', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(93, 'iBook G', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(94, 'iBook H', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(95, 'iBook I', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(96, 'iBook J', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(97, 'iBook K', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(98, 'iBook L', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(99, 'iBook M', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(100, 'iBook N', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(101, 'iBook O', 'ibookbig.jpg', NULL, NULL, 24, NULL, NULL, 'ibookthumb.jpg', 0, NULL),
(41, 'Lowel Multimedia Light Kit 1', 'lightbig.jpg', NULL, NULL, 24, NULL, 'Lowel Omni-Tota', 'lightthumb.jpg', 0, NULL),
(76, 'Lowel Multimedia Light Kit 2', 'lightbig.jpg', NULL, NULL, 24, NULL, 'Lowel Omni, Tota, Pro, Rifa', 'lightthumb.jpg', 0, NULL),
(77, 'Lowel Multimedia Light Kit 3', 'lightbig.jpg', NULL, NULL, 24, NULL, 'Omni, Tota, Pro Rifa', 'lightthumb.jpg', 0, NULL),
(78, 'Lowel Multimedia Light Kit 4', 'lightbig.jpg', NULL, NULL, 24, NULL, 'Omni, Tota, Pro, Rifa', 'lightthumb.jpg', 0, NULL),
(62, 'Magellan GPS', NULL, NULL, NULL, 24, '0041964', 'MAP 330', NULL, 0, NULL),
(61, 'Marantz Digital Audio Recorder', 'DARbig.jpg', NULL, NULL, 24, NULL, NULL, 'DARthumb.jpg', 0, NULL),
(38, 'POV Video Camera (Helmet-Cam)', NULL, NULL, NULL, 24, 'N020504480', 'AVC597N/F36', NULL, 0, NULL),
(51, 'QTVR Tripod Head', NULL, NULL, NULL, 24, NULL, NULL, NULL, 0, NULL),
(52, 'QTVR Tripod Head', NULL, NULL, NULL, 24, NULL, NULL, NULL, 0, NULL),
(53, 'QTVR Tripod Head', NULL, NULL, NULL, 24, NULL, NULL, NULL, 0, NULL),
(10, 'Sony DV Deck', 'sonydvdeck.jpg', NULL, NULL, 24, NULL, NULL, 'sonydvdeckthumb.jpg', 0, NULL),
(82, 'Sony HD Cam', 'Sonyhdbig.jpg', NULL, NULL, 24, NULL, NULL, 'Sonyhdthumb.jpg', 0, NULL),
(34, 'Telephoto Adapter - SONY DV CAMERAS ONLY', NULL, NULL, NULL, 24, NULL, 'Kodak 2x Telephoto Converter', NULL, 0, NULL),
(35, 'Tripod Only (without camera)', NULL, NULL, NULL, 24, NULL, 'Tripod', NULL, 0, NULL),
(36, 'Tripod Only (without camera)', NULL, NULL, NULL, 24, NULL, 'Tripod', NULL, 0, NULL),
(37, 'Tripod Only (without camera)', NULL, NULL, NULL, 24, NULL, 'Tripod', NULL, 0, NULL),
(33, 'Wide Angle Adapter - SONY DV CAMERAS ONLY', NULL, NULL, NULL, 24, NULL, 'Kodak .5x Wide Angle Converter', NULL, 0, NULL),
(9, 'Wireless Mic', NULL, NULL, NULL, 24, NULL, 'WM-PRO', NULL, 0, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `kit_accessorytype`
-- 

CREATE TABLE `kit_accessorytype` (
  `ID` int(16) NOT NULL auto_increment,
  `KitID` int(16) NOT NULL default '0',
  `AccessorytypeID` int(16) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=709 ;

-- 
-- Dumping data for table `kit_accessorytype`
-- 

INSERT INTO `kit_accessorytype` (`ID`, `KitID`, `AccessorytypeID`) VALUES (593, 76, 90),
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
(704, 101, 91);

-- --------------------------------------------------------

-- 
-- Table structure for table `kit_class`
-- 

CREATE TABLE `kit_class` (
  `ID` int(16) NOT NULL auto_increment,
  `KitID` int(16) NOT NULL default '0',
  `ClassID` int(16) NOT NULL default '0',
  `CheckHours` int(16) NOT NULL default '0',
  `OverNightAllowed` int(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=518 ;

-- 
-- Dumping data for table `kit_class`
-- 

INSERT INTO `kit_class` (`ID`, `KitID`, `ClassID`, `CheckHours`, `OverNightAllowed`) VALUES (384, 71, 7, 24, 1),
(1, 2, 1, 24, 1),
(2, 4, 1, 24, 1),
(3, 5, 1, 24, 1),
(4, 7, 1, 24, 1),
(5, 8, 1, 24, 1),
(6, 9, 1, 24, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `student_class`
-- 

CREATE TABLE `student_class` (
  `ID` int(16) NOT NULL auto_increment,
  `StudentID` int(16) NOT NULL default '0',
  `ClassID` int(16) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `student_class`
-- 

INSERT INTO `student_class` (`ID`, `StudentID`, `ClassID`) VALUES (1, 1234, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `students`
-- 

CREATE TABLE `students` (
  `ID` int(11) NOT NULL auto_increment,
  `StudentID` varchar(255) NOT NULL default '',
  `FirstName` varchar(255) NOT NULL default '',
  `LastName` varchar(255) NOT NULL default '',
  `Email` varchar(255) default NULL,
  `Phone` varchar(255) default NULL,
  `ContractSigned` int(1) default NULL,
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `ID_2` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `students`
-- 

INSERT INTO `students` (`ID`, `StudentID`, `FirstName`, `LastName`, `Email`, `ContractSigned`) VALUES (1, '1234', 'John', 'Smith', 'jsmith@email.edu', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `ID` int(11) NOT NULL auto_increment,
  `Username` varchar(255) NOT NULL default '',
  `Password` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`ID`, `Username`, `Password`) VALUES (1, 'checkoutguy', 'password');
