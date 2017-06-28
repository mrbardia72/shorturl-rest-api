CREATE TABLE `urls` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`url` VARCHAR(500) NOT NULL,
	`short_code` VARCHAR(15) NOT NULL,
	`create_date` DATE NOT NULL DEFAULT '0000-00-00',
	`create_time` TIME NOT NULL DEFAULT '00:00:00',
	`username` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=MyISAM
AUTO_INCREMENT=62
;
