-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2016 at 06:30 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `demodatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(11) NOT NULL,
  `userid_created` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notification_types`
--

CREATE TABLE IF NOT EXISTS `notification_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE IF NOT EXISTS `user_notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_read` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `workflow_action`
--

CREATE TABLE IF NOT EXISTS `workflow_action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `workflow_id` int(10) unsigned NOT NULL,
  `condition` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `workflow_action_1` (`workflow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `workflow_name`
--

CREATE TABLE IF NOT EXISTS `workflow_name` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_note` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `workflow_rules`
--

CREATE TABLE IF NOT EXISTS `workflow_rules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `workflow_id` int(10) unsigned NOT NULL,
  `matching_criteria` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matching_scenario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matching_relation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matching_value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `workflow_rules_1` (`workflow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Constraints for table `workflow_action`
--
ALTER TABLE `workflow_action`
  ADD CONSTRAINT `workflow_action_1` FOREIGN KEY (`workflow_id`) REFERENCES `workflow_name` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `workflow_rules`
--
ALTER TABLE `workflow_rules`
  ADD CONSTRAINT `workflow_rules_1` FOREIGN KEY (`workflow_id`) REFERENCES `workflow_name` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `ticket_thread`
--
ALTER TABLE `ticket_thread` 
  ADD `reply_rating` INT(11) NOT NULL AFTER `source`, 
  ADD `rating_count` INT(11) NOT NULL AFTER `reply_rating`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
