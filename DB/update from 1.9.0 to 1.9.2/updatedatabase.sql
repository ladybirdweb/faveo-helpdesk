-- 
-- Dumping data for table `template_types`
-- 

INSERT INTO `template_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(14, 'merge-ticket-notification', '2017-01-02 05:50:11', '2017-01-02 05:50:11');

-- 
-- Dumping data for table `templates`
-- 

INSERT INTO `templates` (`name`, `variable`, `type`, `subject`, `message`, `description`, `set_id`, `created_at`, `updated_at`)
SELECT 'This template is to notify users when their tickets are merged.', '1', 14, 'Your tickets have been merged.', '<p>Hello {!!$user!!},<br />&nbsp;</p><p>Your ticket(s) with ticket number {!!$merged_ticket_numbers!!} have been closed and&nbsp;merged with <a href="{!!$ticket_link!!}">{!!$ticket_number!!}</a>.&nbsp;</p><p>Possible reasons for merging tickets</p><ul><li>Tickets are duplicate</li<li>Tickets state&nbsp;the same issue</li><li>Another member from your organization has created a ticket for the same issue</li></ul><p><a href="{!!$system_link!!}">Click here</a> to login to your account and check your tickets.</p><p>Regards,</p><p>{!!$system_from!!}</p>', '', id, '2017-01-02 05:50:12', '2017-01-02 06:01:50'
FROM `template_sets`;