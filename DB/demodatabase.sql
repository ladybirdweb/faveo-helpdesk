-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2016 at 07:01 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `version_1.8`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_settings`
--

CREATE TABLE IF NOT EXISTS `api_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `approval`
--

CREATE TABLE IF NOT EXISTS `approval` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `approval`
--

INSERT INTO `approval` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'approval', '0', '2016-11-29 23:28:11', '2016-11-29 23:28:11');

-- --------------------------------------------------------

--
-- Table structure for table `banlist`
--

CREATE TABLE IF NOT EXISTS `banlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ban_status` tinyint(1) NOT NULL,
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bar_notifications`
--

CREATE TABLE IF NOT EXISTS `bar_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bar_notifications`
--

INSERT INTO `bar_notifications` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'new-version', '', '2016-11-29 23:29:29', '2016-11-29 23:29:29');

-- --------------------------------------------------------

--
-- Table structure for table `canned_response`
--

CREATE TABLE IF NOT EXISTS `canned_response` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `common_settings`
--

CREATE TABLE IF NOT EXISTS `common_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `option_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `optional_field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `common_settings`
--

INSERT INTO `common_settings` (`id`, `option_name`, `option_value`, `status`, `optional_field`, `created_at`, `updated_at`) VALUES
(1, 'ticket_token_time_duration', '1', '', '', '2016-11-29 23:28:46', '2016-11-29 23:28:46'),
(2, 'enable_rtl', '', '', '', '2016-11-29 23:28:46', '2016-11-29 23:28:46'),
(3, 'user_set_ticket_status', '', '1', '', '2016-11-29 23:28:46', '2016-11-29 23:28:46'),
(4, 'send_otp', '', '0', '', '2016-11-29 23:28:46', '2016-11-29 23:28:46'),
(5, 'email_mandatory', '', '1', '', '2016-11-29 23:28:46', '2016-11-29 23:28:46'),
(6, 'user_priority', '', '0', '', '2016-11-29 23:28:46', '2016-11-29 23:28:46');

-- --------------------------------------------------------

--
-- Table structure for table `conditions`
--

CREATE TABLE IF NOT EXISTS `conditions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `country_code`
--

CREATE TABLE IF NOT EXISTS `country_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `iso` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nicename` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `iso3` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `numcode` smallint(6) NOT NULL,
  `phonecode` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=240 ;

--
-- Dumping data for table `country_code`
--

INSERT INTO `country_code` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`, `created_at`, `updated_at`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93, '2016-11-29 23:28:20', '2016-11-29 23:28:20'),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355, '2016-11-29 23:28:20', '2016-11-29 23:28:20'),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213, '2016-11-29 23:28:20', '2016-11-29 23:28:20'),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684, '2016-11-29 23:28:20', '2016-11-29 23:28:20'),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376, '2016-11-29 23:28:21', '2016-11-29 23:28:21'),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244, '2016-11-29 23:28:21', '2016-11-29 23:28:21'),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264, '2016-11-29 23:28:21', '2016-11-29 23:28:21'),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', 'NUL', 0, 0, '2016-11-29 23:28:21', '2016-11-29 23:28:21'),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268, '2016-11-29 23:28:21', '2016-11-29 23:28:21'),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54, '2016-11-29 23:28:21', '2016-11-29 23:28:21'),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374, '2016-11-29 23:28:21', '2016-11-29 23:28:21'),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297, '2016-11-29 23:28:21', '2016-11-29 23:28:21'),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61, '2016-11-29 23:28:21', '2016-11-29 23:28:21'),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43, '2016-11-29 23:28:21', '2016-11-29 23:28:21'),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994, '2016-11-29 23:28:22', '2016-11-29 23:28:22'),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242, '2016-11-29 23:28:22', '2016-11-29 23:28:22'),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973, '2016-11-29 23:28:22', '2016-11-29 23:28:22'),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880, '2016-11-29 23:28:22', '2016-11-29 23:28:22'),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246, '2016-11-29 23:28:22', '2016-11-29 23:28:22'),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375, '2016-11-29 23:28:22', '2016-11-29 23:28:22'),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32, '2016-11-29 23:28:22', '2016-11-29 23:28:22'),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501, '2016-11-29 23:28:22', '2016-11-29 23:28:22'),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229, '2016-11-29 23:28:22', '2016-11-29 23:28:22'),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441, '2016-11-29 23:28:22', '2016-11-29 23:28:22'),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975, '2016-11-29 23:28:22', '2016-11-29 23:28:22'),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591, '2016-11-29 23:28:23', '2016-11-29 23:28:23'),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387, '2016-11-29 23:28:23', '2016-11-29 23:28:23'),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267, '2016-11-29 23:28:23', '2016-11-29 23:28:23'),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', 'NUL', 0, 0, '2016-11-29 23:28:23', '2016-11-29 23:28:23'),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55, '2016-11-29 23:28:23', '2016-11-29 23:28:23'),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', 'NUL', 0, 246, '2016-11-29 23:28:23', '2016-11-29 23:28:23'),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673, '2016-11-29 23:28:23', '2016-11-29 23:28:23'),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359, '2016-11-29 23:28:23', '2016-11-29 23:28:23'),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226, '2016-11-29 23:28:23', '2016-11-29 23:28:23'),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257, '2016-11-29 23:28:23', '2016-11-29 23:28:23'),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855, '2016-11-29 23:28:23', '2016-11-29 23:28:23'),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237, '2016-11-29 23:28:23', '2016-11-29 23:28:23'),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1, '2016-11-29 23:28:24', '2016-11-29 23:28:24'),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238, '2016-11-29 23:28:24', '2016-11-29 23:28:24'),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345, '2016-11-29 23:28:24', '2016-11-29 23:28:24'),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236, '2016-11-29 23:28:24', '2016-11-29 23:28:24'),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235, '2016-11-29 23:28:24', '2016-11-29 23:28:24'),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56, '2016-11-29 23:28:24', '2016-11-29 23:28:24'),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86, '2016-11-29 23:28:24', '2016-11-29 23:28:24'),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', 'NUL', 0, 61, '2016-11-29 23:28:24', '2016-11-29 23:28:24'),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', 'NUL', 0, 672, '2016-11-29 23:28:24', '2016-11-29 23:28:24'),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57, '2016-11-29 23:28:24', '2016-11-29 23:28:24'),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269, '2016-11-29 23:28:24', '2016-11-29 23:28:24'),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242, '2016-11-29 23:28:25', '2016-11-29 23:28:25'),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242, '2016-11-29 23:28:25', '2016-11-29 23:28:25'),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682, '2016-11-29 23:28:25', '2016-11-29 23:28:25'),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506, '2016-11-29 23:28:25', '2016-11-29 23:28:25'),
(53, 'CI', 'COTE DIVOIRE', 'Cote DIvoire', 'CIV', 384, 225, '2016-11-29 23:28:25', '2016-11-29 23:28:25'),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385, '2016-11-29 23:28:25', '2016-11-29 23:28:25'),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53, '2016-11-29 23:28:25', '2016-11-29 23:28:25'),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357, '2016-11-29 23:28:25', '2016-11-29 23:28:25'),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420, '2016-11-29 23:28:25', '2016-11-29 23:28:25'),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45, '2016-11-29 23:28:25', '2016-11-29 23:28:25'),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253, '2016-11-29 23:28:25', '2016-11-29 23:28:25'),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767, '2016-11-29 23:28:26', '2016-11-29 23:28:26'),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809, '2016-11-29 23:28:26', '2016-11-29 23:28:26'),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593, '2016-11-29 23:28:26', '2016-11-29 23:28:26'),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20, '2016-11-29 23:28:26', '2016-11-29 23:28:26'),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503, '2016-11-29 23:28:26', '2016-11-29 23:28:26'),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240, '2016-11-29 23:28:26', '2016-11-29 23:28:26'),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291, '2016-11-29 23:28:26', '2016-11-29 23:28:26'),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372, '2016-11-29 23:28:26', '2016-11-29 23:28:26'),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251, '2016-11-29 23:28:26', '2016-11-29 23:28:26'),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500, '2016-11-29 23:28:26', '2016-11-29 23:28:26'),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298, '2016-11-29 23:28:27', '2016-11-29 23:28:27'),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679, '2016-11-29 23:28:27', '2016-11-29 23:28:27'),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358, '2016-11-29 23:28:27', '2016-11-29 23:28:27'),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33, '2016-11-29 23:28:27', '2016-11-29 23:28:27'),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594, '2016-11-29 23:28:27', '2016-11-29 23:28:27'),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689, '2016-11-29 23:28:27', '2016-11-29 23:28:27'),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', 'NUL', 0, 0, '2016-11-29 23:28:27', '2016-11-29 23:28:27'),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241, '2016-11-29 23:28:27', '2016-11-29 23:28:27'),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220, '2016-11-29 23:28:27', '2016-11-29 23:28:27'),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995, '2016-11-29 23:28:27', '2016-11-29 23:28:27'),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49, '2016-11-29 23:28:27', '2016-11-29 23:28:27'),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233, '2016-11-29 23:28:27', '2016-11-29 23:28:27'),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350, '2016-11-29 23:28:28', '2016-11-29 23:28:28'),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30, '2016-11-29 23:28:28', '2016-11-29 23:28:28'),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299, '2016-11-29 23:28:28', '2016-11-29 23:28:28'),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473, '2016-11-29 23:28:28', '2016-11-29 23:28:28'),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590, '2016-11-29 23:28:28', '2016-11-29 23:28:28'),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671, '2016-11-29 23:28:28', '2016-11-29 23:28:28'),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502, '2016-11-29 23:28:28', '2016-11-29 23:28:28'),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224, '2016-11-29 23:28:28', '2016-11-29 23:28:28'),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245, '2016-11-29 23:28:28', '2016-11-29 23:28:28'),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592, '2016-11-29 23:28:28', '2016-11-29 23:28:28'),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509, '2016-11-29 23:28:28', '2016-11-29 23:28:28'),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', 'NUL', 0, 0, '2016-11-29 23:28:29', '2016-11-29 23:28:29'),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39, '2016-11-29 23:28:29', '2016-11-29 23:28:29'),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504, '2016-11-29 23:28:29', '2016-11-29 23:28:29'),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852, '2016-11-29 23:28:29', '2016-11-29 23:28:29'),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36, '2016-11-29 23:28:29', '2016-11-29 23:28:29'),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354, '2016-11-29 23:28:29', '2016-11-29 23:28:29'),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91, '2016-11-29 23:28:29', '2016-11-29 23:28:29'),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62, '2016-11-29 23:28:29', '2016-11-29 23:28:29'),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98, '2016-11-29 23:28:29', '2016-11-29 23:28:29'),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964, '2016-11-29 23:28:30', '2016-11-29 23:28:30'),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353, '2016-11-29 23:28:30', '2016-11-29 23:28:30'),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972, '2016-11-29 23:28:30', '2016-11-29 23:28:30'),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39, '2016-11-29 23:28:30', '2016-11-29 23:28:30'),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876, '2016-11-29 23:28:30', '2016-11-29 23:28:30'),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81, '2016-11-29 23:28:30', '2016-11-29 23:28:30'),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962, '2016-11-29 23:28:30', '2016-11-29 23:28:30'),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7, '2016-11-29 23:28:30', '2016-11-29 23:28:30'),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254, '2016-11-29 23:28:30', '2016-11-29 23:28:30'),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686, '2016-11-29 23:28:30', '2016-11-29 23:28:30'),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLES REPUBLIC OF', 'Korea, Democratic Peoples Republic of', 'PRK', 408, 850, '2016-11-29 23:28:30', '2016-11-29 23:28:30'),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82, '2016-11-29 23:28:31', '2016-11-29 23:28:31'),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965, '2016-11-29 23:28:31', '2016-11-29 23:28:31'),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996, '2016-11-29 23:28:31', '2016-11-29 23:28:31'),
(116, 'LA', 'LAO PEOPLES DEMOCRATIC REPUBLIC', 'Lao Peoples Democratic Republic', 'LAO', 418, 856, '2016-11-29 23:28:31', '2016-11-29 23:28:31'),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371, '2016-11-29 23:28:31', '2016-11-29 23:28:31'),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961, '2016-11-29 23:28:31', '2016-11-29 23:28:31'),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266, '2016-11-29 23:28:31', '2016-11-29 23:28:31'),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231, '2016-11-29 23:28:31', '2016-11-29 23:28:31'),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218, '2016-11-29 23:28:31', '2016-11-29 23:28:31'),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423, '2016-11-29 23:28:31', '2016-11-29 23:28:31'),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370, '2016-11-29 23:28:31', '2016-11-29 23:28:31'),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352, '2016-11-29 23:28:32', '2016-11-29 23:28:32'),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853, '2016-11-29 23:28:32', '2016-11-29 23:28:32'),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389, '2016-11-29 23:28:32', '2016-11-29 23:28:32'),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261, '2016-11-29 23:28:32', '2016-11-29 23:28:32'),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265, '2016-11-29 23:28:32', '2016-11-29 23:28:32'),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60, '2016-11-29 23:28:32', '2016-11-29 23:28:32'),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960, '2016-11-29 23:28:32', '2016-11-29 23:28:32'),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223, '2016-11-29 23:28:32', '2016-11-29 23:28:32'),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356, '2016-11-29 23:28:32', '2016-11-29 23:28:32'),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692, '2016-11-29 23:28:32', '2016-11-29 23:28:32'),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596, '2016-11-29 23:28:32', '2016-11-29 23:28:32'),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222, '2016-11-29 23:28:32', '2016-11-29 23:28:32'),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230, '2016-11-29 23:28:33', '2016-11-29 23:28:33'),
(137, 'YT', 'MAYOTTE', 'Mayotte', 'NUL', 0, 269, '2016-11-29 23:28:33', '2016-11-29 23:28:33'),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52, '2016-11-29 23:28:33', '2016-11-29 23:28:33'),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691, '2016-11-29 23:28:33', '2016-11-29 23:28:33'),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373, '2016-11-29 23:28:33', '2016-11-29 23:28:33'),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377, '2016-11-29 23:28:33', '2016-11-29 23:28:33'),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976, '2016-11-29 23:28:33', '2016-11-29 23:28:33'),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664, '2016-11-29 23:28:33', '2016-11-29 23:28:33'),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212, '2016-11-29 23:28:33', '2016-11-29 23:28:33'),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258, '2016-11-29 23:28:33', '2016-11-29 23:28:33'),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95, '2016-11-29 23:28:33', '2016-11-29 23:28:33'),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264, '2016-11-29 23:28:34', '2016-11-29 23:28:34'),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674, '2016-11-29 23:28:34', '2016-11-29 23:28:34'),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977, '2016-11-29 23:28:34', '2016-11-29 23:28:34'),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31, '2016-11-29 23:28:34', '2016-11-29 23:28:34'),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599, '2016-11-29 23:28:34', '2016-11-29 23:28:34'),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687, '2016-11-29 23:28:34', '2016-11-29 23:28:34'),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64, '2016-11-29 23:28:34', '2016-11-29 23:28:34'),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505, '2016-11-29 23:28:34', '2016-11-29 23:28:34'),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227, '2016-11-29 23:28:34', '2016-11-29 23:28:34'),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234, '2016-11-29 23:28:35', '2016-11-29 23:28:35'),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683, '2016-11-29 23:28:35', '2016-11-29 23:28:35'),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672, '2016-11-29 23:28:35', '2016-11-29 23:28:35'),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670, '2016-11-29 23:28:35', '2016-11-29 23:28:35'),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47, '2016-11-29 23:28:35', '2016-11-29 23:28:35'),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968, '2016-11-29 23:28:35', '2016-11-29 23:28:35'),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92, '2016-11-29 23:28:35', '2016-11-29 23:28:35'),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680, '2016-11-29 23:28:35', '2016-11-29 23:28:35'),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', 'NUL', 0, 970, '2016-11-29 23:28:35', '2016-11-29 23:28:35'),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507, '2016-11-29 23:28:35', '2016-11-29 23:28:35'),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675, '2016-11-29 23:28:35', '2016-11-29 23:28:35'),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595, '2016-11-29 23:28:36', '2016-11-29 23:28:36'),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51, '2016-11-29 23:28:36', '2016-11-29 23:28:36'),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63, '2016-11-29 23:28:36', '2016-11-29 23:28:36'),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0, '2016-11-29 23:28:36', '2016-11-29 23:28:36'),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48, '2016-11-29 23:28:36', '2016-11-29 23:28:36'),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351, '2016-11-29 23:28:36', '2016-11-29 23:28:36'),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787, '2016-11-29 23:28:36', '2016-11-29 23:28:36'),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974, '2016-11-29 23:28:36', '2016-11-29 23:28:36'),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262, '2016-11-29 23:28:36', '2016-11-29 23:28:36'),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40, '2016-11-29 23:28:37', '2016-11-29 23:28:37'),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70, '2016-11-29 23:28:37', '2016-11-29 23:28:37'),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250, '2016-11-29 23:28:37', '2016-11-29 23:28:37'),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290, '2016-11-29 23:28:37', '2016-11-29 23:28:37'),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869, '2016-11-29 23:28:37', '2016-11-29 23:28:37'),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758, '2016-11-29 23:28:37', '2016-11-29 23:28:37'),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508, '2016-11-29 23:28:37', '2016-11-29 23:28:37'),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784, '2016-11-29 23:28:37', '2016-11-29 23:28:37'),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684, '2016-11-29 23:28:37', '2016-11-29 23:28:37'),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', 'NUL', 0, 381, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27, '2016-11-29 23:28:38', '2016-11-29 23:28:38'),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', 'NUL', 0, 0, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66, '2016-11-29 23:28:39', '2016-11-29 23:28:39'),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', 'NUL', 0, 670, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971, '2016-11-29 23:28:40', '2016-11-29 23:28:40'),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44, '2016-11-29 23:28:41', '2016-11-29 23:28:41'),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1, '2016-11-29 23:28:41', '2016-11-29 23:28:41'),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', 'NUL', 0, 1, '2016-11-29 23:28:41', '2016-11-29 23:28:41'),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598, '2016-11-29 23:28:41', '2016-11-29 23:28:41'),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998, '2016-11-29 23:28:41', '2016-11-29 23:28:41'),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678, '2016-11-29 23:28:41', '2016-11-29 23:28:41'),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58, '2016-11-29 23:28:41', '2016-11-29 23:28:41'),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84, '2016-11-29 23:28:41', '2016-11-29 23:28:41'),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284, '2016-11-29 23:28:41', '2016-11-29 23:28:41'),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340, '2016-11-29 23:28:41', '2016-11-29 23:28:41'),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681, '2016-11-29 23:28:41', '2016-11-29 23:28:41'),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212, '2016-11-29 23:28:41', '2016-11-29 23:28:41'),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967, '2016-11-29 23:28:42', '2016-11-29 23:28:42'),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260, '2016-11-29 23:28:42', '2016-11-29 23:28:42'),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263, '2016-11-29 23:28:42', '2016-11-29 23:28:42');

