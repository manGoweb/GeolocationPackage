
CREATE TABLE `geocoding_results` (
	`id` int(1) unsigned NOT NULL AUTO_INCREMENT,
	`latitude` float NOT NULL COMMENT 'zeměpisná šířka',
	`longitude` float NOT NULL COMMENT 'zeměpisná délka',
	`address_hash` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL COMMENT 'hash adresy',
	`address` text NOT NULL COMMENT 'serializovaná adresa',
	`inserted_at` datetime NOT NULL COMMENT 'datum vložení',
	PRIMARY KEY (`id`),
	UNIQUE KEY `address_hash` (`address_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `geocoding_positions` (
  `id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `latitude` float NOT NULL COMMENT 'zeměpisná šířka',
  `longitude` float NOT NULL COMMENT 'zeměpisná délka',
  `result_id` int(1) unsigned NOT NULL COMMENT 'nalezená adresa',
  PRIMARY KEY (`id`),
  UNIQUE KEY `latitude_longitude` (`latitude`,`longitude`),
  KEY `result_id` (`result_id`),
  CONSTRAINT `geocoding_positions_ibfk_1` FOREIGN KEY (`result_id`) REFERENCES `geocoding_results` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `geocoding_queries` (
  `id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `query` varchar(250) NOT NULL COMMENT 'hledaný řetězec adresy',
  `result_id` int(1) unsigned NOT NULL COMMENT 'nalezená adresa',
  PRIMARY KEY (`id`),
  UNIQUE KEY `query` (`query`),
  KEY `result_id` (`result_id`),
  CONSTRAINT `geocoding_queries_ibfk_1` FOREIGN KEY (`result_id`) REFERENCES `geocoding_results` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

