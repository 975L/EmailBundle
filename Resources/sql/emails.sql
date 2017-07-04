/*
 * (c) 2017: 975l <contact@975l.com>
 * (c) 2017: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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


/*
Use the following if you want to archive your emails in anither table
*/
-- -------------------------------------
-- Table structure for emails_archives
-- -------------------------------------
-- DROP TABLE IF EXISTS `emails_archives`;
/*
CREATE TABLE `emails_archives` (
  `id` bigint(20) unsigned NOT NULL,
  `date_sent` datetime DEFAULT NULL,
  `subject` varchar(256) DEFAULT NULL,
  `sent_from` varchar(128) DEFAULT NULL,
  `sent_to` varchar(128) DEFAULT NULL,
  `sent_cc` varchar(128) DEFAULT NULL,
  `body` text,
  `ip` varchar(48) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
*/


-- Procedure to be launched to archive the emails
/*
DROP PROCEDURE IF EXISTS proc_EmailsArchives;
DELIMITER $
CREATE PROCEDURE proc_EmailsArchives()
LANGUAGE SQL NOT DETERMINISTIC CONTAINS SQL SQL SECURITY INVOKER
BEGIN
    -- Defines the date
    SELECT @DateArchivage := DATE_SUB(NOW(), INTERVAL 90 DAY);

    -- Inserts emails in archive
    INSERT INTO emails_archives (
        id,
        date_sent,
        subject,
        sent_from,
        sent_to,
        sent_cc,
        body,
        ip
        )
        SELECT
            id,
            date_sent,
            subject,
            sent_from,
            sent_to,
            sent_cc,
            body,
            ip
            FROM emails
            WHERE (date_sent < @DateArchivage);

    -- Deletes emails from source
    DELETE FROM emails
        WHERE (date_sent < @DateArchivage);
END$
DELIMITER ;
*/


-- Event to be scheduled to launch automatically the process of archiving
/*
DROP EVENT IF EXISTS e_monthly_archives;
CREATE EVENT e_monthly_archives
    ON SCHEDULE
    EVERY 1 MONTH STARTS '2016-12-01 02:00:00'
    DO
        CALL proc_EmailsArchives();
*/
