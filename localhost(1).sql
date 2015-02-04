-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 04, 2015 at 06:03 AM
-- Server version: 5.5.40-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `videodsu_ccdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `Client_Information`
--

CREATE TABLE IF NOT EXISTS `Client_Information` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active_option` int(1) NOT NULL,
  `company_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contact_person` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `company_icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mobile_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tel_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fax_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address_one` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address_two` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name` (`company_name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Client_Information`
--

INSERT INTO `Client_Information` (`id`, `active_option`, `company_name`, `contact_person`, `company_icon`, `mobile_number`, `tel_number`, `fax_number`, `address_one`, `address_two`, `state`, `postcode`, `email`) VALUES
(1, 0, 'IDP Education Ltd', 'Dario Paolini', 'http://videodash.surgehost.com.au/Client_Logo/1415081031IELTS.jpg', '0437149257', '0396124556', '', 'Level 8 535 Bourke Street ', 'Melbourne', 'VIC', '3000', 'dario.paolini@idp.com'),
(2, 1, 'Surge Media PTY LTD', 'Aegir', 'http://videodash.surgehost.com.au/Client_Logo/1415663538logo.jpg', '0477777777', '0477777777', '0477777777', '208 Logan Road', 'Woolloongabba', 'QLD', '4102', 'info@surgemedia.com.au'),
(3, 1, 'Mino I.T', 'Keith Mino', 'http://videodash.surgehost.com.au/Client_Logo/1418261781logo.jpg', '0415586602', '0415586602', '0415586602', 'PO BOX 3214', 'Yeronga', 'QLD', '4101', 'keith.m@minoit.com.au'),
(5, 1, 'Queensland Educational Leadership Institute', 'Dario Paolini', 'http://videodash.surgehost.com.au/Client_Logo/1422854892qeli_logo.png', '0400992254', '0400992254', '', 'Floor 3, Penola Place', '143 Edward Street ', 'QLD', '4000', 'clonan@clonanconnections.com.au'),
(6, 1, 'Onsite Rental Group Operations', 'Russell King', 'http://videodash.surgehost.com.au/Client_Logo/1422856486onsite.jpg', '0288143200', '134040', '134040', '5/28 Foveaux Street', 'Surry Hills', 'NSW', '2010', 'info@onsite.com.au');

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE IF NOT EXISTS `adminlogin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `enabling` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`id`, `username`, `password`, `enabling`) VALUES
(1, 'brad', 'a8e3c44fe3b76ed1ae46c044d7296515', 1),
(2, 'surgemedia', '18afd32315e46c6ccb98f29ba23fcc3c', 1);

-- --------------------------------------------------------

--
-- Table structure for table `video_client_addition_request`
--

CREATE TABLE IF NOT EXISTS `video_client_addition_request` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `video_id` int(11) NOT NULL,
  `script1` int(1) NOT NULL,
  `script2` int(1) NOT NULL,
  `logoandimage_email` int(1) NOT NULL,
  `logoandimage_dropbox` int(1) NOT NULL,
  `voice_id` int(11) NOT NULL,
  `voice_comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `audio_comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contact_info1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contact_info2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contact_info3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contact_info4` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `video_client_addition_request`
--

INSERT INTO `video_client_addition_request` (`id`, `video_id`, `script1`, `script2`, `logoandimage_email`, `logoandimage_dropbox`, `voice_id`, `voice_comment`, `audio_comment`, `contact_info1`, `contact_info2`, `contact_info3`, `contact_info4`) VALUES
(1, 2, 0, 0, 0, 0, 0, '', 'Audio Comment:', '', '', '', ''),
(2, 2, 0, 0, 0, 0, 0, '', 'Audio Comment:', '', '', '', ''),
(3, 3, 0, 0, 0, 0, 0, '', 'Audio Comment:', '', '', '', ''),
(4, 3, 1, 1, 0, 0, 2, '1234', 'Audio Comment:frtv', '1', '2', '3', '4'),
(5, 0, 1, 1, 1, 0, 0, '1234', 'Audio Comment:', '1', '2', '3', '4'),
(6, 0, 1, 1, 1, 0, 2, '1234', 'Audio Comment:ewrrewr', '1', '2', '3', '4'),
(7, 0, 1, 1, 1, 1, 0, '1234', 'Audio Comment:', '1', '2', '3', '4'),
(8, 0, 1, 1, 1, 1, 0, '1234', 'Audio Comment:', '1', '2', '3', '4'),
(9, 0, 1, 1, 1, 1, 0, '1234', 'Audio Comment:', '1', '2', '3', '4'),
(10, 0, 1, 1, 1, 1, 0, '1234', 'Audio Comment:', '1', '2', '3', '4'),
(11, 0, 1, 1, 1, 1, 0, '1234', 'Audio Comment:', '1', '2', '3', '4'),
(12, 0, 1, 1, 1, 1, 0, '1234', 'Audio Comment:', '1', '2', '3', '4'),
(13, 0, 1, 1, 1, 1, 0, '1234', 'Audio Comment:', '1', '2', '3', '4'),
(14, 0, 1, 1, 1, 1, 0, '1234', 'Audio Comment:', '1', '2', '3', '4'),
(15, 3, 1, 1, 1, 1, 0, '1234', 'Audio Comment:', '1', '2', '3', '4'),
(16, 3, 1, 1, 1, 1, 2, '1234', 'Audio Comment:wqertwer', '1', '2', '3', '4'),
(17, 3, 1, 1, 1, 1, 2, 'Can they have a gizzly Voice', 'Audio Comment:', 'Alex', 'Testing', 'This Field', 'Tesging'),
(18, 3, 1, 0, 1, 0, 2, 'Can they have a gizzly Voice', 'Audio Comment:', 'Alex', 'Testing', 'This Field', 'Tesging'),
(19, 4, 0, 0, 0, 0, 0, '', 'Audio Comment:', '', '', '', ''),
(20, 4, 0, 0, 0, 0, 0, '', 'Audio Comment:', '', '', '', ''),
(21, 4, 0, 0, 0, 0, 0, '', 'Audio Comment:', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `video_client_request`
--

CREATE TABLE IF NOT EXISTS `video_client_request` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `video_id` int(11) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `feedback` varchar(1023) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `video_client_request`
--

INSERT INTO `video_client_request` (`id`, `video_id`, `time_start`, `time_end`, `feedback`) VALUES
(1, 2, '01:30:00', '01:35:00', 'Too Much Orange'),
(2, 2, '00:00:00', '02:59:00', 'Even More Orange'),
(3, 3, '00:00:00', '02:59:00', 'Even More Orange'),
(4, 3, '01:22:00', '02:59:00', 'test'),
(5, 3, '01:22:00', '02:59:00', 'test'),
(6, 3, '01:22:00', '02:59:00', 'test'),
(7, 3, '01:22:00', '02:59:00', 'test'),
(8, 3, '01:22:00', '02:59:00', 'test'),
(9, 3, '01:22:00', '02:59:00', 'test'),
(10, 3, '01:22:00', '02:59:00', 'test'),
(11, 3, '00:00:00', '02:59:00', '1212'),
(12, 3, '00:00:00', '02:59:00', '32134'),
(13, 3, '00:00:00', '02:59:00', 'Test'),
(14, 3, '01:01:00', '02:59:00', 'Too many red bubbles'),
(15, 4, '01:00:00', '02:59:00', 'You are hullarious!!! to many llama');

-- --------------------------------------------------------

--
-- Table structure for table `video_project`
--

CREATE TABLE IF NOT EXISTS `video_project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Client_id` int(11) NOT NULL,
  `project_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_request` varchar(1023) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active_option` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `video_project`
--

INSERT INTO `video_project` (`id`, `Client_id`, `project_name`, `client_request`, `active_option`) VALUES
(1, 1, 'IELTS BRISBANE', 'IELTS BRISBANE 25 Years Promotion Video', 0),
(2, 1, 'Testing', '', 0),
(3, 1, 'Testing', '', 0),
(4, 1, 'Testing', '', 0),
(5, 1, 'Testing', '', 0),
(6, 3, 'test3', '', 0),
(7, 3, 'brad rock', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `video_under_project`
--

CREATE TABLE IF NOT EXISTS `video_under_project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `video_project_id` int(11) NOT NULL,
  `video_link` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(2048) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `enabling` int(1) NOT NULL,
  `version_num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `video_under_project`
--

INSERT INTO `video_under_project` (`id`, `video_project_id`, `video_link`, `version`, `notes`, `enabling`, `version_num`) VALUES
(1, 1, 'QubLnryAdxo', 'Draft', 'For your review', 1, 1),
(2, 1, 'ScMzIvxBSi4', 'Draft', 'Last Thursdays Changes', 1, 2),
(3, 1, 'ScMzIvxBSi4', 'Draft', 'Last Thursdays Changes', 1, 3),
(4, 1, 'A_6XHB8D9vQ', 'Draft', 'Im am awesome!!!!!!', 1, 4),
(5, 7, 'https://www.youtube.com/watch?v=xmKvatGuY64', 'Draft', 'Nice Job!', 1, 1),
(6, 7, 'https://www.youtube.com/watch?v=lKrekxgZzBw', 'Draft', 'Half price video done.', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `voice_talent`
--

CREATE TABLE IF NOT EXISTS `voice_talent` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voice_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `avaliable` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `voice_talent`
--

INSERT INTO `voice_talent` (`id`, `voice_name`, `avaliable`) VALUES
(1, 'adam - male1', 1),
(2, 'joy female 1', 1);
--
-- Database: `videodsu_cindy`
--

-- --------------------------------------------------------

--
-- Table structure for table `Cindy`
--

CREATE TABLE IF NOT EXISTS `Cindy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gender` int(1) NOT NULL,
  `enabling` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Cindy`
--

INSERT INTO `Cindy` (`id`, `name`, `gender`, `enabling`) VALUES
(1, 'Cindy Zhang', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `City`
--

CREATE TABLE IF NOT EXISTS `City` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `Name` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Enabling` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `City`
--

INSERT INTO `City` (`id`, `country_id`, `Name`, `Enabling`) VALUES
(1, 1, 'Brisbane', 1),
(2, 1, 'Sydney', 1),
(3, 2, 'Shanghai', 1),
(4, 3, 'Queenstown', 1),
(5, 4, 'NewYork', 1),
(6, 5, 'Tokyo', 1),
(7, 6, 'Soel', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Country`
--

CREATE TABLE IF NOT EXISTS `Country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Country`
--

INSERT INTO `Country` (`id`, `Name`) VALUES
(1, 'Australia'),
(2, 'China'),
(3, 'NZ'),
(4, 'US'),
(5, 'Japan'),
(6, 'Korea');

-- --------------------------------------------------------

--
-- Table structure for table `Membership`
--

CREATE TABLE IF NOT EXISTS `Membership` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Tel` int(15) NOT NULL,
  `Country_id` int(11) NOT NULL,
  `City_id` int(11) NOT NULL,
  `gender_id` int(11) NOT NULL,
  `enabling` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Membership`
--

INSERT INTO `Membership` (`id`, `Name`, `Address`, `Tel`, `Country_id`, `City_id`, `gender_id`, `enabling`) VALUES
(1, 'Cindy Zhang', '111 lemon st', 1010101010, 2, 3, 2, 1),
(2, 'Brad Wong', '222 Peach st', 11111111, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE IF NOT EXISTS `gender` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `name`) VALUES
(1, 'Man'),
(2, 'Female');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
