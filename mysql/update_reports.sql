ALTER TABLE `agenda_reports` ADD `clientUuid` CHAR(36) NOT NULL AFTER `post_date`;
ALTER TABLE `agenda_reports` ADD `post_updated` DATETIME NULL AFTER `post_date`;