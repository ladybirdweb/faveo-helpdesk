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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `api_settings`
--

INSERT INTO `api_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'ticket_detail', '', '2016-05-26 06:48:39', '2016-05-26 06:48:39');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Dumping data for table `bar_notifications`
--

INSERT INTO `bar_notifications` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(23, 'new-version', '', '2016-06-12 23:13:46', '2016-06-12 23:13:46');

-- --------------------------------------------------------

--
-- Table structure for table `common_settings`
--

CREATE TABLE IF NOT EXISTS `common_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) NOT NULL,
  `option_value` varchar(500) NOT NULL,
  `status` varchar(255) NOT NULL,
  `optional_field` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `common_settings`
--

INSERT INTO `common_settings` (`id`, `option_name`, `option_value`, `status`, `optional_field`, `created_at`, `updated_at`) VALUES
(1, 'ticket_token_time_duration', '1', '', '', '2016-06-01 14:26:36', '2016-06-01 14:26:36');

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
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=240 ;

--
-- Dumping data for table `country_code`
--

INSERT INTO `country_code` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`, `created_at`, `updated_at`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', 'NUL', 0, 0, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', 'NUL', 0, 0, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', 'NUL', 0, 246, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226, '2016-05-11 07:08:05', '2016-05-11 07:08:05'),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', 'NUL', 0, 61, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', 'NUL', 0, 672, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(53, 'CI', 'COTE DIVOIRE', 'Cote DIvoire', 'CIV', 384, 225, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', 'NUL', 0, 0, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', 'NUL', 0, 0, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLES REPUBLIC OF', 'Korea, Democratic Peoples Republic of', 'PRK', 408, 850, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(116, 'LA', 'LAO PEOPLES DEMOCRATIC REPUBLIC', 'Lao Peoples Democratic Republic', 'LAO', 418, 856, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(137, 'YT', 'MAYOTTE', 'Mayotte', 'NUL', 0, 269, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', 'NUL', 0, 970, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', 'NUL', 0, 381, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', 'NUL', 0, 0, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', 'NUL', 0, 670, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', 'NUL', 0, 1, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260, '2016-05-11 07:08:06', '2016-05-11 07:08:06'),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263, '2016-05-11 07:08:06', '2016-05-11 07:08:06');

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

ALTER TABLE `emails`
  ADD `smtp_validate` varchar(222) NOT NULL AFTER `sending_encryption`, 
  ADD `smtp_authentication` varchar(222) NOT NULL AFTER `smtp_validate`;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `User` varchar(255) NOT NULL,
  `IP` varchar(20) NOT NULL,
  `Attempts` int(11) NOT NULL,
  `LastLogin` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL,
  `allow_modification` int(11) NOT NULL,
  `rating_scale` int(11) NOT NULL,
  `rating_area` varchar(255) NOT NULL,
  `restrict` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `name`, `display_order`, `allow_modification`, `rating_scale`, `rating_area`, `restrict`, `created_at`, `updated_at`) VALUES
(15, 'OverAll Satisfaction', 1, 1, 5, 'Helpdesk Area', 'General', '2016-06-01 06:42:57', '2016-06-01 06:42:57'),
(16, 'Reply Rating', 1, 1, 5, 'Comment Area', 'General', '2016-06-01 06:44:09', '2016-06-01 06:45:21');

-- --------------------------------------------------------

--
-- Table structure for table `rating_ref`
--

CREATE TABLE IF NOT EXISTS `rating_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rating_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `rating_value` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings_security`
--

CREATE TABLE IF NOT EXISTS `settings_security` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lockout_message` varchar(255) NOT NULL,
  `backlist_offender` int(11) NOT NULL,
  `backlist_threshold` int(11) NOT NULL,
  `lockout_period` int(11) NOT NULL,
  `days_to_keep_logs` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings_security`
--

INSERT INTO `settings_security` (`id`, `lockout_message`, `backlist_offender`, `backlist_threshold`, `lockout_period`, `days_to_keep_logs`, `updated_at`, `created_at`) VALUES
(1, 'You have been locked out of application due to too many failed login attempts.', 0, 344, 15, 0, '2016-06-02 04:44:50', '2016-04-22 07:56:09');

-- -----------------------------------------------------

--
-- Table structure for table `template_sets`
--

CREATE TABLE IF NOT EXISTS `template_sets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `template_sets`
--

