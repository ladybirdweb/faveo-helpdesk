-- -----------------------------------------------------------

-- 
-- Table structure for table `conditions`
-- 

DROP TABLE IF EXISTS `conditions`;
CREATE TABLE IF NOT EXISTS `conditions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `job` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `failed_jobs`
-- 

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `faveo_mails`
-- 

DROP TABLE IF EXISTS `faveo_mails`;
CREATE TABLE IF NOT EXISTS `faveo_mails` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_id` int(11) NOT NULL,
  `drive` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `faveo_queues`
-- 

DROP TABLE IF EXISTS `faveo_queues`;
CREATE TABLE IF NOT EXISTS `faveo_queues` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

-- 
-- Table structure for table `jobs`
-- 

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_reserved_at_index` (`queue`,`reserved`,`reserved_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `mail_services`
-- 

DROP TABLE IF EXISTS `mail_services`;
CREATE TABLE IF NOT EXISTS `mail_services` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `mail_services`
-- 

INSERT INTO `mail_services` (`id`, `name`, `short_name`, `created_at`, `updated_at`) VALUES
(1, 'SMTP', 'smtp', '2016-10-09 15:32:44', '2016-10-09 15:32:44'),
(2, 'Php Mail', 'mail', '2016-10-09 15:32:44', '2016-10-09 15:32:44'),
(3, 'Send Mail', 'sendmail', '2016-10-09 15:32:44', '2016-10-09 15:32:44'),
(4, 'Mailgun', 'mailgun', '2016-10-09 15:32:44', '2016-10-09 15:32:44'),
(5, 'Mandrill', 'mandrill', '2016-10-09 15:32:44', '2016-10-09 15:32:44'),
(6, 'Log file', 'log', '2016-10-09 15:32:44', '2016-10-09 15:32:44');

-- --------------------------------------------------------

-- 
-- Table structure for table `queue_services`
-- 

DROP TABLE IF EXISTS `queue_services`;
CREATE TABLE IF NOT EXISTS `queue_services` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `queue_services`
-- 

INSERT INTO `queue_services` (`id`, `name`, `short_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Sync', 'sync', 1, '2016-10-09 15:32:44', '2016-10-09 16:05:03'),
(2, 'Database', 'database', 0, '2016-10-09 15:32:44', '2016-10-09 16:05:03'),
(3, 'Beanstalkd', 'beanstalkd', 0, '2016-10-09 15:32:44', '2016-10-09 15:32:44'),
(4, 'SQS', 'sqs', 0, '2016-10-09 15:32:44', '2016-10-09 15:32:44'),
(5, 'Iron', 'iron', 0, '2016-10-09 15:32:44', '2016-10-09 15:32:44'),
(6, 'Redis', 'redis', 0, '2016-10-09 15:32:44', '2016-10-09 15:32:44');

-- --------------------------------------------------------

-- 
-- Table structure for table `social_media`
-- 

DROP TABLE IF EXISTS `social_media`;
CREATE TABLE IF NOT EXISTS `social_media` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `user_additional_infos`
-- 

DROP TABLE IF EXISTS `user_additional_infos`;
CREATE TABLE IF NOT EXISTS `user_additional_infos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `service` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `approval`
-- 

DROP TABLE IF EXISTS `approval`;
CREATE TABLE IF NOT EXISTS `approval` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `approval`
-- 

INSERT INTO `approval` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'approval', '0', '2016-10-09 15:32:45', '2016-10-09 15:32:45');

-- --------------------------------------------------------

-- 
-- Table structure for table `followup`
-- 

DROP TABLE IF EXISTS `followup`;
CREATE TABLE IF NOT EXISTS `followup` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `condition` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `followup`
-- 

INSERT INTO `followup` (`id`, `name`, `status`, `condition`, `created_at`, `updated_at`) VALUES
(1, 'followup', '', '', '2016-10-09 15:32:45', '2016-10-09 15:32:45');

