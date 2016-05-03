SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+02:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `Searches`;
CREATE TABLE `Searches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `query` varchar(39) COLLATE utf8_czech_ci NOT NULL,
  `time` datetime NOT NULL,
  `ip` varchar(14) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;