-- --------------------------------------------------------

--
-- Table structure for table `custom_forms`
--

CREATE TABLE IF NOT EXISTS `custom_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `formname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `custom_form_fields`
--

CREATE TABLE IF NOT EXISTS `custom_form_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `forms_id` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `required` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `date_format`
--

CREATE TABLE IF NOT EXISTS `date_format` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `date_format`
--

INSERT INTO `date_format` (`id`, `format`) VALUES
(1, 'dd/mm/yyyy'),
(2, 'dd-mm-yyyy'),
(3, 'dd.mm.yyyy'),
(4, 'mm/dd/yyyy'),
(5, 'mm:dd:yyyy'),
(6, 'mm-dd-yyyy'),
(7, 'yyyy/mm/dd'),
(8, 'yyyy.mm.dd'),
(9, 'yyyy-mm-dd');

-- --------------------------------------------------------

--
-- Table structure for table `date_time_format`
--

CREATE TABLE IF NOT EXISTS `date_time_format` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `date_time_format`
--

INSERT INTO `date_time_format` (`id`, `format`) VALUES
(1, 'd/m/Y H:i:s'),
(2, 'd.m.Y H:i:s'),
(3, 'd-m-Y H:i:s'),
(4, 'm/d/Y H:i:s'),
(5, 'm.d.Y H:i:s'),
(6, 'm-d-Y H:i:s'),
(7, 'Y/m/d H:i:s'),
(8, 'Y.m.d H:i:s'),
(9, 'Y-m-d H:i:s');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sla` int(10) unsigned DEFAULT NULL,
  `manager` int(10) unsigned DEFAULT NULL,
  `ticket_assignment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `outgoing_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_set` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auto_ticket_response` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auto_message_response` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auto_response_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `recipient` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_access` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department_sign` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sla` (`sla`),
  KEY `manager_2` (`manager`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `type`, `sla`, `manager`, `ticket_assignment`, `outgoing_email`, `template_set`, `auto_ticket_response`, `auto_message_response`, `auto_response_email`, `recipient`, `group_access`, `department_sign`, `created_at`, `updated_at`) VALUES
