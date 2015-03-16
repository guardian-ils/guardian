SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- ---------------------------------------------
-- Generate By MySQL Workbench
-- -----------------------------------------------------

CREATE SCHEMA IF NOT EXISTS `guardian` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `guardian` ;

-- -----------------------------------------------------
-- Table `guardian`.`branches`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`branches` (
  `branch_id` VARCHAR(16) NOT NULL COMMENT 'a unique key assigned to each branch',
  `branch_name` VARCHAR(64) NOT NULL COMMENT 'the name of your library or branch',
  `address` TEXT NULL DEFAULT NULL COMMENT 'the first address line of for your library or branch',
  `zip` VARCHAR(16) NULL DEFAULT NULL COMMENT 'the zip or postal code for your library or branch',
  `city` TEXT NULL DEFAULT NULL,
  `state` TEXT NULL DEFAULT NULL COMMENT 'the city or province for your library or branch',
  `country` VARCHAR(64) NULL DEFAULT NULL COMMENT 'the county for your library or branch',
  `phone` VARCHAR(16) NULL DEFAULT NULL COMMENT 'the primary phone for your library or branch',
  `fax` VARCHAR(16) NULL DEFAULT NULL COMMENT 'the fax number for your library or branch',
  `email` VARCHAR(64) NULL DEFAULT NULL COMMENT 'the primary email address for your library or branch',
  `url` VARCHAR(256) NULL DEFAULT NULL COMMENT 'the URL for your library or branch\'s website',
  `ip` VARCHAR(15) NULL DEFAULT NULL COMMENT 'the IP address for your library or branch',
  `note` TEXT NULL DEFAULT NULL COMMENT 'notes related to your library or branch',
  `branch_info` TEXT NULL DEFAULT NULL COMMENT 'HTML that displays in OPAC',
  PRIMARY KEY (`branch_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`categories` (
  `category_code` VARCHAR(16) NOT NULL COMMENT 'unique primary key used to idenfity the patron category',
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
  `auth_type_text` VARCHAR(256) NOT NULL,
  `auth_tag_to_report` VARCHAR(3) NULL,
  `sammary` TEXT NULL,
  PRIMARY KEY (`auth_type_code`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`table1`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`table1` (
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`buget_periods`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`buget_periods` (
  `buget_periods_id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '	primary key and unique number assigned by Guardian',
  `start_date` DATE NOT NULL COMMENT 'date when the budget starts',
  `end_date` DATE NOT NULL COMMENT '	date when the budget ends',
  `active` BIT NOT NULL DEFAULT 0 COMMENT 'whether this budget is active or not (1 for yes, 0 for no)',
  `description` TEXT NULL DEFAULT NULL COMMENT 'description assigned to this budget',
  `total` DECIMAL(28,2) NOT NULL DEFAULT 0 COMMENT 'total amount available in this budget',
  `locked` BIT NOT NULL DEFAULT 0 COMMENT 'whether this budget is locked or not (1 for yes, 0 for no)',
  PRIMARY KEY (`buget_periods_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`ethnicity`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`ethnicity` (
  `code` VARCHAR(16) NOT NULL,
  `name` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`code`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`collections`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`collections` (
  `collections_id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(64) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `branch_id` VARCHAR(16) NOT NULL COMMENT 'branchcode for branch where item should be held.',
  PRIMARY KEY (`collections_id`),
  INDEX `fk_collections_1_idx` (`branch_id` ASC),
  CONSTRAINT `fk_collections_1`
    FOREIGN KEY (`branch_id`)
    REFERENCES `guardian`.`branches` (`branch_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`auth_flag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`auth_flag` (
  `auth_flag_id` INT NOT NULL DEFAULT 0,
  `auth_name` VARCHAR(32) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `defaulton` INT NULL DEFAULT NULL,
  PRIMARY KEY (`auth_flag_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`borrowers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`borrowers` (
  `borrower_id` INT NOT NULL AUTO_INCREMENT COMMENT 'primary key, Guaridan assigned ID number for patrons/borrowers',
  `card_number` VARCHAR(16) NULL DEFAULT NULL COMMENT 'unique key, library assigned ID number for patrons/borrowers',
  `surname` VARCHAR(64) NOT NULL COMMENT 'patron/borrower\'s last name (surname)',
  `firstname` VARCHAR(128) NOT NULL COMMENT 'patron/borrower\'s first name',
  `title` VARCHAR(8) NOT NULL COMMENT 'patron/borrower\'s title, for example: Mr. or Mrs.',
  `user_id` VARCHAR(32) NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  `othername` VARCHAR(64) NULL DEFAULT NULL COMMENT 'any other names associated with the patron/borrower',
  `initials` VARCHAR(16) NULL DEFAULT NULL,
  `date_of_birth` DATE NOT NULL,
  `category_code` VARCHAR(256) NOT NULL,
  `branch_id` VARCHAR(16) NOT NULL,
  `date_enroll` DATE NOT NULL,
  `date_expire` DATE NOT NULL,
  `email` VARCHAR(256) NULL DEFAULT NULL COMMENT 'the email address for your patron/borrower',
  `phone` VARCHAR(16) NULL DEFAULT NULL,
  `address` TEXT NULL DEFAULT NULL COMMENT 'Address of borrowers',
  PRIMARY KEY (`borrower_id`),
  UNIQUE INDEX `card_number_UNIQUE` (`card_number` ASC),
  INDEX `fk_borrowers_1_idx` (`branch_id` ASC),
  INDEX `fk_borrowers_2_idx` (`category_code` ASC),
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC),
  INDEX `username` (`surname` ASC, `firstname` ASC),
  CONSTRAINT `fk_borrowers_1`
    FOREIGN KEY (`branch_id`)
    REFERENCES `guardian`.`branches` (`branch_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_borrowers_2`
    FOREIGN KEY (`category_code`)
    REFERENCES `guardian`.`categories` (`category_code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`biblio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`biblio` (
  `biblio_id` INT NOT NULL AUTO_INCREMENT COMMENT 'unique identifier assigned to each bibliographic record',
  `framework_code` VARCHAR(4) NOT NULL COMMENT 'foriegn key from the biblio_framework table to identify which framework was used in cataloging this record',
  `author` VARCHAR(256) NULL DEFAULT NULL COMMENT 'statement of responsibility from MARC record (100$a in MARC21)',
  `title` VARCHAR(512) NULL COMMENT 'title (without the subtitle) from the MARC record (245$a in MARC21)',
  `note` TEXT NULL DEFAULT NULL COMMENT 'values from the general notes field in the MARC record (500$a in MARC21) split by bar (|)',
  `serial` BIT NOT NULL DEFAULT 0 COMMENT 'Boolean indicating whether biblio is for a serial',
  `serial_title` VARCHAR(64) NULL DEFAULT NULL,
  `copyright_date` YEAR NULL DEFAULT NULL COMMENT 'publication or copyright date from the MARC record',
  `last_modified` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'date and time this record was last touched',
  `date_create` DATE NOT NULL COMMENT 'the date this record was added to Guardian',
  `sammary` TEXT NULL DEFAULT NULL COMMENT 'summary from the MARC record (520$a in MARC21)',
  PRIMARY KEY (`biblio_id`),
  INDEX `fk_biblio_1_idx` (`framework_code` ASC),
  CONSTRAINT `fk_biblio_1`
    FOREIGN KEY (`framework_code`)
    REFERENCES `guardian`.`biblio_framework` (`framework_code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`budget`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`budget` (
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guardian`.`default_circ_rule`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guardian`.`default_circ_rule` (
  `singleton` INT NOT NULL,
  `max_issue` INT UNSIGNED NOT NULL,
  `hold_allowed` INT UNSIGNED NOT NULL,
  `return_branch` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`singleton`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
