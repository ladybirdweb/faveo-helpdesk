-- 
-- Alter users table add user_language column
-- 
ALTER TABLE `users` ADD `user_language` VARCHAR(10) NULL DEFAULT NULL AFTER `updated_at`;

--
-- Alter emails table make user_name colums as nullable
--
ALTER TABLE `emails` CHANGE `user_name` `user_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;

-- 
-- Alter migration table
-- 
ALTER TABLE `migrations` ADD `id` INT NOT NULL AUTO_INCREMENT AFTER `batch`, ADD PRIMARY KEY (`id`);

--
-- Delete side1 and side2 from widgets
--
DELETE FROM `widgets` WHERE `widgets`.`id` = 5;
DELETE FROM `widgets` WHERE `widgets`.`id` = 6;
