SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for emails
-- ----------------------------
-- DROP TABLE IF EXISTS `emails`;
CREATE TABLE `emails` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_sent` datetime DEFAULT NULL,
  `subject` varchar(256) DEFAULT NULL,
  `sent_from` varchar(128) DEFAULT NULL,
  `sent_to` varchar(128) DEFAULT NULL,
  `sent_cc` varchar(128) DEFAULT NULL,
  `body` text,
  `ip` varchar(48) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
