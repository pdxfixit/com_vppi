CREATE TABLE IF NOT EXISTS `#__vppi_homes` (
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`name` VARCHAR(127)  NOT NULL ,
`alias` VARCHAR(127)  NOT NULL ,
`city` VARCHAR(127)  NOT NULL ,
`state_prov` VARCHAR(127)  NOT NULL ,
`zip_code` INT(11)  NOT NULL ,
`ml_number` INT(11)  NOT NULL ,
`price` DECIMAL (18,2)  NOT NULL ,
`area` VARCHAR(127)  NOT NULL ,
`elem_school` VARCHAR(127)  NOT NULL ,
`mid_school` VARCHAR(127)  NOT NULL ,
`high_school` VARCHAR(127)  NOT NULL ,
`short_sale` TINYINT(1)  NOT NULL ,
`bank_owned` TINYINT(1)  NOT NULL ,
`waterfront` VARCHAR(127)  NOT NULL ,
`body_of_water` VARCHAR(127)  NOT NULL ,
`tax_per_year` VARCHAR(127)  NOT NULL ,
`property_type` VARCHAR(127)  NOT NULL ,
`neighborhood_building` VARCHAR(127)  NOT NULL ,
`levels` TINYINT(2)  NOT NULL ,
`garage` VARCHAR(127)  NOT NULL ,
`roof` VARCHAR(127)  NOT NULL ,
`ext_description` VARCHAR(127)  NOT NULL ,
`mast_bed_level` VARCHAR(127)  NOT NULL ,
`fireplace` VARCHAR(127)  NOT NULL ,
`basement_foundation` VARCHAR(127)  NOT NULL ,
`view` VARCHAR(127)  NOT NULL ,
`acres` FLOAT(11, 2)  NOT NULL ,
`lot_size` VARCHAR(127)  NOT NULL ,
`lot_dimensions` VARCHAR(127)  NOT NULL ,
`lot_description` VARCHAR(127)  NOT NULL ,
`heat_fuel` VARCHAR(127)  NOT NULL ,
`cool` VARCHAR(127)  NOT NULL ,
`water` VARCHAR(127)  NOT NULL ,
`sewer` VARCHAR(127)  NOT NULL ,
`hot_water` VARCHAR(127)  NOT NULL ,
`zoning` VARCHAR(127)  NOT NULL ,
`remarks` TEXT  NOT NULL ,
`dining_room` VARCHAR(127)  NOT NULL ,
`family_room` VARCHAR(127)  NOT NULL ,
`living_room` VARCHAR(127)  NOT NULL ,
`kitchen` VARCHAR(127)  NOT NULL ,
`interior` VARCHAR(127)  NOT NULL ,
`exterior` VARCHAR(127)  NOT NULL ,
`accessibility` VARCHAR(127)  NOT NULL ,
`green_certification` VARCHAR(127)  NOT NULL ,
`energy_eff_features` VARCHAR(127)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`ordering` INT(11)  NOT NULL ,
`featured` TINYINT(1)  NOT NULL ,
`sold` TINYINT(1)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__vppi_images` (
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`home_id` INT(11)  NOT NULL ,
`name` VARCHAR (255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;