INSERT INTO `template_sets` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'default', 1, '2016-05-11 03:40:19', '2016-05-11 05:43:32');

-- --------------------------------------------------------

--
-- Table structure for table `template_types`
--

CREATE TABLE IF NOT EXISTS `template_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `template_types`
--

INSERT INTO `template_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'assign-ticket', NULL, NULL),
(2, 'check-ticket', NULL, NULL),
(3, 'close-ticket', NULL, NULL),
(4, 'create-ticket', NULL, NULL),
(5, 'create-ticket-agent', NULL, NULL),
(6, 'create-ticket-by-agent', NULL, NULL),
(7, 'registration-notification', NULL, NULL),
(8, 'reset-password', NULL, NULL),
(9, 'ticket-reply', NULL, NULL),
(10, 'ticket-reply-agent', NULL, NULL),
(11, 'registration', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `variable` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT NULL,
  `set_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `templates_type_foreign` (`type`),
  KEY `set_id` (`set_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=79 ;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `variable`, `type`, `subject`, `message`, `description`, `created_at`, `updated_at`, `set_id`) VALUES
(1, 'This template is for sending notice to agent when ticket is assigned to them', '0', 1, '', '<div>Hello {!!$ticket_agent_name!!},<br><br>Ticket No: {!!$ticket_number!!}<br>Has been assigned to you by {!!$ticket_assigner!!}&nbsp;<br><br>Thank You<br>Kind Regards,<br>{!!$system_from!!}</div>', '', NULL, NULL, 1),
(2, 'This template is for sending notice to client with ticket link to check ticket without logging in to system', '1', 2, 'Check your Ticket', '<div>Hello {!!$user!!},<br><br>Click the link below to view your Requested ticket<br>{!!$ticket_link_with_number!!}<br><br>Kind Regards,<br>{!!$system_from!!} </div>', '', NULL, NULL, 1),
(3, 'This template is for sending notice to client when ticket status is changed to close', '0', 3, '', '<div>Hello,<br><br>This message is regarding your ticket ID {!!$ticket_number!!}. We are changing the status of this ticket to ''Closed'' as the issue appears to be resolved.<br><br>Thank you<br>Kind regards,<br> {!!$system_from!!} <br><br></div>', '', NULL, NULL, 1),
(4, 'This template is for sending notice to client on successful ticket creation', '0', 4, '', '<div><span>Hello {!!$user!!}<br><br></span><span>Thank you for contacting us. This is an automated response confirming the receipt of your ticket. Our team will get back to you as soon as possible. When replying, please make sure that the ticket ID is kept in the subject so that we can track your replies.<br><br></span><span>Ticket ID: {!!$ticket_number!!}&nbsp;<br></span><span>{!!$department_sign!!}<br></span>You can check the status of or update this ticket online at: {!!$system_link!!}</div>', '', NULL, NULL, 1),
(5, 'This template is for sending notice to agent on new ticket creation', '0', 5, '', '<div>Hello {!!$ticket_agent_name!!}, &nbsp; &nbsp; &nbsp;&nbsp;<br><br>New ticket {!!$ticket_number!!} created&nbsp;<br>From<br>Name :- {!!$ticket_client_name!!} &nbsp; &nbsp;<br>E-mail :- {!!$ticket_client_email!!} &nbsp;&nbsp;<br><br>{!!$content!!} &nbsp;&nbsp;&nbsp;&nbsp;<br><br>Kind Regards,<br>{!!$system_from!!}</div><br>', '', NULL, '2016-05-17 05:38:37', 1),
(6, 'This template is for sending notice to client on new ticket created by agent in name of client', '0', 6, '', '<div>{!!$content!!}<br><br>{!!$agent_sign!!}<br><br>You can check the status of or update this ticket online at: {!!$system_link!!}</div>', '', NULL, NULL, 1),
(7, 'This template is for sending notice to client on new registration during new ticket creation for un registered clients', '1', 7, 'Registration Confirmation', '<span><p>Hello {!!$user!!} ,&nbsp;</p><p>This email is confirmation that you are now registered at our helpdesk.</p><p>Registered Email: {!!$email_address!!}</p><p>Password: {!!$user_password!!}</p><p>You can visit the helpdesk to browse articles and contact us at any time: {!!$system_link!!}</p><p>Thank You.</p><p>Kind Regards,</p><p>{!!$system_from!!}&nbsp;</p></span>', '', NULL, NULL, 1),
(8, 'This template is for sending notice to any user about reset password option', '1', 8, 'Reset your Password', 'Hello {!!$user!!}<br/><br/>You asked to reset your password. To do so, please click this link:<br/><br/>{!!$password_reset_link!!}</a><br/><br/><br/>This will let you change your password to something new. If you didn''t ask for this, don''t worry, we''ll keep your password safe.<br/><br/>Thank You.<br/><br/>Kind Regards,<br/><br/> {!!$system_from!!}', '', NULL, NULL, 1),
(9, 'This template is for sending notice to client when a reply made to his/her ticket', '0', 9, '', '<span><div><span><p>{!!$content!!} &nbsp;&nbsp;<br></p><p>{!!$agent_sign!!}&nbsp;</p><p>Ticket Details</p><p>Ticket ID: {!!$ticket_number!!} &nbsp;&nbsp;&nbsp;&nbsp;</p><div><br></div></span><br></div><div><br></div></span>', '', NULL, NULL, 1),
(10, 'This template is for sending notice to agent when ticket reply is made by client on a ticket', '0', 10, '', '<div>Hello {!!$ticket_agent_name!!},<b><br></b>A reply been made to ticket {!!$ticket_number!!}<b><br></b>From<br>Name: {!!$ticket_client_name!!}<br>E-mail: {!!$ticket_client_email!!}<b><br></b>{!!$content!!}<b><br></b>Kind Regards,<br>{!!$system_from!!}</div>', '', NULL, NULL, 1),
(11, 'This template is for sending notice to client about registration confirmation link', '1', 11, 'Verify your email address', '<span><p>Hello {!!$user!!} ,&nbsp;</p><p>This email is confirmation that you are now registered at our helpdesk.</p><p>Registered Email: {!!$email_address!!}</p><p>Please click on the below link to activate your account and Login to the system {!!$password_reset_link!!}</p><p>Thank You.</p><p>Kind Regards,</p><p>{!!$system_from!!}&nbsp;</p></span>', '', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table alter for table `ticket_status`
--

ALTER TABLE `ticket_status`
  ADD `email_user` int(11) NOT NULL AFTER `sort`, 
  ADD `icon_class` varchar(222) NOT NULL AFTER `email_user`;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_token`
--

CREATE TABLE IF NOT EXISTS `ticket_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

ALTER TABLE `users` 
  ADD `country_code` int(11) NOT NULL AFTER `profile_pic`;

-- --------------------------------------------------------

--
-- Table structure for table `workflow_close`
--

CREATE TABLE IF NOT EXISTS `workflow_close` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `days` int(11) NOT NULL,
  `condition` int(11) NOT NULL,
  `send_email` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `workflow_close`
--

INSERT INTO `workflow_close` (`id`, `days`, `condition`, `send_email`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 3, '2016-05-25 07:52:22', '2016-05-25 02:22:22');

-- ----------------------------------------------------------

--
-- Alter Table structure for table `system_settings`
--
ALTER TABLE `settings_system` ADD `version` varchar(222) NOT NULL AFTER `time_zone`;

--
-- Dumping data for table `system_settings`
--

UPDATE `settings_system` SET `version`='1.0.7.7' WHERE 1;


ALTER TABLE `settings_ticket` ADD `lock_ticket_frequency` varchar(222) NOT NULL AFTER `max_file_size`;


UPDATE `settings_ticket` SET `lock_ticket_frequency`='0' WHERE 1;


TRUNCATE TABLE `user_notification`;

TRUNCATE TABLE `notifications`;