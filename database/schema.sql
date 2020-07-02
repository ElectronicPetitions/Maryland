-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `admin_sessions`;
CREATE TABLE `admin_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `php_session` varchar(50) NOT NULL,
  `php_page` varchar(300) NOT NULL,
  `loaded_on_date` date NOT NULL,
  `action_on` timestamp NOT NULL,
  `username` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `browser_string` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `follow_up`;
CREATE TABLE `follow_up` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(300) NOT NULL,
  `php_session` varchar(300) NOT NULL,
  `status` varchar(300) NOT NULL DEFAULT 'NEW',
  `petition_id` int(10) NOT NULL,
  `feedback_message` text NOT NULL,
  `system_response` text NOT NULL,
  `date_sent` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `logo` varchar(250) NOT NULL,
  `background-color` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `petitions`;
CREATE TABLE `petitions` (
  `petition_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_status` varchar(20) NOT NULL DEFAULT 'new',
  `admin_sort` int(5) NOT NULL,
  `web_short_name` varchar(200) NOT NULL,
  `web_color` varchar(20) NOT NULL,
  `web_color_text` varchar(20) NOT NULL DEFAULT '#000000',
  `group_id` int(11) NOT NULL,
  `signature_goal` int(100) NOT NULL,
  `petition_name` varchar(200) NOT NULL,
  `petition_pdf` varchar(250) NOT NULL,
  `petition_jpg` varchar(250) NOT NULL,
  `petition_jpg_page2` varchar(250) NOT NULL,
  `eligibleVoterListField` varchar(250) NOT NULL,
  `eligibleVoterListEquals` varchar(250) NOT NULL,
  `eligibleVoterListEnforce` varchar(5) NOT NULL,
  `eligibleVoterSigMatch` varchar(5) NOT NULL,
  `petition_sign_text_box` text NOT NULL,
  `petition_circulator_text_box` text NOT NULL,
  `eligibleVoterListWarning` text NOT NULL,
  `text_cord_county` varchar(50) NOT NULL,
  `text_cord_cityX` varchar(50) NOT NULL,
  `hide_county_on_petition` varchar(50) NOT NULL DEFAULT 'NO',
  `offset_x_cords` int(11) NOT NULL,
  `offset_x_cords_circulator` int(11) NOT NULL,
  `offset_y_cords` int(11) NOT NULL,
  `offset_y_cords_circulator` int(11) NOT NULL,
  `tab_name` varchar(200) NOT NULL,
  `text_title` varchar(200) NOT NULL,
  `text_block` text NOT NULL,
  `logo_url` varchar(300) NOT NULL,
  `landing_page` varchar(300) NOT NULL,
  `social_website` varchar(300) NOT NULL,
  `social_twitter` varchar(300) NOT NULL,
  `social_facebook` varchar(300) NOT NULL,
  `social_email` varchar(300) NOT NULL,
  `social_phone` varchar(300) NOT NULL,
  PRIMARY KEY (`petition_id`),
  UNIQUE KEY `web_short_name` (`web_short_name`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `presign`;
CREATE TABLE `presign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_on` varchar(100) NOT NULL,
  `only_date` date NOT NULL,
  `php_session_id` varchar(300) NOT NULL,
  `php_page` varchar(300) NOT NULL,
  `name` varchar(200) NOT NULL,
  `petition` varchar(200) NOT NULL,
  `invite` varchar(200) NOT NULL,
  `invite_error` varchar(200) NOT NULL,
  `email_for_follow_up` varchar(200) NOT NULL,
  `phone_for_validation` varchar(200) NOT NULL,
  `presign_status` varchar(200) DEFAULT 'NEW',
  `ip_address` varchar(300) NOT NULL,
  `browser_string` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `signatures`;
CREATE TABLE `signatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VTRID` int(11) NOT NULL,
  `ip_address` varchar(200) NOT NULL,
  `date_of_birth` varchar(200) NOT NULL,
  `date_time_signed` datetime NOT NULL,
  `just_date` date NOT NULL,
  `petition_id` int(11) NOT NULL,
  `signed_name_as` varchar(250) NOT NULL,
  `signed_name_as_circulator` varchar(250) NOT NULL,
  `contact_phone` varchar(250) NOT NULL,
  `signature_status` varchar(250) NOT NULL,
  `printed_status` varchar(250) NOT NULL,
  `bot_check` text NOT NULL,
  `php_session_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `petition_id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `group_id` int(5) NOT NULL,
  `sec_level` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `VoterList`;
CREATE TABLE `VoterList` (
  `VTRID` int(11) NOT NULL,
  `LASTNAME` varchar(200) NOT NULL,
  `FIRSTNAME` varchar(200) NOT NULL,
  `MIDDLENAME` varchar(200) NOT NULL,
  `SUFFIX` varchar(200) NOT NULL,
  `GENDER` varchar(200) NOT NULL,
  `PARTY` varchar(200) NOT NULL,
  `HOUSE_NUMBER` varchar(200) NOT NULL,
  `HOUSE_SUFFIX` varchar(200) NOT NULL,
  `STREET_PREDIRECTION` varchar(200) NOT NULL,
  `STREETNAME` varchar(200) NOT NULL,
  `STREETTYPE` varchar(200) NOT NULL,
  `STREET_POSTDIRECTION` varchar(200) NOT NULL,
  `UNITTYPE` varchar(200) NOT NULL,
  `UNITNUMBER` varchar(200) NOT NULL,
  `ADDRESS` varchar(200) NOT NULL,
  `NON_STD_ADDRESS` varchar(200) NOT NULL,
  `RESIDENTIALCITY` varchar(200) NOT NULL,
  `RESIDENTIALSTATE` varchar(200) NOT NULL,
  `RESIDENTIALZIP5` varchar(200) NOT NULL,
  `RESIDENTIALZIP4` varchar(200) NOT NULL,
  `MAILINGADDRESS` varchar(200) NOT NULL,
  `MAILINGCITY` varchar(200) NOT NULL,
  `MAILINGSTATE` varchar(200) NOT NULL,
  `MAILINGZIP5` varchar(200) NOT NULL,
  `MAILINGZIP4` varchar(200) NOT NULL,
  `COUNTRY` varchar(200) NOT NULL,
  `STATUS_CODE` varchar(200) NOT NULL,
  `STATE_REGISTRATION_DATE` varchar(200) NOT NULL,
  `COUNTY_REGISTRATION_DATE` varchar(200) NOT NULL,
  `PRECINCT` varchar(200) NOT NULL,
  `SPLIT` varchar(200) NOT NULL,
  `COUNTY` varchar(200) NOT NULL,
  `CONGRESSIONAL_DISTRICTS` varchar(200) NOT NULL,
  `LEGISLATIVE_DISTRICTS` varchar(200) NOT NULL,
  `COUNCILMANIC_DISTRICTS` varchar(200) NOT NULL,
  `WARD_DISTRICTS` varchar(200) NOT NULL,
  `MUNICIPAL_DISTRICTS` varchar(200) NOT NULL,
  `COMMISSIONER_DISTRICTS` varchar(200) NOT NULL,
  `SCHOOL_DISTRICTS` varchar(200) NOT NULL,
  UNIQUE KEY `VTRID` (`VTRID`),
  KEY `LASTNAME` (`LASTNAME`),
  KEY `FIRSTNAME` (`FIRSTNAME`),
  KEY `HOUSE_NUMBER` (`HOUSE_NUMBER`),
  KEY `RESIDENTIALZIP5` (`RESIDENTIALZIP5`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `website_text`;
CREATE TABLE `website_text` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `text_title` varchar(200) NOT NULL,
  `text_block` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2020-07-02 13:19:50
