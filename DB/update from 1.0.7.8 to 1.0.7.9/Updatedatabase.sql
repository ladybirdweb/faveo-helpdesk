-- ----------------------------------------------------------

--
-- Alter Table structure for table `common_settings`
--
INSERT INTO `common_settings` (`id`, `option_name`, `option_value`, `status`, `optional_field`, `created_at`, `updated_at`)
VALUES (2, 'enable_rtl', '', '', '', '2016-06-14 09:07:17', '2016-06-14 09:07:17'),
       (3, 'user_set_ticket_status', '',1,'','2016-06-14 09:07:17','2016-06-14 09:07:17'),
       (4, 'send_otp', '',0,'','2016-06-14 09:07:17','2016-06-14 09:07:17');
INSERT INTO `ticket_status` (`id`, `name`, `state`, `mode`, `message`, `flags`, `sort`, `email_user`, `icon_class`, `properties`, `created_at`, `updated_at`)
VALUES (6, 'Unverified', 'unverified', 3, 'User account verification required.', 0, 6, 0, '', 'Ticket will be open after user verifies his/her account.', '2016-06-14 09:07:04', '2016-06-14 09:07:04');
