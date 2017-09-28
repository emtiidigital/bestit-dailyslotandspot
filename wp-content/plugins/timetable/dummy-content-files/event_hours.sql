-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 10 Kwi 2014, 10:31
-- Server version: 5.1.73-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `qlabs_wp_plugins`
--

-- --------------------------------------------------------

--
-- Table structure `wp_event_hours`
--

CREATE TABLE IF NOT EXISTS `wp_event_hours` (
  `event_hours_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) NOT NULL,
  `weekday_id` bigint(20) NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `tooltip` text COLLATE utf8_unicode_ci NOT NULL,
  `before_hour_text` text COLLATE utf8_unicode_ci NOT NULL,
  `after_hour_text` text COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`event_hours_id`),
  KEY `event_id` (`event_id`),
  KEY `weekday_id` (`weekday_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=590 ;

--
-- Table data `wp_event_hours`
--

INSERT INTO `wp_event_hours` (`event_hours_id`, `event_id`, `weekday_id`, `start`, `end`, `tooltip`, `before_hour_text`, `after_hour_text`, `category`) VALUES
(242, 2146, 1217, '11:00:00', '13:00:00', 'Reaction time training with sparring partners.', 'Boxing class', 'Robert Bandana', ''),
(247, 15, 1214, '15:00:00', '15:45:00', '', 'High impact', 'Mark Moreau', ''),
(238, 2148, 1217, '17:00:00', '18:30:00', '', 'Advanced', 'Kevin Nomak', ''),
(222, 2148, 1218, '15:00:00', '16:00:00', '', 'Beginners', 'Kevin Nomak', ''),
(223, 2148, 1213, '15:00:00', '16:00:00', '', 'Intermediate', 'Kevin Nomak', ''),
(244, 2144, 1217, '15:00:00', '16:00:00', 'Basic exercises for kids.', 'Preschool class', 'Emma Brown', ''),
(183, 15, 2132, '16:00:00', '17:00:00', '', 'Low impact', 'Mark Moreau', ''),
(184, 15, 1213, '16:00:00', '17:00:00', '', 'High impact', 'Trevor Smith', ''),
(199, 2139, 1216, '07:00:00', '09:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', ''),
(185, 15, 1214, '16:00:00', '17:00:00', '', 'Low impact', 'Mark Moreau', ''),
(228, 2142, 1218, '13:00:00', '15:00:00', '', 'Body works', 'Kevin Nomak', ''),
(239, 2148, 2132, '15:00:00', '16:00:00', 'Advanced stamina workout.', 'Advanced', 'Kevin Nomak', ''),
(205, 2139, 1213, '07:00:00', '11:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', ''),
(163, 2146, 1216, '14:00:00', '15:00:00', '', 'Thai boxing', 'Robert Bandana', ''),
(156, 2146, 1213, '11:00:00', '13:00:00', '', 'MMA beginners', 'Robert Bandana', ''),
(243, 2144, 1216, '15:00:00', '16:00:00', 'Basic exercises for kids.', 'Preschool class', 'Emma Brown', ''),
(162, 2146, 1215, '14:00:00', '15:00:00', '', 'Thai boxing', 'Robert Bandana', ''),
(190, 2142, 1213, '18:00:00', '19:30:00', '', 'Weightlifting', 'Kevin Nomak', ''),
(141, 2144, 1216, '17:00:00', '18:30:00', '', 'Fitness and fun', 'Emma Brown', ''),
(139, 2144, 1214, '17:00:00', '18:30:00', '', 'Zumba dance', 'Emma Brown', ''),
(144, 2144, 1217, '17:00:00', '18:30:00', '', 'Fitness and fun', 'Emma Brown', ''),
(164, 2148, 1214, '07:00:00', '09:00:00', '', 'Weightlifting', 'Kevin Nomak', ''),
(193, 2148, 1215, '17:00:00', '18:30:00', '', 'Beginners', 'Kevin Nomak', ''),
(231, 15, 1217, '16:00:00', '17:00:00', '', 'High impact', 'Trevor Smith', ''),
(152, 2146, 1213, '13:00:00', '14:00:00', '', 'MMA all levels', 'Robert Bandana', ''),
(153, 2146, 1217, '13:00:00', '14:00:00', '', 'MMA all levels', 'Robert Bandana', ''),
(157, 2146, 2132, '11:00:00', '13:00:00', '', 'Boxing class', 'Robert Bandana', ''),
(214, 2148, 1217, '14:00:00', '15:00:00', '', 'Weightlifting', 'Kevin Nomak', ''),
(204, 2139, 2132, '07:00:00', '11:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', ''),
(189, 2142, 2132, '18:00:00', '19:30:00', '', 'Weightlifting', 'Kevin Nomak', ''),
(175, 2144, 1215, '17:00:00', '18:30:00', '', 'Advanced', 'Emma Brown', ''),
(229, 2139, 1218, '07:00:00', '11:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', ''),
(221, 2139, 1215, '07:00:00', '12:00:00', 'Open entry to the fitness room with wide variety of equipment.', 'Open entry', 'Mark Moreau', ''),
(227, 2142, 1218, '11:00:00', '13:00:00', '', 'Weightlifting', 'Kevin Nomak', ''),
(232, 2144, 1213, '08:00:00', '09:00:00', '', 'Advanced', 'Emma Brown', ''),
(191, 2142, 1215, '12:30:00', '14:00:00', '', 'Weightlifting', 'Kevin Nomak', ''),
(192, 2142, 1216, '12:30:00', '14:00:00', '', 'Weightlifting', 'Kevin Nomak', ''),
(207, 2144, 1214, '11:00:00', '13:00:00', '', 'Beginners', 'Emma Brown', ''),
(210, 2144, 2132, '08:00:00', '09:00:00', '', 'Beginners', 'Emma Brown', ''),
(246, 2148, 1214, '13:00:00', '15:00:00', '', 'Beginners', 'Kevin Nomak', ''),
(230, 2146, 1218, '16:00:00', '17:00:00', '', 'Thai boxing', 'Robert Bandana', ''),
(315, 2159, 2132, '11:00:00', '12:45:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Beginner', ''),
(329, 2164, 1214, '09:00:00', '10:30:00', 'Mixed Martial Arts training with Muay Thai and Thai Boxing.', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> Beginner', ''),
(313, 2164, 2132, '09:00:00', '10:30:00', '', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> Beginner', ''),
(331, 2177, 1215, '14:00:00', '17:00:00', 'Super stamina workout and weightlifting.', '', '<strong>Instructor:</strong> K. Nomak<br/>\r\n<strong>Room:</strong> 305A<br/>\r\n<strong>Level:</strong> All Levels', ''),
(319, 2159, 1215, '11:00:00', '12:45:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Beginner', ''),
(493, 2244, 2229, '16:00:00', '18:22:00', '', 'Horror', 'Free Entry<br/>\r\n142 min.', ''),
(330, 2159, 1214, '11:00:00', '14:00:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Advanced', ''),
(314, 2164, 1213, '11:00:00', '12:45:00', '', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> Intermediate', ''),
(459, 2298, 2230, '12:30:00', '14:00:00', '', 'Catering', 'Free Entry<br/>\r\n90 min.', ''),
(327, 2164, 1217, '09:00:00', '12:45:00', 'Mixed Martial Arts training with Muay Thai and Thai Boxing.', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> All Levels', ''),
(473, 2243, 2227, '16:30:00', '17:56:00', '', 'Animation', 'Free Entry<br/>\r\n86 min.', ''),
(323, 2177, 1217, '14:00:00', '18:00:00', '', '', '<strong>Instructor:</strong> K. Nomak<br/>\r\n<strong>Room:</strong> 305A<br/>\r\n<strong>Level:</strong> All Levels', ''),
(325, 2164, 1215, '09:00:00', '10:30:00', '', '', '<strong>Instructor:</strong> R. Bandana<br/>\r\n<strong>Room:</strong> 24<br/>\r\n<strong>Level:</strong> Beginner', ''),
(301, 2177, 1213, '13:00:00', '14:00:00', '', '', '<strong>Instructor:</strong> K. Nomak<br/>\r\n<strong>Room:</strong> 305A<br/>\r\n<strong>Level:</strong> All Levels', ''),
(300, 2177, 2132, '13:00:00', '14:00:00', '', '', '<strong>Instructor:</strong> K. Nomak<br/>\r\n<strong>Room:</strong> 305A<br/>\r\n<strong>Level:</strong> All Levels', ''),
(309, 2159, 2132, '15:00:00', '16:30:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Advanced', ''),
(332, 2191, 1213, '09:00:00', '09:45:00', '', '', 'Class Leader<br/>Ann Smith', ''),
(333, 2191, 1214, '10:00:00', '10:45:00', '', '', 'Class Leader<br/>Emma White', ''),
(324, 2159, 1217, '13:00:00', '14:00:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> All Levels', ''),
(310, 2159, 1213, '15:00:00', '16:30:00', '', '', '<strong>Instructor:</strong> M. Moreau<br/>\r\n<strong>Room:</strong> 6<br/>\r\n<strong>Level:</strong> Advanced', ''),
(417, 2242, 2229, '14:40:00', '16:30:00', '', 'Animation', 'G Rating<br/>\r\n110 min.', ''),
(433, 2264, 2229, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', ''),
(492, 2244, 2227, '14:00:00', '16:22:00', '', 'Horror', 'Free Entry<br/>\r\n142 min.', ''),
(488, 2266, 2227, '09:00:00', '12:30:00', '', 'Concert', '$60 Entry<br/>\r\n210 min.<br/><br/>\r\nUnder 16''s to be accompanied by an adult.', ''),
(467, 2239, 2231, '14:00:00', '16:15:00', '', 'Adventure', '$10 Entry<br/>\r\n135 min.', ''),
(560, 2353, 2343, '11:30:00', '12:45:00', '', '', 'Performance', ''),
(434, 2264, 2231, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', ''),
(466, 2236, 2230, '14:00:00', '16:10:00', '', 'Thriller', 'Free Entry<br/>\r\n130 min.', ''),
(460, 2298, 2231, '12:30:00', '14:00:00', '', 'Catering', 'Free Entry<br/>\r\n90 min.', ''),
(479, 2310, 2231, '16:30:00', '18:30:00', '', 'Thriller', '$20 Entry<br/>\r\n120 min.', ''),
(474, 2238, 2231, '09:00:00', '10:45:00', '', 'Action', 'Free Entry<br/>\r\n105 min.', ''),
(458, 2298, 2229, '12:30:00', '14:00:00', '', 'Catering', 'Free Entry<br/>\r\n90 min.', ''),
(435, 2264, 2232, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', ''),
(477, 2245, 2232, '16:30:00', '17:56:00', '', 'Horror', '$10 Entry<br/>\r\n86 min.', ''),
(438, 2264, 2227, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', ''),
(471, 2243, 2231, '11:00:00', '12:26:00', '', 'Animation', 'Free Entry<br/>\r\n86 min.', ''),
(448, 2234, 2230, '11:00:00', '12:25:00', '', 'Animation', 'Free Entry<br/>\r\n85 min.', ''),
(496, 2237, 2229, '18:30:00', '20:10:00', '', 'Action', 'Free Entry<br/>\r\n100 min.', ''),
(461, 2298, 2227, '12:30:00', '14:00:00', '', 'Catering', 'Free Entry<br/>\r\n90 min.', ''),
(490, 2235, 2230, '09:00:00', '10:42:00', '', 'Comedy', 'Free Entry<br/>\r\n102 min.', ''),
(436, 2264, 2230, '16:30:00', '17:30:00', '', 'Free Snacks', 'Festival Pass', ''),
(476, 2245, 2232, '11:00:00', '12:26:00', '', 'Horror', '$10 Entry<br/>\r\n86 min.', ''),
(485, 2241, 2232, '12:30:00', '16:30:00', '', 'Concert', '$50 ticket<br/>\r\n240 min.<br/><br/>\r\nWith special guest Kevin Numan and Markus Smith.', ''),
(491, 2235, 2229, '14:00:00', '15:42:00', '', 'Comedy', 'Free Entry<br/>\r\n102 min.', ''),
(486, 2240, 2229, '09:00:00', '12:10:00', '', 'Concert', '$50 ticket<br/>\r\n190 min.<br/><br/>\r\nWith special guest Kevin Numan and Markus Smith.', ''),
(489, 2266, 2230, '16:30:00', '20:00:00', '', 'Concert', '$60 Entry<br/>\r\n210 min.<br/><br/>\r\nUnder 16''s to be accompanied by an adult.', ''),
(495, 2237, 2232, '09:00:00', '10:40:00', '', 'Action', 'Free Entry<br/>\r\n100 min.', ''),
(573, 2365, 2342, '09:00:00', '12:00:00', '', '', 'Registration and General Information', ''),
(561, 2350, 2343, '12:45:00', '14:00:00', '', '', 'Performance', ''),
(581, 2375, 2342, '16:30:00', '19:00:00', '', '', 'Conference Banquet With Closing Ceremony. John Williams Speech.', ''),
(570, 2351, 2343, '15:30:00', '16:45:00', '', '', 'Performance', ''),
(519, 2359, 2346, '12:00:00', '13:15:00', '', '', 'Screening', ''),
(536, 2367, 2344, '12:00:00', '15:00:00', '', '', 'Display', ''),
(537, 2366, 2344, '15:00:00', '17:30:00', '', '', 'Display', ''),
(526, 2362, 2346, '10:00:00', '12:00:00', '', '', 'Screening', ''),
(558, 2355, 2343, '09:00:00', '10:15:00', '', '', 'Performance', ''),
(520, 2361, 2346, '13:15:00', '14:40:00', '', '', 'Screening', ''),
(554, 2357, 2345, '13:30:00', '14:15:00', '', '', 'Panel with Josh Kowalsky', ''),
(535, 2368, 2344, '09:00:00', '12:00:00', '', '', 'Display', ''),
(556, 2374, 2342, '08:30:00', '09:00:00', '', '', '', ''),
(564, 2363, 2345, '09:00:00', '10:15:00', '', '', 'Panel with Ann Perkins', ''),
(572, 2352, 2346, '15:30:00', '17:15:00', '', '', 'Performance', ''),
(566, 2358, 2345, '11:30:00', '13:30:00', '', '', 'Panel with Robin Watson, Chris Prochaska and Shawn Georges', ''),
(562, 2364, 2347, '09:00:00', '12:30:00', '', '', 'Free Entry', ''),
(551, 2373, 2347, '12:30:00', '16:30:00', '', '', 'Luch Menu', ''),
(567, 2356, 2345, '14:15:00', '16:15:00', '', '', 'Panel with Helena Howington, Frank Kasper and John Williams ', ''),
(559, 2354, 2343, '10:15:00', '11:30:00', '', '', 'Performance', ''),
(565, 2360, 2345, '10:15:00', '11:30:00', '', '', 'Panel with Robin Landrum', ''),
(576, 2365, 2342, '13:30:00', '15:00:00', '', '', 'Registration and General Information', ''),
(588, 2367, 2344, '14:30:00', '15:00:00', '', 'Comments', 'Comments on Display Session', ''),
(589, 2366, 2344, '17:00:00', '17:30:00', '', 'Comments', 'Comments on Display Session', ''),
(587, 2368, 2344, '11:30:00', '12:00:00', '', 'Comments', 'Comments on Display Session', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
