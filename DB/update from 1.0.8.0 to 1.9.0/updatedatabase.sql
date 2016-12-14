-- 
--  Alter users table 
-- 

ALTER TABLE `users` ADD `is_delete` BOOLEAN NOT NULL DEFAULT FALSE AFTER `remember_token`;

-- ---------------------------------------------------------------------------------------

-- 
--  Update table templates
-- 
UPDATE `templates`
SET `message` = '<div>Hello {!!$ticket_agent_name!!},<br /><br /><b>Ticket No:</b> {!!$ticket_number!!}<br />Has been assigned to you by {!!$ticket_assigner!!} <br/> Please check and resppond on the ticket.<br /> Link: {!!$ticket_link!!}<br /><br />Thank You<br />Kind Regards,<br /> {!!$system_from!!}</div>'
WHERE `type` = 1;

-- --------------------------------------------------------------------------------------

-- 
-- Update queue services tables
-- 
UPDATE `queue_services` SET `status` = 1 Where `name` LIKE 'Sync' OR `short_name` LIKE 'sync';
UPDATE `queue_services` SET `status` = 0 Where `name` NOT LIKE 'Sync' OR `short_name` NOT LIKE 'sync';
-- ----------------------------------------------------------------------------------------

-- 
-- Alter ticket priority color
-- 
UPDATE `ticket_priority` 
SET `priority_color` = '#00a65a'
WHERE `ticket_priority`.`priority` = "Low"; 

UPDATE `ticket_priority` 
SET `priority_color` = '#00bfef'
WHERE `ticket_priority`.`priority` = "Normal"; 

UPDATE `ticket_priority`
SET `priority_color` = '#f39c11'
WHERE `ticket_priority`.`priority` = "High";

UPDATE `ticket_priority` 
SET `priority_color` = '#dd4b38'
WHERE `ticket_priority`.`priority` = "Emergency";

UPDATE `ticket_priority` SET `is_default` = '1' WHERE `ticket_priority`.`priority_id` = 2;

-- ---------------------------------------------------------------------------------------------

-- 
-- Table structure for table `common_settings`
-- 

DROP TABLE IF EXISTS `common_settings`;

CREATE TABLE `common_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `option_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `option_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `optional_field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `common_settings`
-- 

INSERT INTO `common_settings` (`id`, `option_name`, `option_value`, `status`, `optional_field`, `created_at`, `updated_at`) VALUES
(1, 'ticket_token_time_duration', '1', '', '', '2016-12-13 05:01:02', '2016-12-13 05:01:02'),
(2, 'enable_rtl', '', '', '', '2016-12-13 05:01:02', '2016-12-13 05:01:02'),
(3, 'user_set_ticket_status', '', '1', '', '2016-12-13 05:01:02', '2016-12-13 05:01:02'),
(4, 'send_otp', '', '0', '', '2016-12-13 05:01:02', '2016-12-13 05:01:02'),
(5, 'email_mandatory', '', '1', '', '2016-12-13 05:01:02', '2016-12-13 05:01:02'),
(6, 'user_priority', '', '0', '', '2016-12-13 05:01:02', '2016-12-13 05:10:14');

-- 
-- Indexes for dumped tables
-- 

-- 
-- Indexes for table `common_settings`
-- 
ALTER TABLE `common_settings`
  ADD PRIMARY KEY (`id`);

-- 
-- AUTO_INCREMENT for dumped tables
-- 

-- 
-- AUTO_INCREMENT for table `common_settings`
-- 
ALTER TABLE `common_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

-- -------------------------------------------------------------------------------

