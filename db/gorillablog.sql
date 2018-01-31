CREATE SCHEMA IF NOT EXISTS `gorillablog`;

USE `gorillablog`;

CREATE TABLE IF NOT EXISTS `gorillablog`.`articles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `text` TEXT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
