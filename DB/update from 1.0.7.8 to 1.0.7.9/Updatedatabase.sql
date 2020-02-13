-- ----------------------------------------------------------

--
-- Alter Table structure for table `common_settings`
--
INSERT INTO `common_settings` (`id`, `option_name`, `option_value`, `status`, `optional_field`, `created_at`, `updated_at`)
VALUES (5, 'email_mandatory', '',1,'','2016-06-14 09:07:17','2016-06-14 09:07:17');
-- INSERT INTO `ticket_status` (`id`, `name`, `state`, `mode`, `message`, `flags`, `sort`, `email_user`, `icon_class`, `properties`, `created_at`, `updated_at`)
-- VALUES (6, 'Unverified', 'unverified', 3, 'User account verification required.', 0, 6, 0, '', 'Ticket will be open after user verifies his/her account.', '2016-06-14 09:07:04', '2016-06-14 09:07:04');


-- ------------------------------------------------------

--
-- Table structure for table `field_values`
--

DROP TABLE IF EXISTS `field_values`;
CREATE TABLE IF NOT EXISTS `field_values` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `field_id` int(10) UNSIGNED DEFAULT NULL,
  `child_id` int(10) UNSIGNED DEFAULT NULL,
  `field_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `field_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_values_field_id_foreign` (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ------------------------------------------------------------

--
-- Update values in table `settings_ticket`
--
UPDATE `settings_ticket` SET `num_format` = '$$$$-####-####', `num_sequence` = 'sequence' WHERE `id` = 1;

-- --------------------------------------------------------------------