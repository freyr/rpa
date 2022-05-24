SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(100) DEFAULT NULL,
  `run_number` int(11) unsigned NOT NULL,
  `status` enum('ready','scheduled','sent_to_runner','succeeded','failed'),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

