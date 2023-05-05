ALTER TABLE `agenda_dates` ADD `clientUuid` CHAR(36) NOT NULL AFTER `userUuid`;
ALTER TABLE `agenda_dates` ADD `week` VARCHAR(2) NOT NULL AFTER `clientUuid`;
ALTER TABLE `agenda_dates` ADD `month` VARCHAR(20) NOT NULL AFTER `week`;