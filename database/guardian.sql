SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `guardian` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `guardian` ;

-- -----------------------------------------------------
-- Table `guardian`.`branch`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`branch` (
  `branch_id` VARCHAR(10) NOT NULL COMMENT 'a unique key assigned to each branch',
  `branch_name` VARCHAR(45) NOT NULL COMMENT 'the name of your library or branch',
  `branch_address1` TEXT NULL DEFAULT NULL COMMENT 'the first address line of for your library or branch',
  `branch_address2` TEXT NULL DEFAULT NULL COMMENT 'the second address line of for your library or branch',
  `branch_address3` TEXT NULL DEFAULT NULL COMMENT 'the third address line of for your library or branch',
  `branch_zip` VARCHAR(16) NULL DEFAULT NULL COMMENT 'the zip or postal code for your library or branch',
  `branch_city` TEXT NULL DEFAULT NULL,
  `branch_state` TEXT NULL DEFAULT NULL COMMENT 'the city or province for your library or branch',
  `branch_country` VARCHAR(64) NULL DEFAULT NULL COMMENT 'the county for your library or branch',
  `branch_phone` VARCHAR(16) NULL DEFAULT NULL COMMENT 'the primary phone for your library or branch',
  `branch_fax` VARCHAR(16) NULL DEFAULT NULL COMMENT 'the fax number for your library or branch',
  `branch_email` VARCHAR(64) NULL DEFAULT NULL COMMENT 'the primary email address for your library or branch',
  `branch_url` VARCHAR(256) NULL DEFAULT NULL COMMENT 'the URL for your library or branch\'s website',
  `branch_ip` VARCHAR(15) NULL DEFAULT NULL COMMENT 'the IP address for your library or branch',
  `branch_note` TEXT NULL DEFAULT NULL COMMENT 'notes related to your library or branch',
  `branch_info` TEXT NULL DEFAULT NULL COMMENT 'HTML that displays in OPAC',
  PRIMARY KEY (`branch_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`categories` (
  `category_code` VARCHAR(10) NOT NULL COMMENT 'unique primary key used to idenfity the patron category',
  `description` TEXT NULL DEFAULT NULL COMMENT 'description of the patron category',
  `enrolment_period` INT(5) NULL DEFAULT NULL COMMENT 'number of months the patron is enrolled for (will be NULL if enrolmentperiod_date is set)',
  `enrolment_period_date` DATE NULL DEFAULT NULL,
  `upper_age_limit` INT(3) NULL DEFAULT NULL COMMENT 'age limit for the patron',
  `date_of_birth_require` BIT NULL DEFAULT NULL COMMENT 'Date of Birth require',
  `bulk` BIT NULL DEFAULT NULL,
  `enrolment_fee` DECIMAL NULL DEFAULT 0 COMMENT 'enrollment fee for the patron',
  `overdue_notice_require` BIT NULL DEFAULT 0,
  `reserve_fee` DECIMAL(28,6) NULL DEFAULT NULL COMMENT 'cost to place holds',
  `hide_lostitems` BIT NULL DEFAULT 0 COMMENT '	are lost items shown to this category (1 for yes, 0 for no)',
  `category_type` VARCHAR(1) NULL DEFAULT 'A' COMMENT '	type of Koha patron (Adult, Child, Professional, Organizational, Statistical, Staff)',
  PRIMARY KEY (`category_code`),
  UNIQUE INDEX `category_code_UNIQUE` (`category_code` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`itemtypes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`itemtypes` (
  `item_type` VARCHAR(10) NOT NULL COMMENT 'unique key, a code associated with the item type',
  `description` TEXT NULL DEFAULT NULL COMMENT 'a plain text explanation of the item type',
  `rental_charge` DOUBLE NULL DEFAULT NULL COMMENT 'the amount charged when this item is checked out/issued',
  `not_for_loan` BIT NULL DEFAULT 0 COMMENT '1 if the item is not for loan, 0 if the item is available for loan',
  `image_url` VARCHAR(256) NULL DEFAULT NULL COMMENT '	URL for the item type icon',
  `sammary` TEXT NULL DEFAULT NULL COMMENT 'information from the summary field, may include HTML',
  `check_in_msg` VARCHAR(256) NULL DEFAULT NULL COMMENT 'message that is displayed when an item with the given item type is checked in',
  `check_in_msg_type` CHAR(16) NULL DEFAULT 'message' COMMENT 'type (CSS class) for the checkinmsg, can be \"alert\" or \"message\"',
  PRIMARY KEY (`item_type`),
  UNIQUE INDEX `item_type_UNIQUE` (`item_type` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`biblio_framework`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`biblio_framework` (
  `framework_code` VARCHAR(4) NOT NULL COMMENT 'the unique code assigned to the framework',
  `framework_text` TEXT NULL COMMENT 'the description/name given to the framework',
  PRIMARY KEY (`framework_code`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`auth_types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`auth_types` (
  `auth_type_code` VARCHAR(10) NOT NULL,
  `auth_type_text` VARCHAR(256) NULL,
  `auth_tag_to_report` VARCHAR(3) NULL,
  `sammary` TEXT NULL,
  PRIMARY KEY (`auth_type_code`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