-- --------------------------------------------------------------------

-- 
-- Alter ticket_priority table
-- 
ALTER TABLE `ticket_priority` ADD (`status` tinyint(1) DEFAULT 0, `is_default` varchar(30));

-- 
-- Update ticket_priority table values
-- 
UPDATE `ticket_priority`
SET  `status` = 1
WHERE `priority` = 'Normal';

UPDATE `ticket_priority`
SET `priority_color` = '#80ff00'
WHERE `priority_id` = 1;

UPDATE `ticket_priority`
SET `priority_color` = '#367FA9'
WHERE `priority_id` = 2;

UPDATE `ticket_priority`
SET `priority_color` = '#ffff00'
WHERE `priority_id` = 3;

UPDATE `ticket_priority`
SET `priority_color` = '#ff6666'
WHERE `priority_id` = 4;
-- --------------------------------------------------------------------

-- 
-- Alter `users` table 
-- 
ALTER TABLE `users` MODIFY `mobile` VARCHAR(30) DEFAULT NULL;
UPDATE `users` SET `mobile` = NULL WHERE `mobile` = '';
ALTER TABLE `users` ADD UNIQUE (`mobile`);

-- ----------------------------------------------------------------------

-- 
-- Insert new values in `template_types` 
-- 
INSERT INTO `template_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(12, 'team_assign_ticket', '2016-10-10 01:29:36', '2016-10-10 01:29:36'),
(13, 'reset_new_password', '2016-10-10 01:29:36', '2016-10-10 01:29:36');

-- --------------------------------------------------------------------------

-- 
-- Insert new values in `templates` table
-- 
INSERT INTO `templates` (`id`, `name`, `variable`, `type`, `subject`, `message`, `description`, `set_id`, `created_at`, `updated_at`) VALUES
(12, 'This template is for sending notice to team when ticket is assigned to team', '1', 12, '', '<div>Hello {!!$ticket_agent_name!!},<br /><br /><b>Ticket No:</b> {!!$ticket_number!!}<br />Has been assigned to your team : {!!$team!!} by {!!$ticket_assigner!!} <br /><br />Thank You<br />Kind Regards,<br />{!!$system_from!!}</div>', '', 1, '2016-10-10 01:29:38', '2016-10-10 01:29:38'),
(13, 'This template is for sending notice to client when password is changed', '1', 13, 'Verify your email address', 'Hello {!!$user!!},<br /><br />Your password is successfully changed.Your new password is : {!!$user_password!!}<br /><br />Thank You.<br /><br />Kind Regards,<br /> {!!$system_from!!}', '', 1, '2016-10-10 01:29:38', '2016-10-10 01:29:38');
 -- --------------------------------------------------------------------------

-- 
-- Alter Table structure for table `ticket_source`
-- 

ALTER TABLE `ticket_source` ADD `css_class` VARCHAR(255) NULL AFTER `value`;
-- 
-- Dumping data for table `ticket_source`
-- 

INSERT INTO `ticket_source` (`id`, `name`, `value`, `css_class`) VALUES
(4, 'facebook', 'Facebook', 'fa fa-facebook'),
(5, 'twitter', 'Twitter', 'fa fa-twitter'),
(6, 'call', 'Call', 'fa fa-phone'),
(7, 'chat', 'Chat', 'fa fa-comment');

--  
-- Update table ticket_source
-- 
UPDATE `ticket_source` SET `css_class` = 'fa fa-internet-explorer' WHERE `id` = 1;
UPDATE `ticket_source` SET `css_class` = 'fa fa-envelope' WHERE `id` = 2;
UPDATE `ticket_source` SET `css_class` = 'fa fa-envelope' WHERE `id` = 3;

-- 
-- Alter tickets table
-- 

ALTER TABLE `tickets`
ADD COLUMN `approval` tinyint(10),
ADD COLUMN `follow_up` tinyint(10) ;