(1, 'Support', '1', 1, NULL, '', '', '', '', '', '', '', '', '', '2016-11-29 23:28:15', '2016-11-29 23:28:15'),
(2, 'Sales', '1', 1, NULL, '', '', '', '', '', '', '', '', '', '2016-11-29 23:28:15', '2016-11-29 23:28:15'),
(3, 'Operation', '1', 1, NULL, '', '', '', '', '', '', '', '', '', '2016-11-29 23:28:15', '2016-11-29 23:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department` int(10) unsigned DEFAULT NULL,
  `priority` int(10) unsigned DEFAULT NULL,
  `help_topic` int(10) unsigned DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fetching_host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fetching_port` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fetching_protocol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fetching_encryption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mailbox_protocol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `imap_config` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `folder` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sending_host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sending_port` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sending_protocol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sending_encryption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_validate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_authentication` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auto_response` tinyint(1) NOT NULL,
  `fetching_status` tinyint(1) NOT NULL,
  `move_to_folder` tinyint(1) NOT NULL,
  `delete_email` tinyint(1) NOT NULL,
  `do_nothing` tinyint(1) NOT NULL,
  `sending_status` tinyint(1) NOT NULL,
  `authentication` tinyint(1) NOT NULL,
  `header_spoofing` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department` (`department`,`priority`,`help_topic`),
  KEY `department_2` (`department`,`priority`,`help_topic`),
  KEY `priority` (`priority`),
  KEY `help_topic` (`help_topic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faveo_mails`
--

CREATE TABLE IF NOT EXISTS `faveo_mails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_id` int(11) NOT NULL,
  `drive` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faveo_queues`
--

CREATE TABLE IF NOT EXISTS `faveo_queues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `field_values`
--

CREATE TABLE IF NOT EXISTS `field_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(10) unsigned DEFAULT NULL,
  `child_id` int(10) unsigned DEFAULT NULL,
  `field_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `field_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_values_field_id_foreign` (`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `followup`
--

CREATE TABLE IF NOT EXISTS `followup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `condition` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `followup`
--

INSERT INTO `followup` (`id`, `name`, `status`, `condition`, `created_at`, `updated_at`) VALUES
(1, 'followup', '', '', '2016-11-29 23:28:11', '2016-11-29 23:28:11');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_status` tinyint(1) NOT NULL,
  `can_create_ticket` tinyint(1) NOT NULL,
  `can_edit_ticket` tinyint(1) NOT NULL,
  `can_post_ticket` tinyint(1) NOT NULL,
  `can_close_ticket` tinyint(1) NOT NULL,
  `can_assign_ticket` tinyint(1) NOT NULL,
  `can_transfer_ticket` tinyint(1) NOT NULL,
  `can_delete_ticket` tinyint(1) NOT NULL,
  `can_ban_email` tinyint(1) NOT NULL,
  `can_manage_canned` tinyint(1) NOT NULL,
  `can_manage_faq` tinyint(1) NOT NULL,
  `can_view_agent_stats` tinyint(1) NOT NULL,
  `department_access` tinyint(1) NOT NULL,
  `admin_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `group_status`, `can_create_ticket`, `can_edit_ticket`, `can_post_ticket`, `can_close_ticket`, `can_assign_ticket`, `can_transfer_ticket`, `can_delete_ticket`, `can_ban_email`, `can_manage_canned`, `can_manage_faq`, `can_view_agent_stats`, `department_access`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 'Group A', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, '', '2016-11-29 23:28:14', '2016-11-29 23:28:14'),
(2, 'Group B', 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, '', '2016-11-29 23:28:14', '2016-11-29 23:28:14'),
(3, 'Group C', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '2016-11-29 23:28:14', '2016-11-29 23:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `group_assign_department`
--

CREATE TABLE IF NOT EXISTS `group_assign_department` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `department_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `help_topic`
--

CREATE TABLE IF NOT EXISTS `help_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_topic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_form` int(10) unsigned DEFAULT NULL,
  `department` int(10) unsigned DEFAULT NULL,
  `ticket_status` int(10) unsigned DEFAULT NULL,
  `priority` int(10) unsigned DEFAULT NULL,
  `sla_plan` int(10) unsigned DEFAULT NULL,
  `thank_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ticket_num_format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `auto_assign` int(10) unsigned DEFAULT NULL,
  `auto_response` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `custom_form` (`custom_form`),
  KEY `department` (`department`),
  KEY `ticket_status` (`ticket_status`),
  KEY `priority` (`priority`),
  KEY `sla_plan` (`sla_plan`),
  KEY `auto_assign_2` (`auto_assign`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `help_topic`
--

INSERT INTO `help_topic` (`id`, `topic`, `parent_topic`, `custom_form`, `department`, `ticket_status`, `priority`, `sla_plan`, `thank_page`, `ticket_num_format`, `internal_notes`, `status`, `type`, `auto_assign`, `auto_response`, `created_at`, `updated_at`) VALUES
(1, 'Support query', '', NULL, 1, 1, 2, 1, '', '1', '', 1, 1, NULL, 0, '2016-11-29 23:28:15', '2016-11-29 23:28:15'),
(2, 'Sales query', '', NULL, 2, 1, 2, 1, '', '1', '', 1, 1, NULL, 0, '2016-11-29 23:28:16', '2016-11-29 23:45:44'),
(3, 'Operational query', '', NULL, 3, 1, 2, 1, '', '1', '', 1, 1, NULL, 0, '2016-11-29 23:28:16', '2016-11-29 23:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_reserved_at_index` (`queue`,`reserved`,`reserved_at`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"name\\";s:6:\\"Jalafa\\";s:5:\\"email\\";s:16:\\"jalafa@gmail.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:2:{s:7:\\"subject\\";N;s:8:\\"scenario\\";s:25:\\"registration-notification\\";}s:11:\\"\\u0000*\\u0000template\\";a:3:{s:4:\\"user\\";s:6:\\"Jalafa\\";s:13:\\"email_address\\";s:16:\\"jalafa@gmail.com\\";s:13:\\"user_password\\";s:10:\\"iX4WvMClk6\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480482454, 1480482454),
(2, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"name\\";s:6:\\"Cladia\\";s:5:\\"email\\";s:16:\\"cladia@yahoo.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:2:{s:7:\\"subject\\";N;s:8:\\"scenario\\";s:25:\\"registration-notification\\";}s:11:\\"\\u0000*\\u0000template\\";a:3:{s:4:\\"user\\";s:6:\\"Cladia\\";s:13:\\"email_address\\";s:16:\\"cladia@yahoo.com\\";s:13:\\"user_password\\";s:10:\\"jRHwRQ69u7\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480482592, 1480482592),
(3, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"name\\";s:4:\\"John\\";s:5:\\"email\\";s:14:\\"john@gmail.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:2:{s:7:\\"subject\\";N;s:8:\\"scenario\\";s:25:\\"registration-notification\\";}s:11:\\"\\u0000*\\u0000template\\";a:3:{s:4:\\"user\\";s:4:\\"John\\";s:13:\\"email_address\\";s:14:\\"john@gmail.com\\";s:13:\\"user_password\\";s:10:\\"vyU3nQltGB\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480482782, 1480482782),
(4, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"name\\";s:7:\\"Baladin\\";s:5:\\"email\\";s:18:\\"baladdin@gmail.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:2:{s:7:\\"subject\\";N;s:8:\\"scenario\\";s:25:\\"registration-notification\\";}s:11:\\"\\u0000*\\u0000template\\";a:3:{s:4:\\"user\\";s:7:\\"Baladin\\";s:13:\\"email_address\\";s:18:\\"baladdin@gmail.com\\";s:13:\\"user_password\\";s:10:\\"vITVCEYppB\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480482908, 1480482908),
(5, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"name\\";s:6:\\"Jalafa\\";s:5:\\"email\\";s:16:\\"jalafa@gmail.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:3:{s:7:\\"subject\\";s:32:\\"Sizing defects [#AAAA-0000-0000]\\";s:8:\\"scenario\\";s:22:\\"create-ticket-by-agent\\";s:4:\\"body\\";s:27:\\"Please check size of shirt.\\";}s:11:\\"\\u0000*\\u0000template\\";a:2:{s:10:\\"agent_sign\\";s:0:\\"\\";s:13:\\"ticket_number\\";s:14:\\"AAAA-0000-0000\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480484761, 1480484761),
(6, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"user\\";s:9:\\"Demoadmin\\";s:5:\\"email\\";s:14:\\"demo@admin.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:3:{s:7:\\"subject\\";s:32:\\"Sizing defects [#AAAA-0000-0000]\\";s:4:\\"body\\";s:27:\\"Please check size of shirt.\\";s:8:\\"scenario\\";s:19:\\"create-ticket-agent\\";}s:11:\\"\\u0000*\\u0000template\\";a:7:{s:17:\\"ticket_agent_name\\";s:9:\\"Demoadmin\\";s:18:\\"ticket_client_name\\";s:6:\\"Jalafa\\";s:19:\\"ticket_client_email\\";s:16:\\"jalafa@gmail.com\\";s:4:\\"user\\";s:9:\\"Demoadmin\\";s:13:\\"ticket_number\\";s:14:\\"AAAA-0000-0000\\";s:13:\\"email_address\\";s:16:\\"jalafa@gmail.com\\";s:4:\\"name\\";s:11:\\"Jalafa%$%kk\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480484761, 1480484761),
(7, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"name\\";s:6:\\"Jalafa\\";s:5:\\"email\\";s:16:\\"jalafa@gmail.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:3:{s:7:\\"subject\\";s:31:\\"Colour effects[#AAAA-0000-0001]\\";s:8:\\"scenario\\";s:22:\\"create-ticket-by-agent\\";s:4:\\"body\\";s:75:\\"Hi team,<br><br>I m got wrong color please return my order.<br><br><br><br>\\";}s:11:\\"\\u0000*\\u0000template\\";a:2:{s:10:\\"agent_sign\\";s:0:\\"\\";s:13:\\"ticket_number\\";s:14:\\"AAAA-0000-0001\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480484849, 1480484849),
(8, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"user\\";s:9:\\"Demoadmin\\";s:5:\\"email\\";s:14:\\"demo@admin.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:3:{s:7:\\"subject\\";s:31:\\"Colour effects[#AAAA-0000-0001]\\";s:4:\\"body\\";s:75:\\"Hi team,<br><br>I m got wrong color please return my order.<br><br><br><br>\\";s:8:\\"scenario\\";s:19:\\"create-ticket-agent\\";}s:11:\\"\\u0000*\\u0000template\\";a:7:{s:17:\\"ticket_agent_name\\";s:9:\\"Demoadmin\\";s:18:\\"ticket_client_name\\";s:6:\\"Jalafa\\";s:19:\\"ticket_client_email\\";s:16:\\"jalafa@gmail.com\\";s:4:\\"user\\";s:9:\\"Demoadmin\\";s:13:\\"ticket_number\\";s:14:\\"AAAA-0000-0001\\";s:13:\\"email_address\\";s:16:\\"jalafa@gmail.com\\";s:4:\\"name\\";s:11:\\"Jalafa%$%kk\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480484849, 1480484849),
(9, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"name\\";s:6:\\"Cladia\\";s:5:\\"email\\";s:16:\\"cladia@yahoo.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:3:{s:7:\\"subject\\";s:31:\\"Sewing defects[#AAAA-0000-0002]\\";s:8:\\"scenario\\";s:22:\\"create-ticket-by-agent\\";s:4:\\"body\\";s:53:\\"this is defect cloths please check and send me again.\\";}s:11:\\"\\u0000*\\u0000template\\";a:2:{s:10:\\"agent_sign\\";s:0:\\"\\";s:13:\\"ticket_number\\";s:14:\\"AAAA-0000-0002\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480484955, 1480484955),
(10, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"user\\";s:9:\\"Demoadmin\\";s:5:\\"email\\";s:14:\\"demo@admin.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:3:{s:7:\\"subject\\";s:31:\\"Sewing defects[#AAAA-0000-0002]\\";s:4:\\"body\\";s:53:\\"this is defect cloths please check and send me again.\\";s:8:\\"scenario\\";s:19:\\"create-ticket-agent\\";}s:11:\\"\\u0000*\\u0000template\\";a:7:{s:17:\\"ticket_agent_name\\";s:9:\\"Demoadmin\\";s:18:\\"ticket_client_name\\";s:6:\\"Cladia\\";s:19:\\"ticket_client_email\\";s:16:\\"cladia@yahoo.com\\";s:4:\\"user\\";s:9:\\"Demoadmin\\";s:13:\\"ticket_number\\";s:14:\\"AAAA-0000-0002\\";s:13:\\"email_address\\";s:16:\\"cladia@yahoo.com\\";s:4:\\"name\\";s:14:\\"Cladia%$%Singh\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480484956, 1480484956),
(11, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"name\\";s:6:\\"Cladia\\";s:5:\\"email\\";s:16:\\"cladia@yahoo.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:3:{s:7:\\"subject\\";s:32:\\"Garment defects[#AAAA-0000-0003]\\";s:8:\\"scenario\\";s:22:\\"create-ticket-by-agent\\";s:4:\\"body\\";s:103:\\"Hi team,<br><br>I want to return my cash because i m not satisfy with sale.<br><br><br><br><br><br><br>\\";}s:11:\\"\\u0000*\\u0000template\\";a:2:{s:10:\\"agent_sign\\";s:0:\\"\\";s:13:\\"ticket_number\\";s:14:\\"AAAA-0000-0003\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480485154, 1480485154),
(12, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"user\\";s:9:\\"Demoadmin\\";s:5:\\"email\\";s:14:\\"demo@admin.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:3:{s:7:\\"subject\\";s:32:\\"Garment defects[#AAAA-0000-0003]\\";s:4:\\"body\\";s:103:\\"Hi team,<br><br>I want to return my cash because i m not satisfy with sale.<br><br><br><br><br><br><br>\\";s:8:\\"scenario\\";s:19:\\"create-ticket-agent\\";}s:11:\\"\\u0000*\\u0000template\\";a:7:{s:17:\\"ticket_agent_name\\";s:9:\\"Demoadmin\\";s:18:\\"ticket_client_name\\";s:6:\\"Cladia\\";s:19:\\"ticket_client_email\\";s:16:\\"cladia@yahoo.com\\";s:4:\\"user\\";s:9:\\"Demoadmin\\";s:13:\\"ticket_number\\";s:14:\\"AAAA-0000-0003\\";s:13:\\"email_address\\";s:16:\\"cladia@yahoo.com\\";s:4:\\"name\\";s:14:\\"Cladia%$%Singh\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480485154, 1480485154),
(13, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"name\\";s:6:\\"Cladia\\";s:5:\\"email\\";s:16:\\"cladia@yahoo.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:3:{s:7:\\"subject\\";s:31:\\"Return my cash[#AAAA-0000-0004]\\";s:8:\\"scenario\\";s:22:\\"create-ticket-by-agent\\";s:4:\\"body\\";s:74:\\"Hi Team,<br><br>I got damage cloth please return my cash ASAP.<br><br><br>\\";}s:11:\\"\\u0000*\\u0000template\\";a:2:{s:10:\\"agent_sign\\";s:0:\\"\\";s:13:\\"ticket_number\\";s:14:\\"AAAA-0000-0004\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480485306, 1480485306),
(14, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"user\\";s:9:\\"Demoadmin\\";s:5:\\"email\\";s:14:\\"demo@admin.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:3:{s:7:\\"subject\\";s:31:\\"Return my cash[#AAAA-0000-0004]\\";s:4:\\"body\\";s:74:\\"Hi Team,<br><br>I got damage cloth please return my cash ASAP.<br><br><br>\\";s:8:\\"scenario\\";s:19:\\"create-ticket-agent\\";}s:11:\\"\\u0000*\\u0000template\\";a:7:{s:17:\\"ticket_agent_name\\";s:9:\\"Demoadmin\\";s:18:\\"ticket_client_name\\";s:6:\\"Cladia\\";s:19:\\"ticket_client_email\\";s:16:\\"cladia@yahoo.com\\";s:4:\\"user\\";s:9:\\"Demoadmin\\";s:13:\\"ticket_number\\";s:14:\\"AAAA-0000-0004\\";s:13:\\"email_address\\";s:16:\\"cladia@yahoo.com\\";s:4:\\"name\\";s:14:\\"Cladia%$%Singh\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480485306, 1480485306),
(15, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:3:{s:4:\\"name\\";s:6:\\"Cladia\\";s:5:\\"email\\";s:16:\\"cladia@yahoo.com\\";s:2:\\"cc\\";O:39:\\"Illuminate\\\\Database\\\\Eloquent\\\\Collection\\":1:{s:8:\\"\\u0000*\\u0000items\\";a:0:{}}}s:10:\\"\\u0000*\\u0000message\\";a:4:{s:7:\\"subject\\";s:32:\\"Garment defects[#AAAA-0000-0003]\\";s:4:\\"body\\";s:71:\\"Hi cladia,<br><br>As soon as possible we will return your cash.<br><br>\\";s:8:\\"scenario\\";s:12:\\"ticket-reply\\";s:11:\\"attachments\\";N;}s:11:\\"\\u0000*\\u0000template\\";a:3:{s:13:\\"ticket_number\\";s:14:\\"AAAA-0000-0003\\";s:4:\\"user\\";s:6:\\"Cladia\\";s:10:\\"agent_sign\\";N;}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480485503, 1480485503),
(16, 'default', '{"job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","data":{"commandName":"App\\\\Jobs\\\\SendEmail","command":"O:18:\\"App\\\\Jobs\\\\SendEmail\\":8:{s:7:\\"\\u0000*\\u0000from\\";N;s:5:\\"\\u0000*\\u0000to\\";a:2:{s:4:\\"name\\";s:4:\\"John\\";s:5:\\"email\\";s:14:\\"john@gmail.com\\";}s:10:\\"\\u0000*\\u0000message\\";a:2:{s:7:\\"subject\\";s:32:\\"Sizing defects [#AAAA-0000-0000]\\";s:8:\\"scenario\\";s:13:\\"assign-ticket\\";}s:11:\\"\\u0000*\\u0000template\\";a:3:{s:17:\\"ticket_agent_name\\";s:4:\\"John\\";s:13:\\"ticket_number\\";s:14:\\"AAAA-0000-0000\\";s:15:\\"ticket_assigner\\";s:15:\\"Demoadmin Faveo\\";}s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:5:\\"delay\\";N;s:6:\\"\\u0000*\\u0000job\\";N;}"}}', 0, 0, NULL, 1480485541, 1480485541);

-- --------------------------------------------------------

--
-- Table structure for table `kb_article`
--

CREATE TABLE IF NOT EXISTS `kb_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `publish_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `kb_article`
--

INSERT INTO `kb_article` (`id`, `name`, `slug`, `description`, `status`, `type`, `publish_time`, `created_at`, `updated_at`) VALUES
(1, 'DISCLAIMERS', 'disclaimers', '<p>ABC clothing.com does not promise that the site will be inoffensive, error-free or uninterrupted, or that it will provide specific information from use of the site or any content, search, or link on it. The site and its content are delivered on an “as-is” and “as-available” basis. ABC clothing.com cannot ensure that files you download from the site will be free of viruses or contamination or destructive features.</p>\r\n\r\n<p>Thebclothing.com disclaims all warranties, express or implied, including any implied warranties of merchantability and fitness for a particular purpose. ABC clothing.com will not be liable for any damages of any kind arising from the use of this site, including, without limitation, direct, indirect, incidental, and punitive and consequential damages.</p>\r\n\r\n<p>ABC clothing.com disclaims any and all liability for the acts, omissions, and conduct of any third-party users, ABC clothing.com users, advertisers, and/or sponsors on the Site, in connection with the Site, or other-wise related to your use of the Site. ABC clothing.com is not responsible for the products, services, actions, or failure to act of any third party in connection with or referenced on the Site. Without limiting the fore-going, you may report the misconduct of users and/or third-party advertisers or service and/or product providers referenced on or included in the Site to ABC clothing.com at Support@abcclothing.com</p>\r\n\r\n<p>ABC clothing.com may investigate the claim and take appropriate action, at its sole discretion.</p>\r\n\r\n<p>For any query kindly drop mail us on  Support@abcclothing.com.</p>\r\n', 1, 1, '2016-11-30 05:32:00', '2016-11-30 00:03:45', '2016-11-30 00:03:45'),
(2, 'CUSTOM ORDER', 'custom-order', '<p>You saw, you liked but couldn’t see your size? We will custom make it for you.</p>\r\n\r\n<p><strong>How it works:</strong></p>\r\n\r\n<ol><li>You liked something and want to modify a little or have something else on mind, do pen it down and share it with us on Support@abcclothing.com</li>\r\n  <li>We’ll work out the price depending on how detailed or intricate you want your garment.</li>\r\n <li>An advance would be required for any customized orders.</li>\r\n  <li>Once you’ve placed a deposit, we’ll make you a sketch of the garment.</li>\r\n  <li>We can complete your order in 15-20 days depending on the workload.</li>\r\n  <li>We will also share some updates on the garment in case something needs to be changed.</li>\r\n  <li>We finally ship it to your given address.</li>\r\n</ol><p><strong>Note:</strong> No returns and refunds.</p>\r\n', 1, 1, '2016-11-30 05:34:00', '2016-11-30 00:04:57', '2016-11-30 00:04:57'),
(3, 'TROUSER SKIRTS', 'trouser-skirts', '<p>Paris takes its fashion very, very seriously. So seriously, in fact, that wearing the wrong thing has actually caused a riot.</p>\r\n\r\n<p>In 1911, two rival Parisian couture houses launched their "trouser skirts," an innovation in fashion that trod the very fixed line between the genders and seemed to promise greater flexibility for women in general. There were two different versions of the trouser skirt: One was a sort of baggy pant with a very low hanging crotch, described as "a sack with holes made for the legs to go through," not unlike the fashions on high streets today, and the other a pair of the same kind of pants topped with an over-skirt, again, not unlike high street fashions of today. Both versions were launched by models at the opening day of racing season to general revulsion and disgust, but thankfully, no violence.</p>\r\n\r\n<p>It wasn''t until the ladies attempted to promenade their future fashions on the boulevards that the fisticuffs started—at the Place de l''Opera, the poor models were attacked by a jeering mob of fashion Philistines, who pulled their hair, trampled their hats, and reduced them to tears. A squad of police officers on bicycles were dispatched to rescue the girls and escort them to safety.</p>\r\n', 1, 1, '2016-11-30 05:35:00', '2016-11-30 00:05:53', '2016-11-30 00:05:53'),
(4, 'SECURE SHOPPING GUARANTEE', 'secure-shopping-guarantee', '<p>We accept all major Indian and International Credit/ Debit Cards, and Net Banking with over 40 Banks.</p>\r\n\r\n<p>NO Cash on Delivery (as random people order and share false addresses for fun)</p>\r\n\r\n<p>Yes, shopping at our e-store is 100% safe. All payment requests are directed to the secured PayU Payment Gateway. This gives you the highest level of protection possible whenever you use credit cards or make other financial or confidential transactions over the Internet.</p>\r\n\r\n<p>You can be assured that our e-store offers you the highest standards of security currently available on the net so as to ensure that your shopping experience is private, safe and secure.</p>\r\n', 1, 1, '2016-11-30 05:36:00', '2016-11-30 00:06:39', '2016-11-30 00:06:39'),
(5, 'PRIVACY POLICY', 'privacy-policy', '<p>The ABC Clothing collects your basic information to service your requests. This basic information is gathered when you purchase products/Gift card vouchers or when you sign up for e-mail notifications. Information gathered from you includes your name, mailing address, e-mail and phone number. Only when you place an order, your card information is requested and is submitted via the highest level of encryption to make sure of the greatest amount of safety and security. Reason why we gather this information:</p>\r\n\r\n<p><strong>To process your order</strong>.<br />\r\nShipping and Customer Service.<br />\r\nWe also use the information to upgrade our products, customer services, website content and navigation.</p>\r\n\r\n<p><br /><strong>Internal Record Keeping</strong>.<br />\r\nWe at The ABC Clothing respect that you do not want your personal information shared with other companies. The information you provide shall, therefore, be only used to process your order and customer support. The ABC Clothing does not share, sell or rent customer information to any other company.</p>\r\n', 1, 1, '2016-11-30 05:36:00', '2016-11-30 00:07:18', '2016-11-30 00:07:18'),
(6, ' SHIPPING POLICY', 'shipping-policy', '<p>We ship worldwide. We use FedEx/DTDC for shipping.</p>\r\n\r\n<p>Standard Shipping is usually 3-7 Working days for orders within India and 12-15 Working days for International Orders, but usually faster. IF your order doesn’t reach you in time, you may write to us at support@abcclothing.com</p>\r\n\r\n<p><strong>International Orders</strong></p>\r\n\r\n<p>For international orders, please note, your shipping will be calculated at the time of Check out only, this is a System Generated amount, based on your Zip Code, Region and Order Weight. (Approx Costs Rs.1250-1500 for 500 gms – International Shipment, subject to region)</p>\r\n\r\n<p><strong>Tracking</strong></p>\r\n\r\n<p>For tracking your order go to the following website, it will require your tracking ID which is sent via mail in your invoice.</p>\r\n', 1, 1, '2016-11-30 05:37:00', '2016-11-30 00:08:01', '2016-11-30 00:08:01'),
(7, 'RETURN & CANCELLATION', 'return-cancellation', '<p>Size doesn’t fit you or the Apparel/ Product is damaged/ defective can be returned in its original packing within 7 days of delivery. Once we have verified the damage, defect and/or error, you shall receive a replacement or a full refund for the Product in the original means of payment.</p>\r\n\r\n<p><br />\r\nThe B Clothing reserves the right to refuse a payment on a return of product purchased from www.thebclothing.com if the product is not received in its original condition, or is received damaged or has been used. All products to be returned must be notified to The B Clothing within 7 Days of receipt of your order..</p>\r\n\r\n<p><br />\r\nIn case of International shipments, customers may return any products that they have a size issue with if they are willing to bear the shipping costs. In case of damaged or defective products, International customers would need to send images of the product in its original packaging to support@abcclothing.com to claim a refund. Also, for damages and defects, the customer must notify ABC Clothing within 2 days of receiving the product.</p>\r\n\r\n<p><br />\r\nIn case of any returns that are approved, the purchase amount will be refunded to the customer within 15 business days upon receipt of return package, deducting any applicable return-processing fee.</p>\r\n\r\n<p><br />\r\nThe following mode of refund payments will be used:<br />\r\n• If online payment, then amount will be refunded online.</p>\r\n\r\n<p><br />\r\nAny requests for cancellation of orders placed should be made immediately by contacting support@abc clothing.com. If the order has been processed or shipped, the applicable order cancellation charges will be applied.</p>\r\n\r\n<p> </p>\r\n', 1, 1, '2016-11-30 05:38:00', '2016-11-30 00:08:41', '2016-11-30 00:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `kb_article_relationship`
--

CREATE TABLE IF NOT EXISTS `kb_article_relationship` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_relationship_article_id_foreign` (`article_id`),
  KEY `article_relationship_category_id_foreign` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `kb_article_relationship`
--

INSERT INTO `kb_article_relationship` (`id`, `article_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 5, 2, NULL, NULL),
(6, 6, 2, NULL, NULL),
(7, 7, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kb_category`
--

CREATE TABLE IF NOT EXISTS `kb_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `parent` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `kb_category`
--

INSERT INTO `kb_category` (`id`, `name`, `slug`, `description`, `status`, `parent`, `created_at`, `updated_at`) VALUES
(1, 'Issue Handeling', 'issue-handeling', 'These are the list of error handling issue.', 1, 0, '2016-11-30 00:00:34', '2016-11-30 00:00:34'),
(2, 'Policy', 'policy', 'These are the policies defined by this organization.', 1, 0, '2016-11-30 00:01:29', '2016-11-30 00:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `kb_comment`
--

CREATE TABLE IF NOT EXISTS `kb_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_article_id_foreign` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kb_pages`
--

CREATE TABLE IF NOT EXISTS `kb_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `visibility` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kb_settings`
--

CREATE TABLE IF NOT EXISTS `kb_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pagination` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kb_settings`
--

INSERT INTO `kb_settings` (`id`, `pagination`, `created_at`, `updated_at`) VALUES
(1, 10, '2016-11-29 23:28:20', '2016-11-29 23:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `locale`) VALUES
(1, 'English', 'en'),
(2, 'Italian', 'it'),
(3, 'German', 'de'),
(4, 'French', 'fr'),
(5, 'Brazilian Portuguese', 'pt_BR'),
(6, 'Dutch', 'nl'),
(7, 'Spanish', 'es'),
(8, 'Norwegian', 'nb_NO'),
(9, 'Danish', 'da');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `User` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `IP` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Attempts` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LastLogin` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `User`, `IP`, `Attempts`, `LastLogin`, `created_at`, `updated_at`) VALUES
(1, 'demo@admin.com', '::1', '2', '2016-11-30 05:56:00', '2016-11-29 23:28:47', '2016-11-29 23:28:47');

-- --------------------------------------------------------

--
-- Table structure for table `log_notification`
--

CREATE TABLE IF NOT EXISTS `log_notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `log_notification`
--

INSERT INTO `log_notification` (`id`, `log`, `created_at`, `updated_at`) VALUES
(1, 'NOT-1', '2016-11-29 23:28:16', '2016-11-29 23:28:16');

-- --------------------------------------------------------

--
-- Table structure for table `mailbox_protocol`
--

CREATE TABLE IF NOT EXISTS `mailbox_protocol` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mailbox_protocol`
--

INSERT INTO `mailbox_protocol` (`id`, `name`, `value`) VALUES
(1, 'IMAP', '/imap'),
(2, 'IMAP+SSL', '/imap/ssl'),
(3, 'IMAP+TLS', '/imap/tls'),
(4, 'IMAP+SSL/No-validate', '/imap/ssl/novalidate-cert');

-- --------------------------------------------------------

--
-- Table structure for table `mail_services`
--

CREATE TABLE IF NOT EXISTS `mail_services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `mail_services`
--

INSERT INTO `mail_services` (`id`, `name`, `short_name`, `created_at`, `updated_at`) VALUES
(1, 'SMTP', 'smtp', '2016-11-29 23:27:50', '2016-11-29 23:27:50'),
(2, 'Php Mail', 'mail', '2016-11-29 23:27:50', '2016-11-29 23:27:50'),
(3, 'Send Mail', 'sendmail', '2016-11-29 23:27:50', '2016-11-29 23:27:50'),
(4, 'Mailgun', 'mailgun', '2016-11-29 23:27:50', '2016-11-29 23:27:50'),
(5, 'Mandrill', 'mandrill', '2016-11-29 23:27:50', '2016-11-29 23:27:50'),
(6, 'Log file', 'log', '2016-11-29 23:27:50', '2016-11-29 23:27:50');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2016_02_16_140450_create_banlist_table', 1),
('2016_02_16_140450_create_canned_response_table', 1),
('2016_02_16_140450_create_custom_form_fields_table', 1),
('2016_02_16_140450_create_custom_forms_table', 1),
('2016_02_16_140450_create_date_format_table', 1),
('2016_02_16_140450_create_date_time_format_table', 1),
('2016_02_16_140450_create_department_table', 1),
('2016_02_16_140450_create_emails_table', 1),
('2016_02_16_140450_create_group_assign_department_table', 1),
('2016_02_16_140450_create_groups_table', 1),
('2016_02_16_140450_create_help_topic_table', 1),
('2016_02_16_140450_create_kb_article_relationship_table', 1),
('2016_02_16_140450_create_kb_article_table', 1),
('2016_02_16_140450_create_kb_category_table', 1),
('2016_02_16_140450_create_kb_comment_table', 1),
('2016_02_16_140450_create_kb_pages_table', 1),
('2016_02_16_140450_create_kb_settings_table', 1),
('2016_02_16_140450_create_languages_table', 1),
('2016_02_16_140450_create_log_notification_table', 1),
('2016_02_16_140450_create_mailbox_protocol_table', 1),
('2016_02_16_140450_create_organization_table', 1),
('2016_02_16_140450_create_password_resets_table', 1),
('2016_02_16_140450_create_plugins_table', 1),
('2016_02_16_140450_create_settings_alert_notice_table', 1),
('2016_02_16_140450_create_settings_auto_response_table', 1),
('2016_02_16_140450_create_settings_company_table', 1),
('2016_02_16_140450_create_settings_email_table', 1),
('2016_02_16_140450_create_settings_ratings_table', 1),
('2016_02_16_140450_create_settings_system_table', 1),
('2016_02_16_140450_create_settings_ticket_table', 1),
('2016_02_16_140450_create_sla_plan_table', 1),
('2016_02_16_140450_create_team_assign_agent_table', 1),
('2016_02_16_140450_create_teams_table', 1),
('2016_02_16_140450_create_template_table', 1),
('2016_02_16_140450_create_ticket_attachment_table', 1),
('2016_02_16_140450_create_ticket_collaborator_table', 1),
('2016_02_16_140450_create_ticket_form_data_table', 1),
('2016_02_16_140450_create_ticket_priority_table', 1),
('2016_02_16_140450_create_ticket_source_table', 1),
('2016_02_16_140450_create_ticket_status_table', 1),
('2016_02_16_140450_create_ticket_thread_table', 1),
('2016_02_16_140450_create_tickets_table', 1),
('2016_02_16_140450_create_time_format_table', 1),
('2016_02_16_140450_create_timezone_table', 1),
('2016_02_16_140450_create_user_assign_organization_table', 1),
('2016_02_16_140450_create_users_table', 1),
('2016_02_16_140450_create_version_check_table', 1),
('2016_02_16_140450_create_widgets_table', 1),
('2016_02_16_140454_add_foreign_keys_to_canned_response_table', 1),
('2016_02_16_140454_add_foreign_keys_to_department_table', 1),
('2016_02_16_140454_add_foreign_keys_to_emails_table', 1),
('2016_02_16_140454_add_foreign_keys_to_group_assign_department_table', 1),
('2016_02_16_140454_add_foreign_keys_to_help_topic_table', 1),
('2016_02_16_140454_add_foreign_keys_to_kb_article_relationship_table', 1),
('2016_02_16_140454_add_foreign_keys_to_kb_comment_table', 1),
('2016_02_16_140454_add_foreign_keys_to_organization_table', 1),
('2016_02_16_140454_add_foreign_keys_to_settings_system_table', 1),
('2016_02_16_140454_add_foreign_keys_to_team_assign_agent_table', 1),
('2016_02_16_140454_add_foreign_keys_to_teams_table', 1),
('2016_02_16_140454_add_foreign_keys_to_ticket_attachment_table', 1),
('2016_02_16_140454_add_foreign_keys_to_ticket_collaborator_table', 1),
('2016_02_16_140454_add_foreign_keys_to_ticket_form_data_table', 1),
('2016_02_16_140454_add_foreign_keys_to_ticket_thread_table', 1),
('2016_02_16_140454_add_foreign_keys_to_tickets_table', 1),
('2016_02_16_140454_add_foreign_keys_to_user_assign_organization_table', 1),
('2016_02_16_140454_add_foreign_keys_to_users_table', 1),
('2016_03_31_061239_create_notifications_table', 1),
('2016_03_31_061534_create_notification_types_table', 1),
('2016_03_31_061740_create_user_notification_table', 1),
('2016_04_18_115852_create_workflow_name_table', 1),
('2016_04_18_115900_create_workflow_rule_table', 1),
('2016_04_18_115908_create_workflow_action_table', 1),
('2016_05_10_102423_create_country_code_table', 1),
('2016_05_10_102604_create_bar_notifications_table', 1),
('2016_05_11_105244_create_api_settings_table', 1),
('2016_05_19_055008_create_workflow_close_table', 1),
('2016_06_02_072210_create_common_settings_table', 1),
('2016_06_02_074913_create_login_attempts_table', 1),
('2016_06_02_080005_create_ratings_table', 1),
('2016_06_02_081020_create_rating_ref_table', 1),
('2016_06_02_090225_create_settings_security_table', 1),
('2016_06_02_090628_create_templates_table', 1),
('2016_06_02_094409_create_template_sets_table', 1),
('2016_06_02_094420_create_template_types_table', 1),
('2016_06_02_095357_create_ticket_token_table', 1),
('2016_06_28_141613_version1079table', 1),
('2016_07_02_051247_create_jobs_table', 1),
('2016_07_02_051439_create_failed_jobs_table', 1),
('2016_07_19_071910_create_field_values_table', 1),
('2016_07_26_084458_create_faveo_mails_table', 1),
('2016_07_26_090201_create_faveo_queues_table', 1),
('2016_07_26_094753_create_mail_services_table', 1),
('2016_07_26_095020_create_queue_services_table', 1),
('2016_07_29_113012_create_conditions_table', 1),
('2016_08_08_095744_create_social_media_table', 1),
('2016_08_12_104410_create_user_additional_infos_table', 1),
('2016_08_16_104539_alter_ticket_source_table', 1),
('2016_08_31_223407_create_approval_table', 1),
('2016_09_02_165516_create_follow_up_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(11) NOT NULL,
  `userid_created` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `model_id`, `userid_created`, `type_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 3, '2016-11-30 00:16:00', '2016-11-30 00:16:00'),
(2, 2, 2, 3, '2016-11-30 00:17:29', '2016-11-30 00:17:29'),
(3, 3, 3, 3, '2016-11-30 00:19:15', '2016-11-30 00:19:15'),
(4, 4, 3, 3, '2016-11-30 00:22:34', '2016-11-30 00:22:34'),
(5, 5, 3, 3, '2016-11-30 00:25:06', '2016-11-30 00:25:06'),
(6, 4, 1, 2, '2016-11-30 00:28:23', '2016-11-30 00:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `notification_types`
--

CREATE TABLE IF NOT EXISTS `notification_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `notification_types`
--

INSERT INTO `notification_types` (`id`, `message`, `type`, `icon_class`, `created_at`, `updated_at`) VALUES
(1, 'A new user is registered', 'registration', 'fa fa-user', '2016-11-29 23:27:57', '2016-11-29 23:27:57'),
(2, 'You have a new reply on this ticket', 'reply', 'fa fa-envelope', '2016-11-29 23:27:58', '2016-11-29 23:27:58'),
(3, 'A new ticket has been created', 'new_ticket', 'fa fa-envelope', '2016-11-29 23:27:58', '2016-11-29 23:27:58');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE IF NOT EXISTS `organization` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `head` int(10) unsigned DEFAULT NULL,
  `internal_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `head` (`head`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `queue_services`
--

CREATE TABLE IF NOT EXISTS `queue_services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `queue_services`
--

INSERT INTO `queue_services` (`id`, `name`, `short_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Sync', 'sync', 0, '2016-11-29 23:27:51', '2016-11-29 23:27:51'),
(2, 'Database', 'database', 1, '2016-11-29 23:27:51', '2016-11-29 23:27:52'),
(3, 'Beanstalkd', 'beanstalkd', 0, '2016-11-29 23:27:52', '2016-11-29 23:27:52'),
(4, 'SQS', 'sqs', 0, '2016-11-29 23:27:52', '2016-11-29 23:27:52'),
(5, 'Iron', 'iron', 0, '2016-11-29 23:27:52', '2016-11-29 23:27:52'),
(6, 'Redis', 'redis', 0, '2016-11-29 23:27:52', '2016-11-29 23:27:52');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_order` int(11) NOT NULL,
  `allow_modification` int(11) NOT NULL,
  `rating_scale` int(11) NOT NULL,
  `rating_area` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restrict` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `name`, `display_order`, `allow_modification`, `rating_scale`, `rating_area`, `restrict`, `created_at`, `updated_at`) VALUES
(1, 'OverAll Satisfaction', 1, 1, 5, 'Helpdesk Area', '', '2016-11-29 23:28:46', '2016-11-29 23:28:46'),
(2, 'Reply Rating', 1, 1, 5, 'Comment Area', '', '2016-11-29 23:28:46', '2016-11-29 23:28:46');

-- --------------------------------------------------------

--
-- Table structure for table `rating_ref`
--

CREATE TABLE IF NOT EXISTS `rating_ref` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rating_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `rating_value` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings_alert_notice`
--

CREATE TABLE IF NOT EXISTS `settings_alert_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_status` tinyint(1) NOT NULL,
  `ticket_admin_email` tinyint(1) NOT NULL,
  `ticket_department_manager` tinyint(1) NOT NULL,
  `ticket_department_member` tinyint(1) NOT NULL,
  `ticket_organization_accmanager` tinyint(1) NOT NULL,
  `message_status` tinyint(1) NOT NULL,
  `message_last_responder` tinyint(1) NOT NULL,
  `message_assigned_agent` tinyint(1) NOT NULL,
  `message_department_manager` tinyint(1) NOT NULL,
  `message_organization_accmanager` tinyint(1) NOT NULL,
  `internal_status` tinyint(1) NOT NULL,
  `internal_last_responder` tinyint(1) NOT NULL,
  `internal_assigned_agent` tinyint(1) NOT NULL,
  `internal_department_manager` tinyint(1) NOT NULL,
  `assignment_status` tinyint(1) NOT NULL,
  `assignment_assigned_agent` tinyint(1) NOT NULL,
  `assignment_team_leader` tinyint(1) NOT NULL,
  `assignment_team_member` tinyint(1) NOT NULL,
  `transfer_status` tinyint(1) NOT NULL,
  `transfer_assigned_agent` tinyint(1) NOT NULL,
  `transfer_department_manager` tinyint(1) NOT NULL,
  `transfer_department_member` tinyint(1) NOT NULL,
  `overdue_status` tinyint(1) NOT NULL,
  `overdue_assigned_agent` tinyint(1) NOT NULL,
  `overdue_department_manager` tinyint(1) NOT NULL,
  `overdue_department_member` tinyint(1) NOT NULL,
  `system_error` tinyint(1) NOT NULL,
  `sql_error` tinyint(1) NOT NULL,
  `excessive_failure` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings_alert_notice`
--

INSERT INTO `settings_alert_notice` (`id`, `ticket_status`, `ticket_admin_email`, `ticket_department_manager`, `ticket_department_member`, `ticket_organization_accmanager`, `message_status`, `message_last_responder`, `message_assigned_agent`, `message_department_manager`, `message_organization_accmanager`, `internal_status`, `internal_last_responder`, `internal_assigned_agent`, `internal_department_manager`, `assignment_status`, `assignment_assigned_agent`, `assignment_team_leader`, `assignment_team_member`, `transfer_status`, `transfer_assigned_agent`, `transfer_department_manager`, `transfer_department_member`, `overdue_status`, `overdue_assigned_agent`, `overdue_department_manager`, `overdue_department_member`, `system_error`, `sql_error`, `excessive_failure`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-11-29 23:28:16', '2016-11-29 23:28:16');

-- --------------------------------------------------------

--
-- Table structure for table `settings_auto_response`
--

CREATE TABLE IF NOT EXISTS `settings_auto_response` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `new_ticket` tinyint(1) NOT NULL,
  `agent_new_ticket` tinyint(1) NOT NULL,
  `submitter` tinyint(1) NOT NULL,
  `participants` tinyint(1) NOT NULL,
  `overlimit` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings_auto_response`
--

INSERT INTO `settings_auto_response` (`id`, `new_ticket`, `agent_new_ticket`, `submitter`, `participants`, `overlimit`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 0, 0, '2016-11-29 23:28:16', '2016-11-29 23:28:16');

-- --------------------------------------------------------

--
-- Table structure for table `settings_company`
--

CREATE TABLE IF NOT EXISTS `settings_company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `landing_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `offline_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thank_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `use_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings_company`
--

INSERT INTO `settings_company` (`id`, `company_name`, `website`, `phone`, `address`, `landing_page`, `offline_page`, `thank_page`, `logo`, `use_logo`, `created_at`, `updated_at`) VALUES
(1, 'ABC cloth Company', '', '', '', '', '', '', '2530.logo.png', '0', '2016-11-29 23:28:16', '2016-11-30 00:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `settings_email`
--

CREATE TABLE IF NOT EXISTS `settings_email` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sys_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alert_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_fetching` tinyint(1) NOT NULL,
  `notification_cron` tinyint(1) NOT NULL,
  `strip` tinyint(1) NOT NULL,
  `separator` tinyint(1) NOT NULL,
  `all_emails` tinyint(1) NOT NULL,
  `email_collaborator` tinyint(1) NOT NULL,
  `attachment` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings_email`
--

INSERT INTO `settings_email` (`id`, `template`, `sys_email`, `alert_email`, `admin_email`, `mta`, `email_fetching`, `notification_cron`, `strip`, `separator`, `all_emails`, `email_collaborator`, `attachment`, `created_at`, `updated_at`) VALUES
(1, 'default', NULL, '', '', '', 1, 1, 0, 0, 1, 1, 1, '2016-11-29 23:28:16', '2016-11-29 23:28:16');

-- --------------------------------------------------------

--
-- Table structure for table `settings_ratings`
--

CREATE TABLE IF NOT EXISTS `settings_ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rating_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publish` int(11) NOT NULL,
  `modify` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_ratings_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings_security`
--

CREATE TABLE IF NOT EXISTS `settings_security` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lockout_message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `backlist_offender` int(11) NOT NULL,
  `backlist_threshold` int(11) NOT NULL,
  `lockout_period` int(11) NOT NULL,
  `days_to_keep_logs` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings_security`
--

INSERT INTO `settings_security` (`id`, `lockout_message`, `backlist_offender`, `backlist_threshold`, `lockout_period`, `days_to_keep_logs`, `created_at`, `updated_at`) VALUES
(1, 'You have been locked out of application due to too many failed login attempts.', 0, 15, 15, 0, '2016-11-29 23:28:42', '2016-11-29 23:28:42');

-- --------------------------------------------------------

--
-- Table structure for table `settings_system`
--

CREATE TABLE IF NOT EXISTS `settings_system` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `log_level` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purge_log` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `api_enable` int(11) NOT NULL,
  `api_key_mandatory` int(11) NOT NULL,
  `api_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_farmat` int(10) unsigned DEFAULT NULL,
  `date_format` int(10) unsigned DEFAULT NULL,
  `date_time_format` int(10) unsigned DEFAULT NULL,
  `day_date_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_zone` int(10) unsigned DEFAULT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `time_farmat` (`time_farmat`),
  KEY `date_format` (`date_format`),
  KEY `date_time_format` (`date_time_format`),
  KEY `time_zone` (`time_zone`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `settings_system`
--

INSERT INTO `settings_system` (`id`, `status`, `url`, `name`, `department`, `page_size`, `log_level`, `purge_log`, `api_enable`, `api_key_mandatory`, `api_key`, `name_format`, `time_farmat`, `date_format`, `date_time_format`, `day_date_time`, `time_zone`, `content`, `version`, `created_at`, `updated_at`) VALUES
(1, 1, '', '', '1', '', '', '', 0, 0, '', '', NULL, NULL, 1, '', 32, '', '', '2016-11-29 23:28:16', '2016-11-29 23:28:16'),
(2, 1, '', '', '1', '', '', '', 0, 0, '', '', NULL, NULL, 1, '', 79, '', '1.0.8.0', '2016-11-29 23:28:47', '2016-11-29 23:28:47');

-- --------------------------------------------------------

--
-- Table structure for table `settings_ticket`
--

CREATE TABLE IF NOT EXISTS `settings_ticket` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `num_format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `num_sequence` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sla` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `help_topic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `max_open_ticket` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collision_avoid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lock_ticket_frequency` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `captcha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `claim_response` tinyint(1) NOT NULL,
  `assigned_ticket` tinyint(1) NOT NULL,
  `answered_ticket` tinyint(1) NOT NULL,
  `agent_mask` tinyint(1) NOT NULL,
  `html` tinyint(1) NOT NULL,
  `client_update` tinyint(1) NOT NULL,
  `max_file_size` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings_ticket`
--

INSERT INTO `settings_ticket` (`id`, `num_format`, `num_sequence`, `priority`, `sla`, `help_topic`, `max_open_ticket`, `collision_avoid`, `lock_ticket_frequency`, `captcha`, `status`, `claim_response`, `assigned_ticket`, `answered_ticket`, `agent_mask`, `html`, `client_update`, `max_file_size`, `created_at`, `updated_at`) VALUES
(1, '$$$$-####-####', 'sequence', '1', '2', '1', '', '2', '0', '', 1, 0, 0, 0, 0, 0, 0, 0, '2016-11-29 23:28:17', '2016-11-29 23:28:17');

-- --------------------------------------------------------

--
-- Table structure for table `sla_plan`
--

CREATE TABLE IF NOT EXISTS `sla_plan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grace_period` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `transient` tinyint(1) NOT NULL,
  `ticket_overdue` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sla_plan`
--

INSERT INTO `sla_plan` (`id`, `name`, `grace_period`, `admin_note`, `status`, `transient`, `ticket_overdue`, `created_at`, `updated_at`) VALUES
(1, 'Sla 1', '6 Hours', '', 1, 0, 0, '2016-11-29 23:28:11', '2016-11-29 23:28:11'),
(2, 'Sla 2', '12 Hours', '', 1, 0, 0, '2016-11-29 23:28:11', '2016-11-29 23:28:11'),
(3, 'Sla 3', '24 Hours', '', 1, 0, 0, '2016-11-29 23:28:12', '2016-11-29 23:28:12');

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

CREATE TABLE IF NOT EXISTS `social_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `team_lead` int(10) unsigned DEFAULT NULL,
  `assign_alert` tinyint(1) NOT NULL,
  `admin_notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_lead` (`team_lead`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `status`, `team_lead`, `assign_alert`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 'Level 1 Support', 1, NULL, 0, '', '2016-11-29 23:28:14', '2016-11-29 23:28:14'),
(2, 'Level 2 Support', 0, NULL, 0, '', '2016-11-29 23:28:14', '2016-11-29 23:28:14'),
(3, 'Developer', 0, NULL, 0, '', '2016-11-29 23:28:14', '2016-11-29 23:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `team_assign_agent`
--

CREATE TABLE IF NOT EXISTS `team_assign_agent` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(10) unsigned DEFAULT NULL,
  `agent_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_id` (`team_id`),
  KEY `agent_id` (`agent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `team_assign_agent`
--

INSERT INTO `team_assign_agent` (`id`, `team_id`, `agent_id`, `created_at`, `updated_at`) VALUES
(1, 1, 4, NULL, NULL),
(2, 1, 5, NULL, NULL),
(3, 2, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE IF NOT EXISTS `template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `template_set_to_clone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `variable` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `set_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `variable`, `type`, `subject`, `message`, `description`, `set_id`, `created_at`, `updated_at`) VALUES
(1, 'This template is for sending notice to agent when ticket is assigned to them', '0', 1, '', '<div>Hello {!!$ticket_agent_name!!},<br /><br /><b>Ticket No:</b> {!!$ticket_number!!}<br />Has been assigned to you by {!!$ticket_assigner!!} <br /><br />Thank You<br />Kind Regards,<br /> {!!$system_from!!}</div>', '', 1, '2016-11-29 23:28:44', '2016-11-29 23:28:44'),
(2, 'This template is for sending notice to client with ticket link to check ticket without logging in to system', '1', 2, 'Check your Ticket', '<div>Hello {!!$user!!},<br /><br />Click the link below to view your requested ticket<br /> {!!$ticket_link_with_number!!}<br /><br />Kind Regards,<br /> {!!$system_from!!}</div>', '', 1, '2016-11-29 23:28:44', '2016-11-29 23:28:44'),
(3, 'This template is for sending notice to client when ticket status is changed to close', '0', 3, '', '<div>Hello,<br /><br />This message is regarding your ticket ID {!!$ticket_number!!}. We are changing the status of this ticket to "Closed" as the issue appears to be resolved.<br /><br />Thank you<br />Kind regards,<br /> {!!$system_from!!}</div>', '', 1, '2016-11-29 23:28:44', '2016-11-29 23:28:44'),
(4, 'This template is for sending notice to client on successful ticket creation', '0', 4, '', '<div><span>Hello {!!$user!!}<br /><br /></span><span>Thank you for contacting us. This is an automated response confirming the receipt of your ticket. Our team will get back to you as soon as possible. When replying, please make sure that the ticket ID is kept in the subject so that we can track your replies.<br /><br /></span><span><b>Ticket ID:</b> {!!$ticket_number!!} <br /><br /></span><span> {!!$department_sign!!}<br /></span>You can check the status of or update this ticket online at: {!!$system_link!!}</div>', '', 1, '2016-11-29 23:28:44', '2016-11-29 23:28:44'),
(5, 'This template is for sending notice to agent on new ticket creation', '0', 5, '', '<div>Hello {!!$ticket_agent_name!!},<br /><br />New ticket {!!$ticket_number!!}created <br /><br /><b>From</b><br /><b>Name:</b> {!!$ticket_client_name!!}   <br /><b>E-mail:</b> {!!$ticket_client_email!!}<br /><br /> {!!$content!!}<br /><br />Kind Regards,<br /> {!!$system_from!!}</div>', '', 1, '2016-11-29 23:28:44', '2016-11-29 23:28:44'),
(6, 'This template is for sending notice to client on new ticket created by agent in name of client', '0', 6, '', '<div> {!!$content!!}<br /><br /> {!!$agent_sign!!}<br /><br />You can check the status of or update this ticket online at: {!!$system_link!!}</div>', '', 1, '2016-11-29 23:28:45', '2016-11-29 23:28:45'),
(7, 'This template is for sending notice to client on new registration during new ticket creation for un registered clients', '1', 7, 'Registration Confirmation', '<p>Hello {!!$user!!}, </p><p>This email is confirmation that you are now registered at our helpdesk.</p><p><b>Registered Email:</b> {!!$email_address!!}</p><p><b>Password:</b> {!!$user_password!!}</p><p>You can visit the helpdesk to browse articles and contact us at any time: {!!$system_link!!}</p><p>Thank You.</p><p>Kind Regards,</p><p> {!!$system_from!!} </p>', '', 1, '2016-11-29 23:28:45', '2016-11-29 23:28:45'),
(8, 'This template is for sending notice to any user about reset password option', '1', 8, 'Reset your Password', 'Hello {!!$user!!},<br /><br />You asked to reset your password. To do so, please click this link:<br /><br /> {!!$password_reset_link!!}<br /><br />This will let you change your password to something new. If you didn''t ask for this, don''t worry, we''ll keep your password safe.<br /><br />Thank You.<br /><br />Kind Regards,<br /> {!!$system_from!!}', '', 1, '2016-11-29 23:28:45', '2016-11-29 23:28:45'),
(9, 'This template is for sending notice to client when a reply made to his/her ticket', '0', 9, '', '<span></span><div><span></span><p> {!!$content!!}<br /></p><p> {!!$agent_sign!!} </p><p><b>Ticket Details</b></p><p><b>Ticket ID:</b> {!!$ticket_number!!}</p></div>', '', 1, '2016-11-29 23:28:45', '2016-11-29 23:28:45'),
(10, 'This template is for sending notice to agent when ticket reply is made by client on a ticket', '0', 10, '', '<div>Hello {!!$ticket_agent_name!!},<br /><b><br /></b>A reply been made to ticket {!!$ticket_number!!}<br /><b><br /></b><b>From<br /></b><b>Name: </b>{!!$ticket_client_name!!}<br /><b>E-mail: </b>{!!$ticket_client_email!!}<br /><b><br /></b> {!!$content!!}<br /><b><br /></b>Kind Regards,<br /> {!!$system_from!!}</div>', '', 1, '2016-11-29 23:28:45', '2016-11-29 23:28:45'),
(11, 'This template is for sending notice to client about registration confirmation link', '1', 11, 'Verify your email address', '<p>Hello {!!$user!!}, </p><p>This email is confirmation that you are now registered at our helpdesk.</p><p><b>Registered Email:</b> {!!$email_address!!}</p><p>Please click on the below link to activate your account and Login to the system {!!$password_reset_link!!}</p><p>Thank You.</p><p>Kind Regards,</p><p> {!!$system_from!!} </p>', '', 1, '2016-11-29 23:28:45', '2016-11-29 23:28:45'),
(12, 'This template is for sending notice to team when ticket is assigned to team', '1', 12, '', '<div>Hello {!!$ticket_agent_name!!},<br /><br /><b>Ticket No:</b> {!!$ticket_number!!}<br />Has been assigned to your team : {!!$team!!} by {!!$ticket_assigner!!} <br /><br />Thank You<br />Kind Regards,<br />{!!$system_from!!}</div>', '', 1, '2016-11-29 23:28:45', '2016-11-29 23:28:45'),
(13, 'This template is for sending notice to client when password is changed', '1', 13, 'Verify your email address', 'Hello {!!$user!!},<br /><br />Your password is successfully changed.Your new password is : {!!$user_password!!}<br /><br />Thank You.<br /><br />Kind Regards,<br /> {!!$system_from!!}', '', 1, '2016-11-29 23:28:46', '2016-11-29 23:28:46');

-- --------------------------------------------------------

--
-- Table structure for table `template_sets`
--

CREATE TABLE IF NOT EXISTS `template_sets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `template_sets`
--

INSERT INTO `template_sets` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'default', 1, '2016-11-29 23:28:42', '2016-11-29 23:28:42');

-- --------------------------------------------------------

--
-- Table structure for table `template_types`
--

CREATE TABLE IF NOT EXISTS `template_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `template_types`
--

INSERT INTO `template_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'assign-ticket', '2016-11-29 23:28:42', '2016-11-29 23:28:42'),
(2, 'check-ticket', '2016-11-29 23:28:42', '2016-11-29 23:28:42'),
(3, 'close-ticket', '2016-11-29 23:28:42', '2016-11-29 23:28:42'),
(4, 'create-ticket', '2016-11-29 23:28:42', '2016-11-29 23:28:42'),
(5, 'create-ticket-agent', '2016-11-29 23:28:42', '2016-11-29 23:28:42'),
(6, 'create-ticket-by-agent', '2016-11-29 23:28:43', '2016-11-29 23:28:43'),
(7, 'registration-notification', '2016-11-29 23:28:43', '2016-11-29 23:28:43'),
(8, 'reset-password', '2016-11-29 23:28:43', '2016-11-29 23:28:43'),
(9, 'ticket-reply', '2016-11-29 23:28:43', '2016-11-29 23:28:43'),
(10, 'ticket-reply-agent', '2016-11-29 23:28:43', '2016-11-29 23:28:43'),
(11, 'registration', '2016-11-29 23:28:43', '2016-11-29 23:28:43'),
(12, 'team_assign_ticket', '2016-11-29 23:28:43', '2016-11-29 23:28:43'),
(13, 'reset_new_password', '2016-11-29 23:28:43', '2016-11-29 23:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `dept_id` int(10) unsigned DEFAULT NULL,
  `team_id` int(10) unsigned DEFAULT NULL,
  `priority_id` int(10) unsigned DEFAULT NULL,
  `sla` int(10) unsigned DEFAULT NULL,
  `help_topic_id` int(10) unsigned DEFAULT NULL,
  `status` int(10) unsigned DEFAULT NULL,
  `rating` tinyint(1) NOT NULL,
  `ratingreply` tinyint(1) NOT NULL,
  `flags` int(11) NOT NULL,
  `ip_address` int(11) NOT NULL,
  `assigned_to` int(10) unsigned DEFAULT NULL,
  `lock_by` int(11) NOT NULL,
  `lock_at` datetime DEFAULT NULL,
  `source` int(10) unsigned DEFAULT NULL,
  `isoverdue` int(11) NOT NULL,
  `reopened` int(11) NOT NULL,
  `isanswered` int(11) NOT NULL,
  `html` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `closed` int(11) NOT NULL,
  `is_transferred` tinyint(1) NOT NULL,
  `transferred_at` datetime NOT NULL,
  `reopened_at` datetime DEFAULT NULL,
  `duedate` datetime DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `last_message_at` datetime DEFAULT NULL,
  `last_response_at` datetime DEFAULT NULL,
  `approval` int(11) NOT NULL,
  `follow_up` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `dept_id` (`dept_id`),
  KEY `team_id` (`team_id`),
  KEY `priority_id` (`priority_id`),
  KEY `sla` (`sla`),
  KEY `help_topic_id` (`help_topic_id`),
  KEY `status` (`status`),
  KEY `assigned_to` (`assigned_to`),
  KEY `source` (`source`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_number`, `user_id`, `dept_id`, `team_id`, `priority_id`, `sla`, `help_topic_id`, `status`, `rating`, `ratingreply`, `flags`, `ip_address`, `assigned_to`, `lock_by`, `lock_at`, `source`, `isoverdue`, `reopened`, `isanswered`, `html`, `is_deleted`, `closed`, `is_transferred`, `transferred_at`, `reopened_at`, `duedate`, `closed_at`, `last_message_at`, `last_response_at`, `approval`, `follow_up`, `created_at`, `updated_at`) VALUES
(1, 'AAAA-0000-0000', 2, 1, NULL, 1, 1, 1, 1, 0, 0, 0, 0, 4, 0, NULL, 3, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', NULL, '2016-11-30 11:46:00', NULL, NULL, NULL, 0, 0, '2016-11-30 00:16:00', '2016-11-30 00:29:01'),
(2, 'AAAA-0000-0001', 2, 1, NULL, 1, 1, 1, 1, 0, 0, 0, 0, NULL, 0, NULL, 3, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', NULL, '2016-11-30 11:47:29', NULL, NULL, NULL, 0, 0, '2016-11-30 00:17:29', '2016-11-30 00:17:29'),
(3, 'AAAA-0000-0002', 3, 1, NULL, 1, 1, 1, 1, 0, 0, 0, 0, NULL, 0, NULL, 3, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', NULL, '2016-11-30 11:49:15', NULL, NULL, NULL, 0, 0, '2016-11-30 00:19:15', '2016-11-30 00:19:15'),
(4, 'AAAA-0000-0003', 3, 2, NULL, 1, 1, 2, 1, 0, 0, 0, 0, 1, 0, NULL, 3, 0, 0, 1, 0, 0, 0, 0, '0000-00-00 00:00:00', NULL, '2016-11-30 11:52:34', NULL, NULL, NULL, 0, 0, '2016-11-30 00:22:34', '2016-11-30 00:28:23'),
(5, 'AAAA-0000-0004', 3, 1, NULL, 1, 1, 1, 5, 0, 0, 0, 0, NULL, 0, NULL, 3, 0, 0, 0, 0, 1, 0, 0, '0000-00-00 00:00:00', NULL, '2016-11-30 11:55:06', NULL, NULL, NULL, 0, 0, '2016-11-30 00:25:06', '2016-11-30 00:26:59');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_attachment`
--

CREATE TABLE IF NOT EXISTS `ticket_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thread_id` int(10) unsigned DEFAULT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file` mediumblob,
  PRIMARY KEY (`id`),
  KEY `thread_id` (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_collaborator`
--

CREATE TABLE IF NOT EXISTS `ticket_collaborator` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isactive` tinyint(1) NOT NULL,
  `ticket_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_form_data`
--

CREATE TABLE IF NOT EXISTS `ticket_form_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(10) unsigned DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_priority`
--

CREATE TABLE IF NOT EXISTS `ticket_priority` (
  `priority_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `priority` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority_urgency` tinyint(1) NOT NULL,
  `ispublic` tinyint(1) NOT NULL,
  `is_default` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`priority_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ticket_priority`
--

INSERT INTO `ticket_priority` (`priority_id`, `priority`, `status`, `priority_desc`, `priority_color`, `priority_urgency`, `ispublic`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Low', '1', 'Low', '#00a65a', 4, 1, '0', NULL, NULL),
(2, 'Normal', '1', 'Normal', '#00bfef', 3, 1, '1', NULL, NULL),
(3, 'High', '1', 'High', '#f39c11', 2, 1, '0', NULL, NULL),
(4, 'Emergency', '1', 'Emergency', '#dd4b38', 1, 1, '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_source`
--

CREATE TABLE IF NOT EXISTS `ticket_source` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `ticket_source`
--

INSERT INTO `ticket_source` (`id`, `name`, `value`, `css_class`) VALUES
(1, 'web', 'Web', 'fa fa-internet-explorer'),
(2, 'email', 'E-mail', 'fa fa-envelope'),
(3, 'agent', 'Agent Panel', 'fa fa-envelope'),
(4, 'facebook', 'Facebook', 'fa fa-facebook'),
(5, 'twitter', 'Twitter', 'fa fa-twitter'),
(6, 'call', 'Call', 'fa fa-phone'),
(7, 'chat', 'Chat', 'fa fa-comment'),
(8, 'web', 'Web', ''),
(9, 'email', 'E-mail', ''),
(10, 'agent', 'Agent Panel', '');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_status`
--

CREATE TABLE IF NOT EXISTS `ticket_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mode` int(11) NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flags` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `email_user` int(11) NOT NULL,
  `icon_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `properties` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ticket_status`
--

INSERT INTO `ticket_status` (`id`, `name`, `state`, `mode`, `message`, `flags`, `sort`, `email_user`, `icon_class`, `properties`, `created_at`, `updated_at`) VALUES
(1, 'Open', 'open', 3, 'Ticket have been Reopened by', 0, 1, 0, '', 'Open tickets.', '2016-11-29 23:28:10', '2016-11-29 23:28:10'),
(2, 'Resolved', 'closed', 1, 'Ticket have been Resolved by', 0, 2, 0, '', 'Resolved tickets.', '2016-11-29 23:28:10', '2016-11-29 23:28:10'),
(3, 'Closed', 'closed', 3, 'Ticket have been Closed by', 0, 3, 0, '', 'Closed tickets. Tickets will still be accessible on client and staff panels.', '2016-11-29 23:28:10', '2016-11-29 23:28:10'),
(4, 'Archived', 'archived', 3, 'Ticket have been Archived by', 0, 4, 0, '', 'Tickets only adminstratively available but no longer accessible on ticket queues and client panel.', '2016-11-29 23:28:10', '2016-11-29 23:28:10'),
(5, 'Deleted', 'deleted', 3, 'Ticket have been Deleted by', 0, 5, 0, '', 'Tickets queued for deletion. Not accessible on ticket queues.', '2016-11-29 23:28:10', '2016-11-29 23:28:10'),
(6, 'Unverified', 'unverified', 3, 'User account verification required.', 0, 6, 0, '', 'Ticket will be open after user verifies his/her account.', '2016-11-29 23:28:11', '2016-11-29 23:28:11'),
(7, 'Request Approval', 'unverified', 3, 'Approval requested by', 0, 7, 0, '', 'Ticket will be approve  after Admin verifies  this ticket', '2016-11-29 23:28:11', '2016-11-29 23:28:11');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_thread`
--

CREATE TABLE IF NOT EXISTS `ticket_thread` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `poster` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `source` int(10) unsigned DEFAULT NULL,
  `reply_rating` int(11) NOT NULL,
  `rating_count` int(11) NOT NULL,
  `is_internal` tinyint(1) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` longblob,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_id_2` (`ticket_id`),
  KEY `user_id` (`user_id`),
  KEY `source` (`source`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `ticket_thread`
--

INSERT INTO `ticket_thread` (`id`, `ticket_id`, `user_id`, `poster`, `source`, `reply_rating`, `rating_count`, `is_internal`, `title`, `body`, `format`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'client', NULL, 0, 0, 0, 'Sizing defects ', 0x506c6561736520636865636b2073697a65206f662073686972742e, '', '', '2016-11-30 00:16:00', '2016-11-30 00:16:00'),
(2, 2, 2, 'client', NULL, 0, 0, 0, 'Colour effects', 0x4869207465616d2c3c62723e3c62723e49206d20676f742077726f6e6720636f6c6f7220706c656173652072657475726e206d79206f726465722e3c62723e3c62723e3c62723e3c62723e, '', '', '2016-11-30 00:17:29', '2016-11-30 00:17:29'),
(3, 3, 3, 'client', NULL, 0, 0, 0, 'Sewing defects', 0x746869732069732064656665637420636c6f74687320706c6561736520636865636b20616e642073656e64206d6520616761696e2e, '', '', '2016-11-30 00:19:15', '2016-11-30 00:19:15'),
(4, 4, 3, 'client', NULL, 0, 0, 0, 'Garment defects', 0x4869207465616d2c3c62723e3c62723e492077616e7420746f2072657475726e206d79206361736820626563617573652069206d206e6f74207361746973667920776974682073616c652e3c62723e3c62723e3c62723e3c62723e3c62723e3c62723e3c62723e, '', '', '2016-11-30 00:22:34', '2016-11-30 00:22:34'),
(5, 5, 3, 'client', NULL, 0, 0, 0, 'Return my cash', 0x4869205465616d2c3c62723e3c62723e4920676f742064616d61676520636c6f746820706c656173652072657475726e206d79206361736820415341502e3c62723e3c62723e3c62723e, '', '', '2016-11-30 00:25:06', '2016-11-30 00:25:06'),
(6, 5, 1, '', NULL, 0, 0, 1, '', 0x5469636b65742068617665206265656e2044656c657465642062792044656d6f61646d696e20466176656f, '', '', '2016-11-30 00:26:59', '2016-11-30 00:26:59'),
(7, 4, 1, '', NULL, 0, 0, 1, '', 0x54686973205469636b65742068617665206265656e2061737369676e656420746f2044656d6f61646d696e20466176656f, '', '', '2016-11-30 00:28:23', '2016-11-30 00:28:23'),
(8, 4, 1, 'support', NULL, 0, 0, 0, '', 0x486920636c616469612c3c62723e3c62723e417320736f6f6e20617320706f737369626c652077652077696c6c2072657475726e20796f757220636173682e3c62723e3c62723e, '', '', '2016-11-30 00:28:23', '2016-11-30 00:28:23'),
(9, 1, 1, '', NULL, 0, 0, 1, '', 0x54686973205469636b657420686173206265656e2061737369676e656420746f204a6f686e20706174656c, '', '', '2016-11-30 00:29:01', '2016-11-30 00:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_token`
--

CREATE TABLE IF NOT EXISTS `ticket_token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `timezone`
--

CREATE TABLE IF NOT EXISTS `timezone` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=114 ;

--
-- Dumping data for table `timezone`
--

INSERT INTO `timezone` (`id`, `name`, `location`) VALUES
(1, 'Pacific/Midway', '(GMT-11:00) Midway Island'),
(2, 'US/Samoa', '(GMT-11:00) Samoa'),
(3, 'US/Hawaii', '(GMT-10:00) Hawaii'),
(4, 'US/Alaska', '(GMT-09:00) Alaska'),
(5, 'US/Pacific', '(GMT-08:00) Pacific Time (US &amp; Canada)'),
(6, 'America/Tijuana', '(GMT-08:00) Tijuana'),
(7, 'US/Arizona', '(GMT-07:00) Arizona'),
(8, 'US/Mountain', '(GMT-07:00) Mountain Time (US &amp; Canada)'),
(9, 'America/Chihuahua', '(GMT-07:00) Chihuahua'),
(10, 'America/Mazatlan', '(GMT-07:00) Mazatlan'),
(11, 'America/Mexico_City', '(GMT-06:00) Mexico City'),
(12, 'America/Monterrey', '(GMT-06:00) Monterrey'),
(13, 'Canada/Saskatchewan', '(GMT-06:00) Saskatchewan'),
(14, 'US/Central', '(GMT-06:00) Central Time (US &amp; Canada)'),
(15, 'US/Eastern', '(GMT-05:00) Eastern Time (US &amp; Canada)'),
(16, 'US/East-Indiana', '(GMT-05:00) Indiana (East)'),
(17, 'America/Bogota', '(GMT-05:00) Bogota'),
(18, 'America/Lima', '(GMT-05:00) Lima'),
(19, 'America/Caracas', '(GMT-04:30) Caracas'),
(20, 'Canada/Atlantic', '(GMT-04:00) Atlantic Time (Canada)'),
(21, 'America/La_Paz', '(GMT-04:00) La Paz'),
(22, 'America/Santiago', '(GMT-04:00) Santiago'),
(23, 'Canada/Newfoundland', '(GMT-03:30) Newfoundland'),
(24, 'America/Buenos_Aires', '(GMT-03:00) Buenos Aires'),
(25, 'Greenland', '(GMT-03:00) Greenland'),
(26, 'Atlantic/Stanley', '(GMT-02:00) Stanley'),
(27, 'Atlantic/Azores', '(GMT-01:00) Azores'),
(28, 'Atlantic/Cape_Verde', '(GMT-01:00) Cape Verde Is.'),
(29, 'Africa/Casablanca', '(GMT) Casablanca'),
(30, 'Europe/Dublin', '(GMT) Dublin'),
(31, 'Europe/Lisbon', '(GMT) Lisbon'),
(32, 'Europe/London', '(GMT) London'),
(33, 'Africa/Monrovia', '(GMT) Monrovia'),
(34, 'Europe/Amsterdam', '(GMT+01:00) Amsterdam'),
(35, 'Europe/Belgrade', '(GMT+01:00) Belgrade'),
(36, 'Europe/Berlin', '(GMT+01:00) Berlin'),
(37, 'Europe/Bratislava', '(GMT+01:00) Bratislava'),
(38, 'Europe/Brussels', '(GMT+01:00) Brussels'),
(39, 'Europe/Budapest', '(GMT+01:00) Budapest'),
(40, 'Europe/Copenhagen', '(GMT+01:00) Copenhagen'),
(41, 'Europe/Ljubljana', '(GMT+01:00) Ljubljana'),
(42, 'Europe/Madrid', '(GMT+01:00) Madrid'),
(43, 'Europe/Paris', '(GMT+01:00) Paris'),
(44, 'Europe/Prague', '(GMT+01:00) Prague'),
(45, 'Europe/Rome', '(GMT+01:00) Rome'),
(46, 'Europe/Sarajevo', '(GMT+01:00) Sarajevo'),
(47, 'Europe/Skopje', '(GMT+01:00) Skopje'),
(48, 'Europe/Stockholm', '(GMT+01:00) Stockholm'),
(49, 'Europe/Vienna', '(GMT+01:00) Vienna'),
(50, 'Europe/Warsaw', '(GMT+01:00) Warsaw'),
(51, 'Europe/Zagreb', '(GMT+01:00) Zagreb'),
(52, 'Europe/Athens', '(GMT+02:00) Athens'),
(53, 'Europe/Bucharest', '(GMT+02:00) Bucharest'),
(54, 'Africa/Cairo', '(GMT+02:00) Cairo'),
(55, 'Africa/Harare', '(GMT+02:00) Harare'),
(56, 'Europe/Helsinki', '(GMT+02:00) Helsinki'),
(57, 'Europe/Istanbul', '(GMT+02:00) Istanbul'),
(58, 'Asia/Jerusalem', '(GMT+02:00) Jerusalem'),
(59, 'Europe/Kiev', '(GMT+02:00) Kyiv'),
(60, 'Europe/Minsk', '(GMT+02:00) Minsk'),
(61, 'Europe/Riga', '(GMT+02:00) Riga'),
(62, 'Europe/Sofia', '(GMT+02:00) Sofia'),
(63, 'Europe/Tallinn', '(GMT+02:00) Tallinn'),
(64, 'Europe/Vilnius', '(GMT+02:00) Vilnius'),
(65, 'Asia/Baghdad', '(GMT+03:00) Baghdad'),
(66, 'Asia/Kuwait', '(GMT+03:00) Kuwait'),
(67, 'Africa/Nairobi', '(GMT+03:00) Nairobi'),
(68, 'Asia/Riyadh', '(GMT+03:00) Riyadh'),
(69, 'Asia/Tehran', '(GMT+03:30) Tehran'),
(70, 'Europe/Moscow', '(GMT+04:00) Moscow'),
(71, 'Asia/Baku', '(GMT+04:00) Baku'),
(72, 'Europe/Volgograd', '(GMT+04:00) Volgograd'),
(73, 'Asia/Muscat', '(GMT+04:00) Muscat'),
(74, 'Asia/Tbilisi', '(GMT+04:00) Tbilisi'),
(75, 'Asia/Yerevan', '(GMT+04:00) Yerevan'),
(76, 'Asia/Kabul', '(GMT+04:30) Kabul'),
(77, 'Asia/Karachi', '(GMT+05:00) Karachi'),
(78, 'Asia/Tashkent', '(GMT+05:00) Tashkent'),
(79, 'Asia/Kolkata', '(GMT+05:30) Kolkata'),
(80, 'Asia/Kathmandu', '(GMT+05:45) Kathmandu'),
(81, 'Asia/Yekaterinburg', '(GMT+06:00) Ekaterinburg'),
(82, 'Asia/Almaty', '(GMT+06:00) Almaty'),
(83, 'Asia/Dhaka', '(GMT+06:00) Dhaka'),
(84, 'Asia/Novosibirsk', '(GMT+07:00) Novosibirsk'),
(85, 'Asia/Bangkok', '(GMT+07:00) Bangkok'),
(86, 'Asia/Ho_Chi_Minh', '(GMT+07.00) Ho Chi Minh'),
(87, 'Asia/Jakarta', '(GMT+07:00) Jakarta'),
(88, 'Asia/Krasnoyarsk', '(GMT+08:00) Krasnoyarsk'),
(89, 'Asia/Chongqing', '(GMT+08:00) Chongqing'),
(90, 'Asia/Hong_Kong', '(GMT+08:00) Hong Kong'),
(91, 'Asia/Kuala_Lumpur', '(GMT+08:00) Kuala Lumpur'),
(92, 'Australia/Perth', '(GMT+08:00) Perth'),
(93, 'Asia/Singapore', '(GMT+08:00) Singapore'),
(94, 'Asia/Taipei', '(GMT+08:00) Taipei'),
(95, 'Asia/Ulaanbaatar', '(GMT+08:00) Ulaan Bataar'),
(96, 'Asia/Urumqi', '(GMT+08:00) Urumqi'),
(97, 'Asia/Irkutsk', '(GMT+09:00) Irkutsk'),
(98, 'Asia/Seoul', '(GMT+09:00) Seoul'),
(99, 'Asia/Tokyo', '(GMT+09:00) Tokyo'),
(100, 'Australia/Adelaide', '(GMT+09:30) Adelaide'),
(101, 'Australia/Darwin', '(GMT+09:30) Darwin'),
(102, 'Asia/Yakutsk', '(GMT+10:00) Yakutsk'),
(103, 'Australia/Brisbane', '(GMT+10:00) Brisbane'),
(104, 'Australia/Canberra', '(GMT+10:00) Canberra'),
(105, 'Pacific/Guam', '(GMT+10:00) Guam'),
(106, 'Australia/Hobart', '(GMT+10:00) Hobart'),
(107, 'Australia/Melbourne', '(GMT+10:00) Melbourne'),
(108, 'Pacific/Port_Moresby', '(GMT+10:00) Port Moresby'),
(109, 'Australia/Sydney', '(GMT+10:00) Sydney'),
(110, 'Asia/Vladivostok', '(GMT+11:00) Vladivostok'),
(111, 'Asia/Magadan', '(GMT+12:00) Magadan'),
(112, 'Pacific/Auckland', '(GMT+12:00) Auckland'),
(113, 'Pacific/Fiji', '(GMT+12:00) Fiji');

-- --------------------------------------------------------

--
-- Table structure for table `time_format`
--

CREATE TABLE IF NOT EXISTS `time_format` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `time_format`
--

INSERT INTO `time_format` (`id`, `format`) VALUES
(1, 'H:i:s'),
(2, 'H.i.s');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ban` tinyint(1) NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  `ext` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` int(11) NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `agent_sign` text COLLATE utf8_unicode_ci NOT NULL,
  `account_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assign_group` int(10) unsigned DEFAULT NULL,
  `primary_dpt` int(10) unsigned DEFAULT NULL,
  `agent_tzone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `daylight_save` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `limit_access` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `directory_listing` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vacation_mode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `internal_note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_mobile_unique` (`mobile`),
  KEY `assign_group_3` (`assign_group`),
  KEY `primary_dpt_2` (`primary_dpt`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `first_name`, `last_name`, `gender`, `email`, `ban`, `password`, `active`, `ext`, `country_code`, `phone_number`, `mobile`, `agent_sign`, `account_type`, `account_status`, `assign_group`, `primary_dpt`, `agent_tzone`, `daylight_save`, `limit_access`, `directory_listing`, `vacation_mode`, `company`, `role`, `internal_note`, `profile_pic`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'demo@admin.com', 'Demoadmin', 'Faveo', 0, 'demo@admin.com', 0, '$2y$10$ewEDeTT7ax5u6lCcCrJL6OClWB6Eo/6GbeJY8MMrJZCjvsbJI84XS', 1, '', 0, '', NULL, '', '', '', 1, 1, '', '', '', '', '', '', 'admin', '', '', 'oFeQJKpu1OlZveLPEghCRlF925TutWTkj5TNoX5jIzjkVzVYNAHC9TtCP1Kr', '2016-11-29 23:28:47', '2016-11-30 00:31:09'),
(2, 'jalafa', 'Jalafa', 'kk', 0, 'jalafa@gmail.com', 0, '$2y$10$F26IyAQOJIzjBs4p0j5K7ugSDDxT2dRSqbAeC8d0CdCG/pwN64qVq', 1, '', 91, '', '9285631230', '', '', '', NULL, NULL, '', '', '', '', '', '', 'user', '', '', NULL, '2016-11-29 23:37:34', '2016-11-29 23:37:34'),
(3, 'cladia', 'Cladia', 'Singh', 0, 'cladia@yahoo.com', 0, '$2y$10$MXupcdivLoWZuNnVeHHTHOQSMF11iXkhY7AvToYiF2/PMutrilJce', 1, '', 91, '', '7865236524', '', '', '', NULL, NULL, '', '', '', '', '', '', 'user', '', '', NULL, '2016-11-29 23:39:51', '2016-11-29 23:39:51'),
(4, 'John', 'John', 'patel', 0, 'john@gmail.com', 0, '$2y$10$H5jyw8QbTdu11Rezoe8kUexS5pP6GHIhJUOQRL8jLRriaOAtfSONm', 1, '', 91, '', '6983524178', '', '', '', 1, 1, '79', '', '', '', '', '', 'agent', '', '', NULL, '2016-11-29 23:43:01', '2016-11-29 23:43:02'),
(5, 'Baladdin', 'Baladin', 'khan', 0, 'baladdin@gmail.com', 0, '$2y$10$0iz73EdhcHGKI3H5oQmnZeUXVvqEzCsXpjTuc88ihNmHeJG18xZXG', 1, '', 91, '', '7896325412', '', '', '', 2, 2, '79', '', '', '', '', '', 'agent', '', '', NULL, '2016-11-29 23:45:08', '2016-11-29 23:45:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_additional_infos`
--

CREATE TABLE IF NOT EXISTS `user_additional_infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `service` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_assign_organization`
--

CREATE TABLE IF NOT EXISTS `user_assign_organization` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `org_id` (`org_id`),
  KEY `user_id` (`user_id`)
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `user_notification`
--

INSERT INTO `user_notification` (`id`, `notification_id`, `user_id`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 0, '2016-11-30 00:16:00', '2016-11-30 00:16:00'),
(2, 1, 1, 0, '2016-11-30 00:16:00', '2016-11-30 00:16:00'),
(3, 2, 4, 0, '2016-11-30 00:17:29', '2016-11-30 00:17:29'),
(4, 2, 1, 0, '2016-11-30 00:17:29', '2016-11-30 00:17:29'),
(5, 3, 4, 0, '2016-11-30 00:19:15', '2016-11-30 00:19:15'),
(6, 3, 1, 0, '2016-11-30 00:19:15', '2016-11-30 00:19:15'),
(7, 4, 5, 0, '2016-11-30 00:22:34', '2016-11-30 00:22:34'),
(8, 4, 1, 0, '2016-11-30 00:22:34', '2016-11-30 00:22:34'),
(9, 5, 4, 0, '2016-11-30 00:25:06', '2016-11-30 00:25:06'),
(10, 5, 1, 0, '2016-11-30 00:25:06', '2016-11-30 00:25:06'),
(11, 6, 5, 0, '2016-11-30 00:28:23', '2016-11-30 00:28:23'),
(12, 6, 1, 0, '2016-11-30 00:28:23', '2016-11-30 00:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `version_check`
--

CREATE TABLE IF NOT EXISTS `version_check` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `current_version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `version_check`
--

INSERT INTO `version_check` (`id`, `current_version`, `new_version`, `created_at`, `updated_at`) VALUES
(1, '', '', '2016-11-29 23:28:17', '2016-11-29 23:28:17');

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE IF NOT EXISTS `widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `name`, `title`, `value`, `created_at`, `updated_at`) VALUES
(1, 'footer1', 'Products', '<ul><li>Men</li><li>Women</li><li>Kids</li><li>Decor</li><li>Wedding Cloth<b><br /></b></li></ul>', '2016-11-29 23:28:18', '2016-11-29 23:47:56'),
(2, 'footer2', 'Company', '<ul><li>About Us</li><li>Road Map</li><li>Privacy Policy</li><li>Cancellation &amp; Refund Policy<br /></li><li>Term &amp; Condition</li></ul>', '2016-11-29 23:28:18', '2016-11-29 23:48:39'),
(3, 'footer3', 'Find out More', '<ul><li>Forums</li><li>News</li><li>Blog</li><li>Partner NOC Directory</li></ul>', '2016-11-29 23:28:18', '2016-11-29 23:49:14'),
(4, 'footer4', 'Contact Us', '<div><div><div><span></span><div>\r\n                                        <p><i>BTM Layout, No: #28<br />9th Cross First Stage BTM Layout Near Water Tank<br /></i><i>Bangalore – 560 029</i><br /><i>Karnataka – India<br /></i><i>Telephone: </i><i>+91 9999999999<br /></i><i>Email: </i><a><i>   support@abcclothing.com</i></a></p>\r\n                                    </div>\r\n                                \r\n                            </div>\r\n                        </div></div>', '2016-11-29 23:28:18', '2016-11-29 23:50:04'),
(5, 'side1', NULL, NULL, '2016-11-29 23:28:18', '2016-11-29 23:28:18'),
(6, 'side2', NULL, NULL, '2016-11-29 23:28:18', '2016-11-29 23:28:18'),
(7, 'linkedin', NULL, NULL, '2016-11-29 23:28:19', '2016-11-29 23:28:19'),
(8, 'stumble', NULL, NULL, '2016-11-29 23:28:19', '2016-11-29 23:28:19'),
(9, 'google', NULL, NULL, '2016-11-29 23:28:19', '2016-11-29 23:28:19'),
(10, 'deviantart', NULL, NULL, '2016-11-29 23:28:19', '2016-11-29 23:28:19'),
(11, 'flickr', NULL, NULL, '2016-11-29 23:28:19', '2016-11-29 23:28:19'),
(12, 'skype', NULL, NULL, '2016-11-29 23:28:19', '2016-11-29 23:28:19'),
(13, 'rss', NULL, NULL, '2016-11-29 23:28:19', '2016-11-29 23:28:19'),
(14, 'twitter', NULL, NULL, '2016-11-29 23:28:20', '2016-11-29 23:28:20'),
(15, 'facebook', NULL, NULL, '2016-11-29 23:28:20', '2016-11-29 23:28:20'),
(16, 'youtube', NULL, NULL, '2016-11-29 23:28:20', '2016-11-29 23:28:20'),
(17, 'vimeo', NULL, NULL, '2016-11-29 23:28:20', '2016-11-29 23:28:20'),
(18, 'pinterest', NULL, NULL, '2016-11-29 23:28:20', '2016-11-29 23:28:20'),
(19, 'dribbble', NULL, NULL, '2016-11-29 23:28:20', '2016-11-29 23:28:20'),
(20, 'instagram', NULL, NULL, '2016-11-29 23:28:20', '2016-11-29 23:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `workflow_action`
--

CREATE TABLE IF NOT EXISTS `workflow_action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `workflow_id` int(10) unsigned NOT NULL,
  `condition` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflow_action_1` (`workflow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `workflow_close`
--

CREATE TABLE IF NOT EXISTS `workflow_close` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `days` int(11) NOT NULL,
  `condition` int(11) NOT NULL,
  `send_email` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `workflow_close`
--

INSERT INTO `workflow_close` (`id`, `days`, `condition`, `send_email`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 3, '2016-11-29 23:27:58', '2016-11-29 23:27:58');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflow_rules_1` (`workflow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `canned_response`
--
ALTER TABLE `canned_response`
  ADD CONSTRAINT `canned_response_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_2` FOREIGN KEY (`manager`) REFERENCES `users` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`sla`) REFERENCES `sla_plan` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `emails`
--
ALTER TABLE `emails`
  ADD CONSTRAINT `emails_ibfk_3` FOREIGN KEY (`help_topic`) REFERENCES `help_topic` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `emails_ibfk_1` FOREIGN KEY (`department`) REFERENCES `department` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `emails_ibfk_2` FOREIGN KEY (`priority`) REFERENCES `ticket_priority` (`priority_id`) ON UPDATE NO ACTION;

--
-- Constraints for table `field_values`
--
ALTER TABLE `field_values`
  ADD CONSTRAINT `field_values_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `custom_form_fields` (`id`);

--
-- Constraints for table `group_assign_department`
--
ALTER TABLE `group_assign_department`
  ADD CONSTRAINT `group_assign_department_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `group_assign_department_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `help_topic`
--
ALTER TABLE `help_topic`
  ADD CONSTRAINT `help_topic_ibfk_6` FOREIGN KEY (`auto_assign`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `help_topic_ibfk_1` FOREIGN KEY (`custom_form`) REFERENCES `custom_forms` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `help_topic_ibfk_2` FOREIGN KEY (`department`) REFERENCES `department` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `help_topic_ibfk_3` FOREIGN KEY (`ticket_status`) REFERENCES `ticket_status` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `help_topic_ibfk_4` FOREIGN KEY (`priority`) REFERENCES `ticket_priority` (`priority_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `help_topic_ibfk_5` FOREIGN KEY (`sla_plan`) REFERENCES `sla_plan` (`id`);

--
-- Constraints for table `kb_article_relationship`
--
ALTER TABLE `kb_article_relationship`
  ADD CONSTRAINT `article_relationship_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `kb_category` (`id`),
  ADD CONSTRAINT `article_relationship_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `kb_article` (`id`);

--
-- Constraints for table `kb_comment`
--
ALTER TABLE `kb_comment`
  ADD CONSTRAINT `comment_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `kb_article` (`id`);

--
-- Constraints for table `organization`
--
ALTER TABLE `organization`
  ADD CONSTRAINT `organization_ibfk_1` FOREIGN KEY (`head`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `settings_system`
--
ALTER TABLE `settings_system`
  ADD CONSTRAINT `settings_system_ibfk_4` FOREIGN KEY (`date_time_format`) REFERENCES `date_time_format` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `settings_system_ibfk_1` FOREIGN KEY (`time_zone`) REFERENCES `timezone` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `settings_system_ibfk_2` FOREIGN KEY (`time_farmat`) REFERENCES `time_format` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `settings_system_ibfk_3` FOREIGN KEY (`date_format`) REFERENCES `date_format` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`team_lead`) REFERENCES `users` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `team_assign_agent`
--
ALTER TABLE `team_assign_agent`
  ADD CONSTRAINT `team_assign_agent_ibfk_2` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `team_assign_agent_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_9` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_4` FOREIGN KEY (`priority_id`) REFERENCES `ticket_priority` (`priority_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_5` FOREIGN KEY (`sla`) REFERENCES `sla_plan` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_6` FOREIGN KEY (`help_topic_id`) REFERENCES `help_topic` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_7` FOREIGN KEY (`status`) REFERENCES `ticket_status` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `tickets_ibfk_8` FOREIGN KEY (`source`) REFERENCES `ticket_source` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `ticket_attachment`
--
ALTER TABLE `ticket_attachment`
  ADD CONSTRAINT `ticket_attachment_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `ticket_thread` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `ticket_collaborator`
--
ALTER TABLE `ticket_collaborator`
  ADD CONSTRAINT `ticket_collaborator_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `ticket_collaborator_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `ticket_form_data`
--
ALTER TABLE `ticket_form_data`
  ADD CONSTRAINT `ticket_form_data_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `ticket_thread`
--
ALTER TABLE `ticket_thread`
  ADD CONSTRAINT `ticket_thread_ibfk_3` FOREIGN KEY (`source`) REFERENCES `ticket_source` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `ticket_thread_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `ticket_thread_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`primary_dpt`) REFERENCES `department` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`assign_group`) REFERENCES `groups` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `user_assign_organization`
--
ALTER TABLE `user_assign_organization`
  ADD CONSTRAINT `user_assign_organization_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_assign_organization_ibfk_1` FOREIGN KEY (`org_id`) REFERENCES `organization` (`id`) ON UPDATE NO ACTION;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
